<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Commande;
use App\Form\RegistrationClientType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationClientController extends AbstractController
{
    /**
     * @Route("/registration/client", name="app_registration_client")
     */
    public function index(Request $request,  EntityManagerInterface $entityManager): Response
    {


        $client = new Client();
        $form = $this->createForm(RegistrationClientType::class, $client);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            
            

            $entityManager->persist($client);
            $entityManager->flush();
            $this->addFlash("success", "La Client a bien été ajouté");
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_prise_commande');
        }



        return $this->render('registration_client/index.html.twig', [
            'RegistrationClientType' => $form->createView(),
        ]);
    }
}
