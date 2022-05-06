<?php

namespace App\Service;
use App\Repository\CoachRepository;
use  Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Coach;


/**
 * @property EntityManagerInterface $manager
 */
class FavorisServices
{
    private SessionInterface $session;
    private CoachRepository $repoCoachs;
    public function __construct(SessionInterface $session, CoachRepository $repoCoachs,EntityManagerInterface $manager){
        $this->session = $session;
        $this->repoCoachs = $repoCoachs;
        $this->manager = $manager;
    }


    public function add(Coach $coach){
        $panier = $this->getFavoris();
        $id = $coach->getId();

        if(empty($panier[$id])){

            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $this->updateFavoris($panier);
    }

    public function removeAll(Coach $coach){
        $panier = $this->getFavoris();
        $id = $coach->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);



            $this->updateFavoris($panier);
        }

        // On sauvegarde dans la session

    }
    public function getFavoris(){
        return $this->session->get('panier',[]);
    }
    public function updateFavoris($panier){
        $this->session->set('panier', $panier);
        $this->session->set('panierData', $this->getFullFavoris());
    }

    public function remove(Coach $coach){
        $panier = $this->getFavoris();
        $id = $coach->getId();


        if(!empty($panier[$id])){

            unset($panier[$id]);

            $this->updateFavoris($panier);

        }

        // On sauvegarde dans la session

    }

    public function getFullFavoris(){

        $cart = $this->getFavoris();
        $fullCart = [];


        foreach ($cart as $id => $quantity) {
            $coach = $this->repoCoachs->find($id);
            if($coach){
                //Coach récupéré avec succès
                $fullCart['products'][] = [
                    "quantity" => $quantity,
                    "product" => $coach
                ];

            }else{
                //identifiant incorrect
                $this->remove($id);
            }
        }
        $fullCart['data'] = [

        ];
        return $fullCart;

    }
    
}