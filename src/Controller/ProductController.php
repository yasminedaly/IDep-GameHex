<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\SupplierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Twilio\TwiML\Voice\Prompt;



/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{

    /**
     * @Route("/DisplayAllProductsMobile", name="test", methods={"GET","POST"})
     */
    public function DisplayAllProductsMobile(NormalizerInterface $normalizerInterface, EntityManagerInterface $entityManager)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $hotel = $repository->findAll();
        // dd($hotel);
        $json = $normalizerInterface->normalize($hotel, 'json', ['groups' => 'post:read']);
        // return $this->render

        return new Response(json_encode($json));
    }

    /* begin Mobile */
    /**
     * @Route("/DeleteMobile", name="hotel_delJSON"),methods={"PUT"}
     */

    public function delJSON(Request $request, SerializerInterface $serializerInterface)
    {
        $id = $request->get("id");

        $em = $this->getDoctrine()->getManager();
        $h = $em->getRepository(Product::class)->find($id);
        if ($h != null) {
            $em->remove($h);
            $em->flush();

            //$serialize = new Serializer([new ObjectNormalizer()]);
            $json = $serializerInterface->serialize($h, 'json', ['groups' => 'post:read']);

            // $formatted = $serialize->normalize("Agence a ete supprimee avec success.");
            return new JsonResponse("deleted!" . json_encode($json));
        } else {
            return new JsonResponse("id h invalide.");
        }
    }


    /**
     * @Route("/UpdateMobile", name="hotel_updateJSON"),methods={"PUT"}
     */
    public function UpdateMobile(SupplierRepository $sRepository, SerializerInterface $serializerInterface, Request $request, NormalizerInterface $normalizerInterface)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $h = $entityManager->getRepository(Product::class)->find($request->get("id"));
        $h->setName($request->get("name"));
        $h->setRef('aa');
        $h->setDescription("aa");
        $h->setState("aa");
        $h->setPrice(4);
        $h->setReview(4);
        $a = $sRepository->find(1);
        $h->setSupplier($a);
        $entityManager->persist($h);
        $entityManager->flush();

        $jsoncontent = $serializerInterface->serialize($h, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsoncontent));
    }




    /**
     * @Route("/AddProductMobile", name="app_product_index", methods={"GET","POST"})
     */
    public function AddProductMobile(SupplierRepository $sRepository, Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $entityManager): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $h = new Product();
        $h->setName($request->get("name"));
        $h->setRef($request->get("ref"));
        $h->setDescription($request->get("description"));
        $h->setState($request->get("state"));
        $h->setPrice($request->get("price"));
        $h->setReview($request->get("review"));
        $a = $sRepository->find(1);
        $h->setSupplier($a);


        $entityManager->persist($h);
        $entityManager->flush();
        $jsoncontent = $serializerInterface->serialize($h, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsoncontent));
    }


    /**
     * @Route("/show/{idProduct}", name="showJson")
     */
    public function showJson($idProduct, Request $request, SerializerInterface $serializerInterface)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $hc = $entityManager->getRepository(Product::class)->find($idProduct);
        $jsoncontent = $serializerInterface->serialize($hc, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsoncontent));
    }
    /*end Mobile */



    /**
     * @Route("/", name="app_product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('imgURL')->getData();
            $path = $this->getParameter('cover_directory') . '/' . 5;

            // $filename = md5(uniqid()) . '.' . $file->guessExtension();

            $filename = md5(uniqid()) . '.' . $file->guessExtension();

            try {
                $file->move(
                    $path,
                    $filename
                );
            } catch (FileException $e) {
                echo ('hello');
            }

            $product->setImgURL($filename);
            $productRepository->add($product);

            $chatId = '5016731252';
            $messageText = 'Hurry up new Product Added : ' . $product->getRef() . '--' . $product->getName() . '-- Visit the Link :' . 'http://127.0.0.1:8000/admin/product/' . $product->getId();
            $bot = new \TelegramBot\Api\BotApi('5367445444:AAFTnVXSMUnHpUC6SUxGiSjgmOC5Y1rgHoI');
            $bot->sendMessage($chatId, $messageText);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/a/pdfGen", name="app_pdf", methods={"GET"})
     */
    public function pdfAction(Request $req)
    {

        $dompdf = new Dompdf();
        $png = file_get_contents("avatar-1.jpg");
        $png2 = file_get_contents("avatar-1.jpg");
        $pngbase64 = base64_encode($png);
        $pngbase643 = base64_encode($png2);
        $html = $this->renderView('product_user/pdfGen.html.twig', [
            'title' => 'testing title',
            "img64" => $pngbase64,
            "img643" => $pngbase643,
        ]);
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();
        $options = $dompdf->getOptions();

        $options->setIsHtml5ParserEnabled(true);
        // Output the generated PDF to Browser
        $dompdf->stream();
    }


    /**
     * @Route("/{id}/edit", name="app_product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
