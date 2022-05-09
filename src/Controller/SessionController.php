<?php

namespace App\Controller;

use App\Entity\Calendar;
use App\Entity\Session;
use App\Entity\User;
use App\Form\CalendarType;
use App\Form\SessionType;
use App\Repository\CalendarRepository;
use App\Repository\SessionRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/session")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/", name="app_session_index", methods={"GET", "POST"})
     * @param SessionRepository $sessionRepository
     * @return Response
     */
    public function index(SessionRepository  $sessionRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        /** @var User $user */
        $user = $this->getUser();
        return  $this->render('session/index.html.twig',['sessions' => $sessionRepository->findSessionByUser($user)]);
    }

    /**
     * @Route("/back", name="app_session_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(SessionRepository $sessionRepository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        return $this->render('session/indexAdmin.html.twig', [
            'sessions' => $sessionRepository->findSessionByUser($user),
        ]);
    }

    /**
     * @Route("/new", name="app_session_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SessionRepository $sessionRepository, CalendarRepository $calendarRepository): Response
    {
        $session = new Session();
        $calendar = new Calendar();
        $form = $this->createForm(CalendarType::class, $calendar);
        $form->handleRequest($request);
        /** @var User $user */
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $calendar->setUser($user);
            $calendarRepository->add($calendar);
            $session->setUser($user);
            $session->setTitle($calendar->getTitle());
            $session->setDescription($calendar->getDescription());
            $session->setStart($calendar->getStart());
            $session->setCoach($calendar->getCoach());
            $sessionRepository->add($session);
            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('calendar/new.html.twig', [
            'calendar' => $calendar,
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
     * @Route("/{id}/edit", name="app_session_edit", methods={"PUT"})
     * @throws Exception
     */
    public function edit(Request $request, ?Session $session): Response
    {
        $data = json_decode($request->getContent());

        if(isset($data->start) && !empty($data->start)){
            // data is complete
            // We initialize the code
            $code = 200;

            // We hydrate the object with the data
            $session->setStart(new DateTime($data->start));

            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();
            // We return the code
            return new Response('Ok', $code);
        }else{
            // Data is incomplete
            return new Response('Data incomplete', 404);
        }
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
     * @Route("/sessionRating/{id}/{rate}", name="edit_session_rating", methods={"GET", "POST"})
     */
    public function editActionRating(?Session $session, $rate, ManagerRegistry $doctrine):Response
    {
        $session->setRating($rate);

        $em = $this->getDoctrine()->getManager();
        $em->persist($session);
        $em->flush();
        $coach = $session->getCoach();
        $sessions = $coach->getSessions();
        $coachRating = 0;
        try {
            foreach ($sessions->getIterator() as $item) {
                $coachRating = ($coachRating + $item->getRating())/$sessions->count();
            }
        } catch (Exception $e) {
        }
        $coach->setRating($coachRating);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($coach);
        $entityManager->flush();
        // Return code
        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }



}
