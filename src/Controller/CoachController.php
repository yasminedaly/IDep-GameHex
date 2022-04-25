<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\CoachType;
use App\Repository\CoachRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coach")
 */
class CoachController extends AbstractController
{
    /**
     * @Route("/", name="app_coach_index", methods={"GET"})
     */
    public function index(CoachRepository $coachRepository): Response
    {
        return $this->render('coach/index.html.twig', [
            'coaches' => $coachRepository->findAll(),
        ]);
    }

    /**
     * @Route("/back", name="app_coach_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(CoachRepository $c): Response
    {

        $data = $c->findAll();
        $dest = array();
        foreach ($data as $x) {
            //$dest[] = [$x->getDestination()] ;
            $dest[] = $x->getTier();
        }

        $pieChart = new PieChart();
        $array_dest_occ = array_count_values($dest);
        $final = [
            ['Coach ', 'Tier']

        ];
        foreach ($array_dest_occ as $x => $x_value) {
            $final[] = [$x, (int)$x_value];
        }

        $pieChart->getData()->setArrayToDataTable( $final);

        $pieChart->getOptions()->setTitle('Coaches by Tier');
        $pieChart->getOptions()->setHeight(360);
        $pieChart->getOptions()->setWidth(510);
        $pieChart->getOptions()->setEnableInteractivity(true);
        $pieChart->getOptions()->setIs3D(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#07600');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        //dump($data); die();

        return $this->render('coach/indexAdmin.html.twig', ['coaches' => $c->findAll(),
            'controller_name'=>'CoachController', 'piechart'=>$pieChart
        ]);
    }

    /**
     * @Route("/new", name="app_coach_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CoachRepository $coachRepository): Response
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageURL')->getData();
            $path = $this->getParameter('cover_directory') . '/' . 5;

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move(
                    $path,
                    $filename
                );
            } catch (FileException $e) {
                echo ('hello');
            }
            $coach->setImageURL($filename);

            $coachRepository->add($coach);
            return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coach/new.html.twig', [
            'coach' => $coach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_coach_show", methods={"GET"})
     */
    public function show(Coach $coach): Response
    {
        return $this->render('coach/show.html.twig', [
            'coach' => $coach,
        ]);
    }


    /**
     * @Route("/back/{id}", name="app_coach_showAdmin", methods={"GET"})
     */
    public function showAdmin(Coach $coach): Response
    {
        return $this->render('coach/showAdmin.html.twig', [
            'coach' => $coach,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_coach_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Coach $coach, CoachRepository $coachRepository): Response
    {
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coachRepository->add($coach);
            return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('coach/edit.html.twig', [
            'coach' => $coach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editRating/{id}/{rate}", name="edit_coach_rating", methods={"GET", "POST"})
     */
    public function editActionRating(?Coach $coach, Request $request, $rate):Response
    {
            $coach->setRating($rate);

            $em = $this->getDoctrine()->getManager();
            $em->persist($coach);
            $em->flush();

            // Return code
        return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
    }



    /**
     * @Route("/{id}", name="app_coach_delete", methods={"POST"})
     */
    public function delete(Request $request, Coach $coach, CoachRepository $coachRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coach->getId(), $request->request->get('_token'))) {
            $coachRepository->remove($coach);
        }

        return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
    }
}
