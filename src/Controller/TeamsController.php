<?php

namespace App\Controller;

use App\Entity\Agency;
use App\Entity\Teams;
use App\Entity\User;
use App\Form\TeamsType;
use App\Repository\TeamsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;



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

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $donnees = $teamsRepository
            ->findAll();
        $teams= $paginator->paginate(
            $donnees,
            $request -> query->getInt('page',1),
            4
        );
        return $this->render('teams/index.html.twig', [
            'teams' => $teams, 'current_user'=>$currentUser
        ]);


    }

    /* begin Mobile */
    /**
     * @Route("/DeleteTeam", name="team_delJSON"),methods={"PUT"}
     */

    public function delJSON(Request $request, SerializerInterface $serializerInterface)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $h = $em->getRepository(Teams::class)->find($id);
        if ($h != null) {
            $em->remove($h);
            $em->flush();

            $json = $serializerInterface->serialize($h, 'json', ['groups' => 'post:read']);

            return new JsonResponse("Done!!" . json_encode($json));
        } else {
            return new JsonResponse("Check again");
        }
    }


    /**
     * @Route("/UpdateTeam", name="hotel_updateJSON"),methods={"PUT"}
     */
    public function UpdateTeam(TeamsRepository $sRepository, SerializerInterface $serializerInterface, Request $request, NormalizerInterface $normalizerInterface)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $h = $entityManager->getRepository(Teams::class)->find($request->get("id"));
        $h->setTeamName($request->get("team_name"));
        $h->setTeamTag($request->get("team_tag"));
        $h->setTeamMail($request->get("team_mail"));
        $h->setTeamReg($request->get("team_reg"));
        $entityManager->persist($h);
        $entityManager->flush();

        $jsoncontent = $serializerInterface->serialize($h, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsoncontent));
    }


    /**
     * @Route("/DisplayAllTeamsMobile", name="test", methods={"GET","POST"})
     */
    public function DisplayAllTeamsMobile(NormalizerInterface $normalizerInterface, EntityManagerInterface $entityManager)
    {
        $repository = $this->getDoctrine()->getRepository(Teams::class);
        $teams = $repository->findAll();
        // dd($hotel);
        $json = $normalizerInterface->normalize($teams, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($json));
    }

    /**
     * @Route("/AddTeamMobile", name="app_team_index", methods={"GET","POST"})
     */
    public function AddTeamMobile(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $entityManager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $h = new Teams();
        $h->setTeamName($request->get("team_name"));
        $h->setTeamTag($request->get("team_tag"));
        $h->setTeamMail($request->get("team_mail"));
        $h->setTeamReg($request->get("team_reg"));


        $entityManager->persist($h);
        $entityManager->flush();
        $jsoncontent = $serializerInterface->serialize($h, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsoncontent));
    }


    /**
     * @Route("/show/{id}", name="showJson")
     */
    public function showJson($id, Request $request, SerializerInterface $serializerInterface)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hc = $entityManager->getRepository(Teams::class)->find($id);
        $jsoncontent = $serializerInterface->serialize($hc, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsoncontent));
    }
    /*end Mobile */

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
        $options['current_id'] = $this->getUser()->getId();
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
            $team->setUser($this->getUser());
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
            'teams' => $teams, 'current_user'=>$this->getUser()
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
