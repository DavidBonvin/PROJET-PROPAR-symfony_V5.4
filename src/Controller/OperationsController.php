<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Form\RegistrationOperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OperationsController extends AbstractController
{
    /**
     * @Route("/expert/operations", name="app_expert_operations")
     */
    public function index(CommandeRepository $repository): Response
    {
        $commandeEnAttente = $repository->findBy(
            array('statut' => 'En attente'),
            array('date' => 'desc'),
            null,
            null
        );

        return $this->render('expert/operations.html.twig', [
            'commandeEnAttente' => $commandeEnAttente,
        ]);
    }


    /**
     * @Route("/expert/operations/{id}", name="expert_operations", methods="POST|GET")
     */
    public function modification(Commande $commandes = null, Request $request, EntityManagerInterface $entityManager): Response
    { {
            if (!$commandes) {
                $commandes = new Commande();
            }
        }
        if ($this->getUser() === ["ROLE_EXPERT"]) {
        }
        $user = $this->getUser();
        $form = $this->createForm(RegistrationOperationType::class, $commandes);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandes);
            $entityManager->flush();
            $this->addFlash("success", "La commande a bien été comfirmé");
            return $this->redirectToRoute("app_expert");
        }
        return $this->render('expert/operationAjoutCommande.html.twig', [
            "commande" => $commandes,
            "form" => $form->createView(),
            "user" => $user
        ]);
    }

    /**
     * @Route("/expert/operationsliste", name="app_liste_operations")
     */
    public function listeOperations(CommandeRepository $repository): Response
    {
        $userId = $this->getUser();
        $commandeProfil = $repository->findBy(
            array('user' => $userId),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('expert/operationsListe.html.twig', [
            'commandeProfil' => $commandeProfil,
        ]);
    }
}
