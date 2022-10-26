<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Commande;
use App\Service\PdfService;
use App\Service\MailerService;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class  ApprentiController extends AbstractController
{
    /**
     * @Route("/apprenti", name="app_apprenti")
     */
    public function tableauDeBord(CommandeRepository $repository): Response
    {
        // recuperation de donnée de l'utilisateur actuel qui a des commande en cours
        // grace a findOperationUserEncours de commandeRepository
        $commandeProfil = $repository->findOperationUserEncours($this->getUser());
        return $this->render('apprenti/index.html.twig', [
            'commandeProfil' => $commandeProfil,
            'controller_name' => 'ApprentitController'
        ]);
    }
    /**
     * @Route("/apprenti/operations", name="app_apprenti_operations")
     */
    public function ajouterUneOperation(CommandeRepository $repository): Response
    {
        // recuperation de donnée grace a la methode findBy de CommandeRepository qui resulte les statut en attente trié par date
        $commandeEnAttente = $repository->findBy(
            array('statut' => 'En attente'),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('apprenti/operations.html.twig', [
            'commandeEnAttente' => $commandeEnAttente,
        ]);
    }
     /**
     * @Route("/apprenti/operations/{id}", name="apprenti_operations", methods="POST|GET")
     */
    public function confirmerOperation(Commande $commandes, Request $request, EntityManagerInterface $entityManager, CommandeRepository $repository): Response
    {
        if (!$commandes) {
            $commandes = new Commande();
        }
        // recuperation de donné grace a la methode findUserCompteur qui indique combien de commande sont 'en cours'
        //  de l'utilisateur actuel = $this->getUser() 
        $compteurCommande = $repository->findUserCompteur($this->getUser());
        // compteurCommande indique donc un tableau avec les reponses des commande = en cours 
        // la fonction count est utilisé afin de convertir le resultat en tableau en integer afin de comparer
        $compteurCommande = count($compteurCommande);
        // on compare donc cette donnée a 5 pour l'expert 
        if ($compteurCommande < 1) {
            //modification en settant l'utilisateur actuel et le statut en cours 
            $commandes->setUser($this->getUser());
            $commandes->setStatut("En cours");
            $entityManager->persist($commandes);
            $entityManager->flush();

            //message de validation 
            $this->addFlash("successs", "L'operation a bien été ajouté.");
            //redirection
            return $this->redirectToRoute("app_apprenti_operations");
        } else {
            //si la comparaion n'est pas plus petit que 5 alors elle affiche message d'erreur et redirige
            $this->addFlash("wrong", "Vous avez atteint le nombre maximum d'operations ! veuillez terminer une opération afin de pouvoir en traiter une nouvelle.");
            return $this->redirectToRoute("app_apprenti_operations");
        }

        return $this->render('apprenti/operationAjoutCommande.html.twig', [
            "commande" => $commandes,
            "user" => $commandes
        ]);
    }
    /**
     * @Route("/apprenti/operationsliste", name="apprenti_liste_operations")
     */
    public function listerMesOperations(CommandeRepository $repository): Response
    {
        //recuperation de donnée en bdd de l'utilisatateur actuel trié par date 
        $commandeProfil = $repository->findBy(
            array('user' =>  $this->getUser()),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('apprenti/operationsListe.html.twig', [
            'commandeProfil' => $commandeProfil,
        ]);
    }
    /**
     * @Route("/apprenti/{id}", name="apprenti_operations_terminer", methods="POST|GET")
     */
    public function terminerOperation(KernelInterface $kernelInterface, PdfService $pdfservice, MailerService $mailer, Commande $commandes = null, EntityManagerInterface $entityManager): Response
    {
        // stockage du template de la facure dans la variable html
        $html =  $this->renderView('pdf/basepdf.html.twig', [
            "commande" => $commandes,
        ]);
        // creation d'un nouveau pdf 
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();
        $result = $dompdf->output();

        // creation du fichier facture.pdf dans le dossier public/pdf/
        $fs = new Filesystem();
        $FilePdf = $kernelInterface->getProjectDir() . "/public/pdf";
        $pdf = $FilePdf . "/facture.pdf";
        $fs->dumpFile($pdf, $result);

        if (!$commandes) {
            $commandes = new Commande();
        }
        //  modifie le statut, ajoute l'id de l'utilisateur actuel et insere en bdd
        $commandes->setUser($this->getUser());
        $commandes->setStatut("Terminer");

        //recuperation de l'email du client
        $email = $commandes->getClient()->getEmail();

        //insertion en bdd
        $entityManager->persist($commandes);
        $entityManager->flush();

        // Envoi de l'email au client <<<<<<<<<<<
        $mailer->sendEmail($email);

        //message de validation
        $this->addFlash("success", "L'operation est terminé, un email de confirmation a été envoyé au client.");

        //redirection vers la page actuelle
        return $this->redirectToRoute("app_apprenti");
    }


}
