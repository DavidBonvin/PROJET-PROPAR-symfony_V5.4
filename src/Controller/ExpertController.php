<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExpertController extends AbstractController
{
    /**
     * @Route("/expert", name="app_expert")
     */
    public function index(CommandeRepository $repository): Response
    {
        $commandeProfil = $repository->findBy(
            array('statut' => 'En cours'),
            array('date' => 'desc'),
            null,
            null
        );
        return $this->render('expert/index.html.twig', [
            'commandeProfil' => $commandeProfil,
            'controller_name' => 'ExpertController'
        ]);
    }
}
