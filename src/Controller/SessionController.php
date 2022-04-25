<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Form\PropertySearchType;
use App\Repository\SessionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MyPropertySearch;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="app_session_index", methods={"GET", "POST"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $propertySearch = new MyPropertySearch();
        //si si aucun nom n'est fourni on affiche tous les articles
        $sessions= $this->getDoctrine()->getRepository(Session::class)->findAll();
        $form = $this->createForm(PropertySearchType::class, $propertySearch);
        $form->handleRequest($request);
        //initialement le tableau des articles est vide,
        //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
        $articles= [];

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $titre = $propertySearch->getTitle();
            if ($titre!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $sessions= $this->getDoctrine()->getRepository(Session::class)
                    ->findByMultiple($titre);
        }
        return  $this->render('session/index.html.twig',[ 'form' =>$form->createView(), 'sessions' => $sessions]);
    }

    /**
     * @Route("/back", name="app_session_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/indexAdmin.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_session_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SessionRepository $sessionRepository): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->add($session);
            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_session_show", methods={"GET"})
     */
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'sessions' => $session,
        ]);
    }


    /**
     * @Route("/back/{id}", name="app_session_showAdmin", methods={"GET"})
     */
    public function showAdmin(Session $session): Response
    {
        return $this->render('session/showAdmin.html.twig', [
            'session' => $session,
        ]);
    }



    /**
     * @Route("/{id}/edit", name="app_session_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionRepository->add($session);
            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_session_delete", methods={"POST"})
     */
    public function delete(Request $request, Session $session, SessionRepository $sessionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $sessionRepository->remove($session);
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/searchSessions ", name="searchSessions")
     * @throws ExceptionInterface
     */
    public function searchSessions(Request $request,NormalizerInterface $Normalizer): Response
    {
        $repository = $this->getDoctrine()->getRepository(Session::class);
        $requestString=$request->get('searchValue');
        $session = $repository->findByMultiple($requestString);
        $jsonContent = $Normalizer->normalize($session, 'json',['groups'=>'show:read']);
        $retour=json_encode($jsonContent);
        return new Response($retour);
    }

    /**
     * @Route("/searchSession ", name="searchSession")
     * @throws ExceptionInterface
     */
    public function searchSession(Request $request,NormalizerInterface $Normalizer): Response
    {
        $searchTerm = $request->query->get('search');
        $em = $this->getDoctrine()->getManager();
        $search = $em->getRepository(Session::class)->findByMultiple($searchTerm);
        if ($request->isXmlHttpRequest()) {
            return JsonResponse::create(['status' => 'success', 'results' => $search]);

        }
        return $this->render('session/index2.html.twig', [
            'sessions' => $search
        ]);
    }

    /**
     * @Route("/sessionRating/{id}/{rate}", name="edit_session_rating", methods={"GET", "POST"})
     */
    public function editActionRating(?Session $session, Request $request, $rate, ManagerRegistry $doctrine):Response
    {
        $session->setRating($rate);

        $em = $this->getDoctrine()->getManager();
        $em->persist($session);
        $em->flush();
        $coach = $session->getCoach();
        $sessions = $coach->getSessions();
        $coachRating = 0;
        try {
            foreach ($sessions->getIterator() as $i => $item) {
                $coachRating = ($coachRating + $item->getRating())/$sessions->count();
            }
        } catch (\Exception $e) {
        }
        $coach->setRating($coachRating);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($coach);
        $entityManager->flush();
        // Return code
        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }
}
