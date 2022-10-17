<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ExpertController extends AbstractController
{
    /**
     * @Route("/expert", name="app_expert")
     */
    public function tableauDeBord(CommandeRepository $repository): Response
    {
        $commandeProfil = $repository->findOperationUserEncours($this->getUser());
        return $this->render('expert/index.html.twig', [
            'commandeProfil' => $commandeProfil,
            'controller_name' => 'ExpertController'
        ]);
    }

    /**
     * @Route("/expert/operations", name="app_expert_operations")
     */
    public function ajouterUneOperation(CommandeRepository $repository): Response
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
    public function comfirmerOperation(Commande $commandes = null, Request $request, EntityManagerInterface $entityManager, CommandeRepository $repository): Response
    {
        if (!$commandes) {
            $commandes = new Commande();
        }
        $user = $this->getUser();
        $compteurCommande = $repository->findUserCompteur($this->getUser());
        $compteurCommande = count($compteurCommande);

        if ($compteurCommande < 5) {
            $commandes->setUser($user);
            $commandes->setStatut("En cours");
            $entityManager->persist($commandes);
            $entityManager->flush();
            $this->addFlash("success", "La commande a bien été confirmé");
            return $this->redirectToRoute("app_expert_operations");
        } else {
            $this->addFlash("wrong", "Vous avez atteint le nombre maximum d'operations ! veuillez terminer une opération afin de pouvoir en traiter une nouvelle.");
            return $this->redirectToRoute("app_expert_operations");
        }

        return $this->render('expert/operationAjoutCommande.html.twig', [
            "commande" => $commandes,
            "user" => $commandes
        ]);
    }

    /**
     * @Route("/expert/operationsliste", name="app_liste_operations")
     */
    public function listerMesOperations(CommandeRepository $repository): Response
    {
        $commandeProfil = $repository->findBy(
            array('user' =>  $this->getUser()),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('expert/operationsListe.html.twig', [
            'commandeProfil' => $commandeProfil,
        ]);
    }

    /**
     * @Route("/expert{id}", name="expert_operations_terminer", methods="POST|GET")
     */
    public function terminerOperation(MailerService $mailer, CommandeRepository $repository, Commande $commandes = null, Request $request, EntityManagerInterface $entityManager): Response
    { {
            if (!$commandes) {
                $commandes = new Commande();
            }
        }

        $compteurCommande = $repository->findUserCompteur($this->getUser());
        $compteurCommande = count($compteurCommande);

        $commandes->setUser($this->getUser());
        $commandes->setStatut("Terminer");
        $entityManager->persist($commandes);
        $entityManager->flush();
        $mailer->sendEmail();
        // Ajout de l'envoi email au client pour confirmer la commande terminer et de la facture en piece jointe 
        // <<<<<<<<<<<<<<
        $this->addFlash("success", "La commande a bien été traité");
        return $this->redirectToRoute("app_expert");

        // return $this->render('expert/operationTermineCommande.html.twig', [
        //     "commande" => $commandes,
        // ]);
    }

    /**
     * @Route("/expert/chiffre/affaire", name="app_chiffre_affaire")
     */
    public function index(CommandeRepository $repository): Response
    {
        $chiffreAffaireEnCours = $repository->chiffreAffaireEnCours();
        $chiffreAffaireTerminer = $repository->chiffreAffaireTerminer();
        $chiffreAffaireEnAttente = $repository->chiffreAffaireEnAttente();

        return $this->render('expert/chiffreAffaire.html.twig', [
            'chiffreAffaireEnCours' => $chiffreAffaireEnCours,
            'chiffreAffaireTerminer' => $chiffreAffaireTerminer,
            'chiffreAffaireEnAttente' => $chiffreAffaireEnAttente
        ]);
    }
}
