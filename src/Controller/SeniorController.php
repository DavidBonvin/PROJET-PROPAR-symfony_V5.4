<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Form\RegistrationOperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\RegistrationOperationTerminerType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeniorController extends AbstractController
{
    /**
     * @Route("/senior", name="app_senior")
     */
    public function tableauDeBord(CommandeRepository $repository): Response
    {
        $commandeProfil = $repository->findOperationUserEncours($this->getUser());
        return $this->render('senior/index.html.twig', [
            'controller_name' => 'SeniorController',
            'commandeProfil' => $commandeProfil,
        ]);
    }

    /**
     * @Route("/senior{id}", name="senior_operations_terminer", methods="POST|GET")
     */
    public function terminerOperation(CommandeRepository $repository, Commande $commandes = null, Request $request, EntityManagerInterface $entityManager): Response
    { {
            if (!$commandes) {
                $commandes = new Commande();
            }
        }
        $user = $this->getUser();
        $compteurCommande = $repository->findUserCompteur($this->getUser());
        $compteurCommande = count($compteurCommande);

        $commandes->setUser($user);
        $commandes->setStatut("Terminer");
        $entityManager->persist($commandes);
        $entityManager->flush();
        $this->addFlash("success", "La commande a bien été traité");

        return $this->redirectToRoute("app_senior");
    }

    /**
     * @Route("/senior/operations", name="app_senior_operations")
     */
    public function ajouterUneOperation(CommandeRepository $repository): Response
    {
        $commandeEnAttente = $repository->findBy(
            array('statut' => 'En attente'),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('senior/operations.html.twig', [
            'commandeEnAttente' => $commandeEnAttente,
        ]);
    }

    /**
     * @Route("/senior/operationsliste", name="app_liste_operations_senior")
     */
    public function listerMesOperations(CommandeRepository $repository): Response
    {
        $commandeProfil = $repository->findBy(
            array('user' =>  $this->getUser()),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('senior/operationsListe.html.twig', [
            'commandeProfil' => $commandeProfil,
        ]);
    }

    /**
     * @Route("/senior/operations/{id}", name="senior_operations", methods="POST|GET")
     */
    public function comfirmerOperation(Commande $commandes = null, Request $request, EntityManagerInterface $entityManager, CommandeRepository $repository): Response
    {
        if (!$commandes) {
            $commandes = new Commande();
        }
        $user = $this->getUser();
        $compteurCommande = $repository->findUserCompteur($this->getUser());
        $compteurCommande = count($compteurCommande);

        if ($compteurCommande < 3) {
            $commandes->setUser($user);
            $commandes->setStatut("En cours");
            $entityManager->persist($commandes);
            $entityManager->flush();
            $this->addFlash("success", "La commande a bien été confirmé");
            return $this->redirectToRoute("app_senior_operations");
        } else {
            $this->addFlash("wrong", "Vous avez atteint le nombre maximum d'operations ! veuillez terminer une opération afin de pouvoir en traiter une nouvelle.");
            return $this->redirectToRoute("app_senior_operations");
        }
    }
}
