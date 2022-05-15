<?php

namespace App\Controller;

//require 'vendor/autoload.php';

use NLPCloud\NLPCloud;
use App\Entity\Tutos;
use App\Form\TutosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface ;
/**
 * @Route("/tutos/user")
 */
class TutosUserController extends AbstractController
{
    /**
     * @Route("/", name="app_tutos_user_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SerializerInterface $serializer): Response
    {
        $Alltutos = $entityManager
            ->getRepository(Tutos::class)
            ->findAll();

        return $this->render('tutos_user/index.html.twig', [
            'tutos' => $Alltutos
        ]);
    }
    /**
     * @Route("/{tutoid}/sumDisplay", name="sumDisplay", methods={"GET"})
     */
    public function sumDisplay(Request $request, Tutos $tuto, EntityManagerInterface $entityManager): Response
    {
        $tutos = $entityManager
            ->getRepository(Tutos::class)
            ->findAll();
            
            $client = new \NLPCloud\NLPCloud('bart-large-cnn','2f1ce40182edc5826444958405e985cd7ee10557');
            $rep= $client->summarization($tuto->getContent());
            
              $key = "summary_text";
              $response = (new Response(json_encode($rep->$key)))->getContent();
             
        
        return $this->render('tutos_user/sumDisplay.html.twig', [
            'tuto' => $tuto,
            'json' => $response,
        ]);
    }
}