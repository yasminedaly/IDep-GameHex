<?php

namespace App\Controller;

use App\Entity\TeamMates;
use App\Form\TeamMatesType;
use App\Repository\TeamMatesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team/mates")
 */
class TeamMatesController extends AbstractController
{
    /**
     * @Route("/", name="app_team_mates_index", methods={"GET"})
     */
    public function index(TeamMatesRepository $teamMatesRepository): Response
    {
        return $this->render('team_mates/index.html.twig', [
            'team_mates' => $teamMatesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back", name="app_team_mates_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(TeamMatesRepository $teamMatesRepository): Response
    {
        return $this->render('team_mates/indexAdmin.html.twig', [
            'team_mates' => $teamMatesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_team_mates_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TeamMatesRepository $teamMatesRepository): Response
    {
        $teamMate = new TeamMates();
        $form = $this->createForm(TeamMatesType::class, $teamMate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamMatesRepository->add($teamMate);
            return $this->redirectToRoute('app_team_mates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team_mates/new.html.twig', [
            'team_mate' => $teamMate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{riotId}", name="app_team_mates_show", methods={"GET"})
     */
    public function show(TeamMates $teamMate): Response
    {
        return $this->render('team_mates/show.html.twig', [
            'team_mate' => $teamMate,
        ]);
    }

    /**
     * @Route("/{riotId}/edit", name="app_team_mates_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TeamMates $teamMate, TeamMatesRepository $teamMatesRepository): Response
    {
        $form = $this->createForm(TeamMatesType::class, $teamMate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamMatesRepository->add($teamMate);
            return $this->redirectToRoute('app_team_mates_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('team_mates/edit.html.twig', [
            'team_mate' => $teamMate,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{riotId}", name="app_team_mates_delete", methods={"POST"})
     */
    public function delete(Request $request, TeamMates $teamMate, TeamMatesRepository $teamMatesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teamMate->getRiotId(), $request->request->get('_token'))) {
            $teamMatesRepository->remove($teamMate);
        }

        return $this->redirectToRoute('app_team_mates_index', [], Response::HTTP_SEE_OTHER);
    }
}
