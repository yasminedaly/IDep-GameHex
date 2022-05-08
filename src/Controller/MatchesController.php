<?php

namespace App\Controller;

use App\Entity\Matches;
use App\Form\MatchesType;
use App\Repository\MatchesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/matches")
 */
class MatchesController extends AbstractController
{
    /**
     * @Route("/", name="app_matches_index", methods={"GET"})
     */
    public function index(MatchesRepository $matchesRepository): Response
    {
        return $this->render('matches/index.html.twig', [
            'matches' => $matchesRepository->findAll(),
        ]);
    }
    


    /**
     * @Route("/back", name="app_matches_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(MatchesRepository $matchesRepository): Response
    {
        return $this->render('matches/indexAdmin.html.twig', [
            'matches' => $matchesRepository->findAll(),
        ]);
    }



    /**
     * @Route("/new", name="app_matches_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MatchesRepository $matchesRepository): Response
    {
        $match = new Matches();
        $form = $this->createForm(MatchesType::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matchesRepository->add($match);
            return $this->redirectToRoute('app_matches_indexAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('matches/new.html.twig', [
            'match' => $match,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_matches_show", methods={"GET"})
     */
    public function show(Matches $match): Response
    {
        return $this->render('matches/show.html.twig', [
            'match' => $match,
        ]);
    }

    /**
     * @Route("/back/{id}", name="app_matches_showAdmin", methods={"GET"})
     */
    public function showAdmin(Matches $match): Response
    {
        return $this->render('matches/showAdmin.html.twig', [
            'match' => $match,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_matches_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Matches $match, MatchesRepository $matchesRepository): Response
    {
        $form = $this->createForm(MatchesType::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $matchesRepository->add($match);
            return $this->redirectToRoute('app_matches_indexAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('matches/edit.html.twig', [
            'match' => $match,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_matches_delete", methods={"POST"})
     */
    public function delete(Request $request, Matches $match, MatchesRepository $matchesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$match->getId(), $request->request->get('_token'))) {
            $matchesRepository->remove($match);
        }

        return $this->redirectToRoute('app_matches_indexAdmin', [], Response::HTTP_SEE_OTHER);
    }
}
