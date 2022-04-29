<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Articles;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\ArticlesRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/admin/user")
 */
class BackendUserController extends AbstractController
{
    /**
     * @Route("/", name="backend_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/pdf", name="pdf", methods={"GET"})
     */
    public function pdf(UserRepository $userRepository): Response
    {   
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFront', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('admin/pdf.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A3', 'portrait');
        $dompdf->render();
        $dompdf->stream("UserList.pdf", [
            "Attachement" => true
        ]);

        
    }


    /**
     * @Route("/profile/{email}", name="backend_profile", methods={"GET"})
     */
    public function showOne(User $user): Response
    {
        return $this->render('profile/profileAdmin.html.twig', [
            'user' => $user,
        ]);
    }
    
    /**
     * @Route("/profile/{email}/edit", name="backend_profile_edit", methods={"GET", "POST"})
     */
    public function editProfile(Request $request, User $user, UserPasswordEncoderInterface $userPasswordEncoder, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordEncoder->encodePassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
            $userRepository->add($user);
            return $this->redirectToRoute('backend_profile', ['email' => $user->getEmail()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/editProfileAdmin.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new", name="backend_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('backend_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('admin/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="backend_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            $this->addFlash(
                'info',
                'USER MODIFIED!'
            );
            return $this->redirectToRoute('backend_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('backend_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
    * @Route("/admin/accepter/{id}", name="backend_user_article_accepte", methods={"GET"})
    */
    public function accepte(ArticlesRepository $ArticlesRepository,Articles $id): Response
    {
    $id->setAccept(1);
    $this->getDoctrine()->getManager()->flush();
    $this->addFlash(
        'success',
        'Article Accepted!'
    );
    return $this->redirectToRoute('app_articles_indexAdmin', [], Response::HTTP_SEE_OTHER);
    }

}
