<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApprentiController extends AbstractController
{
    /**
     * @Route("/apprenti", name="app_apprenti")
     */
    public function index(CommandeRepository $repository): Response
    {
        $commandeEnCours = $repository->findBy(
            array('statut' => 'En cours'),
            array('date' => 'desc'),
            null,
            null
        );
        $commandeEnTermine = $repository->findBy(
            array('statut' => 'Termine'),
            array('date' => 'desc'),
            null,
            null
        );

        return $this->render('apprenti/index.html.twig', [
            'commandeEnCours' => $commandeEnCours,
            'commandeTermine' => $commandeEnTermine,
        ]);
    }
}
