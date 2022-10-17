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
     * @Route("/expert/prise/commande", name="app_prise_commande_expert")
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

            return $this->redirectToRoute('app_prise_commande_expert');
        }
        return $this->render('expert/ajoutCommande.html.twig', [
            'RegistrationCommandeType' => $form->createView(),
        ]);
    }

    /**
     * @Route("/senior/prise/commande", name="app_prise_commande")
     */
    public function indexSenior(Request $request,  EntityManagerInterface $entityManager): Response
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
        return $this->render('senior/commande.html.twig', [
            'RegistrationCommandeType' => $form->createView(),
        ]);
    }


    /**
     * @Route("/apprenti/prise/commande", name="app_prise_commande_apprenti")
     */
    public function indexApprenti(Request $request,  EntityManagerInterface $entityManager): Response
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

            return $this->redirectToRoute('app_prise_commande_apprenti');
        }
        return $this->render('apprenti/commande.html.twig', [
            'RegistrationCommandeType' => $form->createView(),
        ]);
    }
}
