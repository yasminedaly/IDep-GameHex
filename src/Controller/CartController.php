<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="app_cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository): Response
    {

        $panier = $session->get('panier', []);
        $panierData = [];
        foreach ($panier as $id => $quantity) {
            $panierData[] = [
                'product' =>  $productRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($panierData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        // dd($panierData);

        return $this->render('cart/index.html.twig', [
            'items' => $panierData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="app_cart_add")
     */
    public function add($id, SessionInterface $session): Response
    {


        //Test if the element exist in the table cart ( panier)
        // if exists : increment +1
        // else : initialisation bel quantity



        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute('app_cart');
        // dd($session->get('panier'));
        // return $this->render('cart/index.html.twig', [
        //     'controller_name' => 'CartController',
        // ]);
    }

    /**
     * @Route("/panier/remove/{id}", name="app_cart_remove")
     */
    public function remove($id, SessionInterface $session): Response
    {


        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute('app_cart');
    }


    /**
     * @Route("/new", name="aaaa", methods={"GET", "POST"})
     */
    public function ConfirmAPurchase(Request $request, OrderRepository $orderrep): Response
    {
        $items = $request->get('items');
        // dd($request->get('itemOBJ'));
        $order1 = new Order();
        $order1->setQuantity(0);
        $order1->setRef(1);
        $order1->setProductID($request->get('itemOBJ')['Itemid']);
        $order1->setTotal($request->get('itemOBJ')['total']);

        $orderrep->add($order1);


        return $this->redirectToRoute('app_cart');


        // foreach ($items as $item) {
        //     echo ($item);
        // }
    }
}
