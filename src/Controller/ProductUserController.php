<?php

namespace App\Controller;

use App\Form\PropertySearchType;
use App\Entity\Product;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\PropertySearch;
use App\Repository\PropertySearchRepository;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class ProductUserController extends AbstractController
{
    /**
     * @Route("/product/user", name="app_product_user")
     */
    public function index(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);


        if ($search->getMaxprice()) {
            $products = $productRepository->findAllVisibleQuery($search);
        } else {
            $products = $productRepository->findAll();
        }
        $products = $paginator->paginate($products, $request->query->getInt('page', 2), 2);
        // $productSearched = $paginator->paginate($productSearched, $request->query->getInt('page', 2), 2);





        return $this->render('product_user/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/aaa", name="app_product_test", methods={"POST"})
     */
    public function test(ProductRepository $productRepository, Request $request, PaginatorInterface $paginator)
    {
        $prod = $productRepository->find(3);
        $prod->setReview(45);
        $productRepository->add($prod);


        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find(3);
        $product->setName('New product name!');
        $em->flush();
    }
}
