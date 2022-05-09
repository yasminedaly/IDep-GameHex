<?php

namespace App\Controller;

//require 'vendor/autoload.php';

use NLPCloud\NLPCloud;
use App\Entity\Articles;
use App\Form\ArticlesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface ;
/**
 * @Route("/articles/user")
 */
class ArticlesUserController extends AbstractController
{
    /**
     * @Route("/", name="app_articles_user_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager,SerializerInterface $serializer): Response
    {
        $Allarticles = $entityManager
            ->getRepository(Articles::class)
            ->findAll();

        return $this->render('articles_user/index.html.twig', [
            'articles' => $Allarticles
        ]);
    }
    /**
     * @Route("/{articleid}/sumDisplay", name="sumDisplay", methods={"GET"})
     */
    public function sumDisplay(Request $request, Articles $article, EntityManagerInterface $entityManager): Response
    {
        $articles = $entityManager
            ->getRepository(Articles::class)
            ->findAll();
            
            $client = new \NLPCloud\NLPCloud('bart-large-cnn','2f1ce40182edc5826444958405e985cd7ee10557');
            $rep= $client->summarization($article->getContent());
            
              $key = "summary_text";
              $response = (new Response(json_encode($rep->$key)))->getContent();
             
        
        return $this->render('articles_user/sumDisplay.html.twig', [
            'article' => $article,
            'json' => $response,
        ]);
    }
}