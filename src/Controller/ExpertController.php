<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Form\RegistrationOperationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\RegistrationOperationTerminerType;
use App\Repository\OperationRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

        $form = $this->createForm(RegistrationOperationType::class, $commandes);
        $form->handleRequest($request);

        // $test = $repository->findByExampleField();


        $sql = "SELECT sum(prix) 
        FROM commande c
        inner join operation o on c.operation_id = o.id
        WHERE c.statut = 'En cours'";

        $stmt = $entityManager->createQuery($sql);
        $result = $stmt->getResult();

        $compteurExpert = $repository->findUserCompteur($this->getUser());
        if (count($compteurExpert) < 5) {
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commandes);
                $entityManager->flush();
                $this->addFlash("success", "La commande a bien été comfirmé");
                return $this->redirectToRoute("app_expert");
            }
        } else {
            $this->addFlash("wrong", "Vous avez atteint le nombre maximum d'operations ! veuillez terminer une opération afin de pouvoir en traiter une nouvelle.");
            return $this->redirectToRoute("app_expert_operations");
        }
        return $this->render('expert/operationAjoutCommande.html.twig', [
            "commande" => $commandes,
            "form" => $form->createView(),
            "user" => $result
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
    public function terminerOperation(Commande $commandes = null, Request $request, EntityManagerInterface $entityManager): Response
    { {
            if (!$commandes) {
                $commandes = new Commande();
            }
        }
        $form = $this->createForm(RegistrationOperationTerminerType::class, $commandes);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandes);
            $entityManager->flush();
            $this->addFlash("success", "La commande a bien été traité");
            return $this->redirectToRoute("app_expert");
        }
        return $this->render('expert/operationTermineCommande.html.twig', [
            "commande" => $commandes,
            "form" => $form->createView()
        ]);
    }
}
