<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\Teams;
use App\Form\TeamsType;
use App\Repository\TeamsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;




/**
 * @Route("/teams")
 */
class TeamsController extends AbstractController
{
    /**
     * @Route("/", name="app_teams_index", methods={"GET"})
     */
    public function index(TeamsRepository $teamsRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $teamsRepository
            ->findAll();
        $teams= $paginator->paginate(
            $donnees,
            $request -> query->getInt('page',1),
            4
        );
        return $this->render('teams/index.html.twig', [
            'teams' => $teams,
        ]);


    }

    /**
     * @Route("/map", name="app_teams_indexMap", methods={"GET"})
     */
    public function indexMap(TeamsRepository $teamsRepository): Response
    {
        return $this->render('indexsvg.html.twig');
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
    public function new(Request $request, TeamsRepository $teamsRepository, \Swift_Mailer $mailer): Response
    {

        $team = new Teams();
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);
        $this->addFlash('info', 'A mail will be sent after form submission');
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('teamLogo')->getData();
            $path = $this->getParameter('cover_directory') . '/' . 5;

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move(
                    $path,
                    $filename
                );
            } catch (FileException $e) {
                echo ('Exception raised');
            }
            $team->setTeamLogo($filename);
            $teamsRepository->add($team);
            $var = $form->get('teamName')->getData();
                $message = (new \Swift_Message('Team Registration'))
                    ->setFrom('gamehex2022@gmail.com')
                    ->setTo($form->get('teamMail')->getData())
                    ->setBody("Team ".$var." successfully registered"
                    );
                $mailer->send($message);
            $this->addFlash('success', 'Mail successfully sent');
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
     * @Route("/back/{id}", name="app_teams_showAdmin", methods={"GET"})
     */
    public function showAdmin(Teams $team): Response
    {
        return $this->render('teams/showAdmin.html.twig', [
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
            $file = $form->get('teamLogo')->getData();
            $path = $this->getParameter('cover_directory') . '/' . 5;

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move(
                    $path,
                    $filename
                );
            } catch (FileException $e) {
                echo ('Exception raised');
            }
            $team->setTeamLogo($filename);
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



    /**
     * @Route("/back/{id}", name="app_teams_deleteAdmin", methods={"POST"})
     */
    public function deleteAdmin(Request $request, Teams $team, TeamsRepository $teamsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamsRepository->remove($team);
        }

        return $this->redirectToRoute('app_teams_indexAdmin', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{teamReg}/search", name="app_teams_showTeamByReg", methods={"GET"})
     */
    public function showTeamsByReg(string $teamReg, Teams $team, TeamsRepository $teamsRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $teamsRepository->findBy(array('teamReg'=> $teamReg), array('teamReg'=>'desc'));
        $teams= $paginator->paginate(
            $donnees,
            $request -> query->getInt('page',1),
            4
        );
        return $this->render('teams/index.html.twig', [
            'teams' => $teams
        ]);
    }


    /**
     * @Route("/search/{teamName}/{pageNumber}", name="app_team_findByname"), methods={"GET"})
     */
    public function findByName($teamName,$pageNumber): Response
    {
        $rep = $this->getDoctrine()->getRepository(Teams::class);
        $response = new JsonResponse();
        if ($teamName != "") {
            $team = $rep->findByName($teamName,$pageNumber);
            $response->setData(($team));
        } else {
            $response->setData([]);
        }
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("/SearchAll/{pageNumber}", name="app_team_findall"), methods={"GET"})
     */
    public function searchAllATeams(PaginatorInterface $paginator, Request $request,$pageNumber):Response
    {

        $rep = $this->getDoctrine()->getRepository(Teams::class);
        $team = $rep->findAllTeams($pageNumber);
        $response = new JsonResponse();
        $response->setData($team);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}
