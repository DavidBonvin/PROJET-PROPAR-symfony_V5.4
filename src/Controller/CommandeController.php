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
        return $this->render('commande/commandes.html.twig', [
            'commandes' => $commandes,
            'isStatut'=>false
        ]);
    }

    #[Route('/commandes/{Statut}', name: 'CommandesParStatut')]
    public function commandesEnCours(CommandeRepository $repo, $Statut): Response
    {
        $commandes = $repo->getCommandeParStatut($Statut);
        return $this->render('commande/commandes.html.twig', [
            'commandes' => $commandes,
            'isStatut'=>true
        ]);
    }
}
