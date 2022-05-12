<?php

namespace App\Controller;


use App\Entity\TeamMates;
use App\Form\TeamMatesType;
use App\Repository\TeamMatesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twilio\Rest\Client;


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
     * @Route("/quotes", name="app_team_mates_quotes", methods={"GET"})
     */
    public function quotes(TeamMatesRepository $teamMatesRepository): Response
    {
        return $this->render('team_mates/quotes.html.twig');
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
        $twilio_number = "+19108308627";
        if ($form->isSubmitted() && $form->isValid()) {
            $client =new Client('AC90ac083ebfd6f6485124fb25d08fbbb0', '9b9845a946c52aee9b451be913eb03b0');
            $message = $client->messages->create(

// Where to send a text message (your cell phone?)
                '+21651908081',
                array(
                    'from' => $twilio_number,
                    'body' => ' Hello, this is your favorite website GameHex. Team member registered!'
                )
            );
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
     * @Route("/back/{riotId}", name="app_team_mates_showAdmin", methods={"GET"})
     */
    public function showAdmin(TeamMates $teamMate): Response
    {
        return $this->render('team_mates/showAdmin.html.twig', [
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

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        $request->getSession()->set('_locale', $locale);
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setLocale($locale);
        $em->persist($user);
        $em->flush();
        return $this->redirect($request->headers->get('referer'));

    }

}

