<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\RegistrationFormType;
use App\Form\RegistrationCommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PriseCommandeController extends AbstractController
{
    /**
     * @Route("/prise/commande", name="app_prise_commande")
     */
    public function index(Request $request,  EntityManagerInterface $entityManager): Response
    {


        $commande = new Commande();
        $form = $this->createForm(RegistrationCommandeType::class, $commande);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $this->addFlash("success", "La Commande a bien été ajouté");

            $entityManager->persist($commande);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_prise_commande');
        }



        return $this->render('prise_commande/index.html.twig', [
            'RegistrationCommandeType' => $form->createView(),
        ]);
    }
}
