<?php

namespace App\Controller;

use App\Entity\Operation;
use App\Repository\OperationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OperationController extends AbstractController
{
    /**
     * @Route("/operations", name="operations")
     */
    public function index(OperationRepository $repository): Response
    {
        $operations =$repository ->findAll();
        return $this->render('operation/operations.html.twig', [
            'operations' => $operations
        ]);
    }

    /**
     * @Route("/operation/{id}", name="affichage_operation")
     */
    public function afficherOperation(Operation $operation): Response
    {
        return $this->render('operation/operation.html.twig', [
            'operation' => $operation
        ]);
    }
}
