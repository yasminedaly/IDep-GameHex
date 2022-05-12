<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/ViewAllOrders", name="app_order_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findAllVisibleQuery(),
        ]);
    }

    /**
     * @Route("/app_order_findByRef", name="app_order_findByRef", methods={"GET"})
     */
    public function testt2(OrderRepository $orderRepository, Request $request, ProductRepository $prodref): Response
    {
        // $request->query->get('ref');

        $ref  = $request->query->get('ref');
        $res = $orderRepository->findAllVisibleQuery2($ref);
        $array = [];
        for ($i = 0; $i < count($res); $i++) {

            // dd($prodref->find($res[$i]['product_id']));
            array_push($array, $prodref->find($res[$i]['product_id']));
        }

        // dd($array);
        // dd($res);
        return $this->render('order/show.html.twig', [
            'array' => $array,
        ]);
    }

    /**
     * @Route("/new", name="app_order_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OrderRepository $orderRepository): Response
    {
        $items = $request->get('items');
        dd($request->get('items'));
        // foreach ($items as $item) {
        //     echo ($item);
        // }
    }

    /**
     * @Route("/{id}", name="app_order_show", methods={"GET"})
     */
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'order' => $order,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_order_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order);
            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order/edit.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_order_delete", methods={"POST"})
     */
    public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $order->getId(), $request->request->get('_token'))) {
            $orderRepository->remove($order);
        }

        return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/a/OrderInvoice", name="app_pdfInvoice", methods={"GET"})
     */
    public function pdfAction(Request $req, OrderRepository $orderrep, Request $request, SessionInterface $session)
    {


        $orders = $orderrep->findAll();
        $dompdf = new Dompdf();
        $png = file_get_contents("avatar-1.png");
        $png2 = file_get_contents("avatar-1.png");
        $pngbase64 = base64_encode($png);
        $pngbase643 = base64_encode($png2);
        $html = $this->renderView('product_user/pdfGen.html.twig', [
            'title' => 'testing title',
            "img64" => $pngbase64,
            "img643" => $pngbase643,
            "orders" => $session->get('panierData'),
            "total" => $request->get('total')
        ]);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        $options = $dompdf->getOptions();

        $options->setIsHtml5ParserEnabled(true);
        // Output the generated PDF to Browser
        $dompdf->stream();
    }
}
