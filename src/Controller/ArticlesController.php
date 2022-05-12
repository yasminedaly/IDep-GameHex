<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/articles")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="app_articles_index", methods={"GET"})
     */
    public function index(ArticlesRepository $articlesRepository, Request  $request): Response
    {
        $client = new HttpClient;

        $client = HttpClient::create();
        $response = $client->request('GET', 'https://quotes15.p.rapidapi.com/quotes/random/', ['headers' => [
            'X-RapidAPI-Host' => 'quotes15.p.rapidapi.com',
            'X-RapidAPI-Key' => 'b72dd72451mshc7d1c9770f461acp1f5299jsn077736d8a6a3'
        ]]);

        $session = $request->getSession();

        $session->start();
        // set and get session attributes
        $session->set('name', 'Drak');
        $data = json_decode($response->getContent(), true);

        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'data' => $data,
            'session' => $session->get('userData')

        ]);
    }

    /**
     * @Route("/back", name="app_articles_indexAdmin", methods={"GET"})
     */
    public function indexAdmin(ArticlesRepository $articlesRepository): Response
    {
        return $this->render('articles/indexAdmin.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }



    /**
     * @Route("/new", name="app_articles_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ArticlesRepository $articlesRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->add($article);
            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/new", name="app_articles_newAdmin", methods={"GET", "POST"})
     */
    public function newAdmin(Request $request, ArticlesRepository $articlesRepository): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->add($article);
            return $this->redirectToRoute('app_articles_indexAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles/newAdmin.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}", name="app_articles_show", methods={"GET"})
     */
    public function show(Articles $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'article' => $article,
        ]);
    }


    /**
     * @Route("/back/{id}", name="app_articles_showAdmin", methods={"GET"})
     */
    public function showAdmin(Articles $article): Response
    {
        return $this->render('articles/showAdmin.html.twig', [
            'article' => $article,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_articles_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->add($article);
            return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/back/{id}/edit", name="app_articles_editAdmin", methods={"GET", "POST"})
     */
    public function editAdmin(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articlesRepository->add($article);
            return $this->redirectToRoute('app_articles_indexAdmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('articles/editAdmin.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_articles_delete", methods={"POST"})
     */
    public function delete(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article);
        }

        return $this->redirectToRoute('app_articles_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/back/{id}", name="app_articles_deleteAdmin", methods={"POST"})
     */
    public function deleteAdmin(Request $request, Articles $article, ArticlesRepository $articlesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $articlesRepository->remove($article);
        }

        return $this->redirectToRoute('app_articles_indexAdmin', [], Response::HTTP_SEE_OTHER);
    }
}
