<?php

namespace App\Controller;

use App\Entity\Info;
use App\Form\InfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/info")
 */
class InfoController extends AbstractController
{
    /**
     * @Route("/", name="app_info_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        // Retrieve the entity manager of Doctrine
        $em = $this->getDoctrine()->getManager();
        
        // Get some repository of data, in our case we have an Tutos entity
        $infos = $em
				->getRepository(Info::class)
				->findAll();
                

        
        // Paginate the results of the query
        $infos = $paginator->paginate(
            // Doctrine Query, not results
            $infos,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        
        // Render the twig view
        return $this->render('info/index.html.twig', [
            'infos' => $infos,
        ]);
    }

    /*public function index(EntityManagerInterface $entityManager): Response
    {
        $infos = $entityManager
            ->getRepository(Info::class)
            ->findAll();

        return $this->render('info/index.html.twig', [
            'infos' => $infos,
        ]);*/


    /**
     * @Route("/new", name="app_info_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $info = new Info();
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $info->getInfocontent();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $info->setInfocontent($fileName);

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
