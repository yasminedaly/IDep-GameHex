<?php

namespace App\Controller;

use App\Entity\Tutos;
use App\Form\TutosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/admin/tutos")
 */
class TutosController extends AbstractController
{
    /**
     * @Route("/", name="app_tutos_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        // Retrieve the entity manager of Doctrine
        $em = $this->getDoctrine()->getManager();
        
        // Get some repository of data, in our case we have an Tutos entity
        $tutos = $em
				->getRepository(Tutos::class)
				->findAll();
                

        
        // Paginate the results of the query
        $tutos = $paginator->paginate(
            // Doctrine Query, not results
            $tutos,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );
        
        // Render the twig view
        return $this->render('tutos/index.html.twig', [
            'tutos' => $tutos,
        ]);
    }

/*    public function index(EntityManagerInterface $entityManager): Response
    {
        $tutos = $entityManager
            ->getRepository(Tutos::class)
            ->findAll();

        return $this->render('tutos/index.html.twig', [
            'tutos' => $tutos,
        ]);
    }
*/
    /**
     * @Route("/new", name="app_tutos_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tuto = new Tutos();
        $form = $this->createForm(TutosType::class, $tuto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tuto);
            $entityManager->flush();

            return $this->redirectToRoute('app_tutos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutos/new.html.twig', [
            'tuto' => $tuto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{tutoid}", name="app_tutos_show", methods={"GET"})
     */
    public function show(Tutos $tuto): Response
    {
        return $this->render('tutos/show.html.twig', [
            'tuto' => $tuto,
        ]);
    }

    /**
     * @Route("/{tutoid}/edit", name="app_tutos_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tutos $tuto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TutosType::class, $tuto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tutos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tutos/edit.html.twig', [
            'tuto' => $tuto,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{tutoid}", name="app_tutos_delete", methods={"POST"})
     */
    public function delete(Request $request, Tutos $tuto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tuto->getTutoid(), $request->request->get('_token'))) {
            $entityManager->remove($tuto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tutos_index', [], Response::HTTP_SEE_OTHER);
    }
}
