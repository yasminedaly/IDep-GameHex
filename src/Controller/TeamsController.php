<?php

namespace App\Controller;

use App\Entity\Teams;
use App\Form\TeamsType;
use App\Repository\TeamsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/teams")
 */
class TeamsController extends AbstractController
{
    /**
     * @Route("/", name="app_teams_index", methods={"GET"})
     */
    public function index(TeamsRepository $teamsRepository): Response
    {
        return $this->render('teams/index.html.twig', [
            'teams' => $teamsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back", name="app_teams_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(TeamsRepository $teamsRepository): Response
    {
        return $this->render('teams/indexAdmin.html.twig', [
            'teams' => $teamsRepository->findAll(),
        ]);
    }
    /**
     * @Route("/new", name="app_teams_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TeamsRepository $teamsRepository): Response
    {
        $team = new Teams();
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamsRepository->add($team);
            return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teams/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_teams_show", methods={"GET"})
     */
    public function show(Teams $team): Response
    {
        return $this->render('teams/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_teams_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Teams $team, TeamsRepository $teamsRepository): Response
    {
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamsRepository->add($team);
            return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('teams/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_teams_delete", methods={"POST"})
     */
    public function delete(Request $request, Teams $team, TeamsRepository $teamsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamsRepository->remove($team);
        }

        return $this->redirectToRoute('app_teams_index', [], Response::HTTP_SEE_OTHER);
    }
}
