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
 * @Route("/info/user")
 */
class InfoUserController extends AbstractController
{
    /**
     * @Route("/", name="app_Info_user_index", methods={"GET"})
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
            6
        );
        
        // Render the twig view
        return $this->render('info_user/index.html.twig', [
            'infos' => $infos,
        ]);
    }
}