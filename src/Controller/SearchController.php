<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function searchBar(){
        $form=$this->createFormBuilder(null)
            ->add('query', TextType::class)
            ->add('search', SubmitType::class,
            [
                'attr'=>[
                    'class'=>'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('searchBar.html.twig', [

            'form'=>$form->createView()]);
    }
}
