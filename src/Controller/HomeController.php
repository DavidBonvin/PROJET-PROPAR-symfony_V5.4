<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
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
        
        $commandeEnCours = $repository->findBy(array('statut' => 'En cours'),
        array('date' => 'desc'),null,null);

        
        $commandeEnTermine = $repository->findBy(array('statut' => 'Termine'),
        array('date' => 'desc'),null,null);
        
        
        
        return $this->render('home/index.html.twig', [
            'commandeEnCours' => $commandeEnCours,
            'commandeTermine' => $commandeEnTermine,

        ]);
    }



    // public function index(OperationRepository $repository): Response
    // {
    //     $operations = $repository->findAll();
    //     return $this->render('admin/admin_operation/adminOperation.html.twig', [
    //         "operations" => $operations
    //     ]);
    // }
}
