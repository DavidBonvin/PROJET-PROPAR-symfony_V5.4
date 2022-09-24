<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
<<<<<<< HEAD
     * @Route("/register", name="inscription")
=======
     * @Route("/register", name="app_register")
>>>>>>> 6fa3b538f22a598c8c69406a1cd786c5b8f721be
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
<<<<<<< HEAD
                    $form->get('password')->getData()
=======
                    $form->get('plainPassword')->getData()
>>>>>>> 6fa3b538f22a598c8c69406a1cd786c5b8f721be
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

<<<<<<< HEAD
            return $this->redirectToRoute('app_home');
=======
            return $this->redirectToRoute('app_login');
>>>>>>> 6fa3b538f22a598c8c69406a1cd786c5b8f721be
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
