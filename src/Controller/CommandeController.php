<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    #[Route('/commandes', name: 'commandes')]
    public function index(CommandeRepository $repo): Response
    {

        $commandes = $repo->findAll();
        $commandesEnCours=$repo->findBy(array('Statut'=>'EnCours'),
        array('date'=>'desc'),null,null);
        $commandesTermines=$repo->findBy(array('Statut'=>'Termine'),
        array('date'=>'desc'),null,null);
        return $this->render('commande/commandes.html.twig', [
            'commandesEnCours'=>$commandesEnCours,
            'commandesTermines'=>$commandesTermines,
            'commandes' => $commandes,
            'isStatut'=>false
        ]);
    }

    #[Route('/commandes/{Statut}', name: 'CommandesParStatut')]
    public function commandesEnCours(CommandeRepository $repo, $Statut): Response
    {
        $commandes = $repo->getCommandeParStatut('Statut','=',$Statut);
        return $this->render('commande/commandes.html.twig', [
            'commandes' => $commandes,
            'isStatut'=>true
        ]);
    }

    
}
