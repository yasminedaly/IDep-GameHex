<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Coach;
use App\Service\FavorisServices;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FavorisController extends AbstractController
{
    /**
     * @Route("/favoris", name="app_favoris")
     */
    public function index(FavorisServices $cartServices): Response
    {

        $panier = $cartServices->getFullFavoris();

        // On "fabrique" les données

        return $this->render('favoris/index.html.twig',['dataPanier'=>$panier]);

    }
    /**
     * @Route("/addf/{id}", name="addf")
     */
    public function add(Coach $coach,FavorisServices $cartServices)
    {
        // On récupère le panier actuel

        $cartServices->add($coach);
        return $this->redirectToRoute("app_favoris");
    }
    /**
     * @Route("/removef/{id}", name="removef")
     */
    public function remove(Coach $coach,FavorisServices $cartServices )
    {
        // On récupère le panier actuel
        $cartServices->remove($coach);
        return $this->redirectToRoute("app_favoris");
    }
    /**
     * @Route("/deletef/{id}", name="deletef")
     */
    public function delete(Coach $coach,FavorisServices $cartServices)
    {
        // On récupère le panier actuel
        $cartServices->removeAll($coach);
        return $this->redirectToRoute("app_favoris");
    }


}

