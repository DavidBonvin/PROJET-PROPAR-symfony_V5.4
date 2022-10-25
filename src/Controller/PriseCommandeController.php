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
        $commande->setStatut("En attente");
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($commande);
            $entityManager->flush();

            

            return $this->redirectToRoute('app_expert_operations');
            $this->addFlash("success", "La commande a bien été ajouté");
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
        $commande->setStatut("En attente");

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();
            $this->addFlash("success", "La commande a bien été ajouté");

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
        $commande->setStatut("En attente");

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();
            $this->addFlash("success", "La commande a bien été ajouté");

            return $this->redirectToRoute('app_prise_commande_apprenti');
        }
        return $this->render('apprenti/commande.html.twig', [
            'RegistrationCommandeType' => $form->createView(),
        ]);
    }
}
