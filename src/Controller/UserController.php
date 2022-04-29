<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="app_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
 
    /**
     * @Route("/{id}", name="app_user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    /**
     * @Route("/profile/{email}", name="app_profile", methods={"GET"})
     */
    public function showOne(User $user): Response
    {
        return $this->render('profile/profile.html.twig', [
            'user' => $user,
        ]);
    }
    
    /**
     * @Route("/profile/{email}/edit", name="app_profile_edit", methods={"GET", "POST"})
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
            return $this->redirectToRoute('app_profile', ['email' => $user->getEmail()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profile/editProfile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="app_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, UserPasswordEncoderInterface $userPasswordEncoder, UserRepository $userRepository): Response
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
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/ban/{id}", name="ban")
     */
    public function ban($id,FlashyNotifier $flashyNotifier): Response
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setBan(true);
        $user->setActivate(false);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash(
            'danger',
            'USER BANNED!'
        );
        /*$flashyNotifier->primary('the user is baned!', 'http://your-awesome-link.com');*/
        return $this->redirectToRoute('backend_user_index');
    }

    /**
     * @Route("activate/{id}", name="activate")
     */
    public function activate($id): Response
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setBan(false);
        $user->setActivate(true);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash(
            'success',
            'USER ACtivated!'
        );
        return $this->redirectToRoute('backend_user_index');
    }

}
