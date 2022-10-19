<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(CommandeRepository $repository): Response
    {

        $commandeEnCours = $repository->findBy(
            array('statut' => 'En cours'),
            array('date' => 'desc'),
            10,
            null
        );
        $commandeEnTermine = $repository->findBy(
            array('statut' => 'Terminer'),
            array('date' => 'desc'),
            10,
            null
        );
        return $this->render('home/index.html.twig', [
            'commandeEnCours' => $commandeEnCours,
            'commandeTermine' => $commandeEnTermine
        ]);
    }
}
