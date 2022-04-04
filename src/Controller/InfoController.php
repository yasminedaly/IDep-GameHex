<?php

namespace App\Controller;

use App\Entity\Info;
use App\Form\InfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/info")
 */
class InfoController extends AbstractController
{
    /**
     * @Route("/", name="app_info_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $infos = $entityManager
            ->getRepository(Info::class)
            ->findAll();

        return $this->render('info/index.html.twig', [
            'infos' => $infos,
        ]);
    }

    /**
     * @Route("/new", name="app_info_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $info = new Info();
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($info);
            $entityManager->flush();

            return $this->redirectToRoute('app_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('info/new.html.twig', [
            'info' => $info,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{contentid}", name="app_info_show", methods={"GET"})
     */
    public function show(Info $info): Response
    {
        return $this->render('info/show.html.twig', [
            'info' => $info,
        ]);
    }

    /**
     * @Route("/{contentid}/edit", name="app_info_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Info $info, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('info/edit.html.twig', [
            'info' => $info,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{contentid}", name="app_info_delete", methods={"POST"})
     */
    public function delete(Request $request, Info $info, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$info->getContentid(), $request->request->get('_token'))) {
            $entityManager->remove($info);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
