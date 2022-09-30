<?php

namespace App\Controller\Admin;

use App\Entity\Operation;
use App\Form\OperationType;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security as SecurityCore;

class AdminOperationController extends AbstractController
{
    /**
     * @Route("/admin/operation", name="admin_operation")
     */
    public function index(OperationRepository $repository): Response
    {
        $operations = $repository->findAll();
        return $this->render('admin/admin_operation/adminOperation.html.twig', [
            "operations" => $operations
        ]);
    }
    /**
     * @Route("/admin/operation/creation", name="admin_operation_creation")
     * @Route("/admin/operation/{id}", name="admin_operation_modification", methods="POST|GET")
     */
    public function modification(Operation $operation = null, Request $request, EntityManagerInterface $entityManager): Response
    { {
            if (!$operation) {
                $operation = new Operation();
            }
        }
        $form = $this->createForm(OperationType::class, $operation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($operation);
            $entityManager->flush();
            return $this->redirectToRoute("admin_operation");
        }
        return $this->render('admin/admin_operation/modifEtAjoutOperation.html.twig', [

            "operation" => $operation,
            "form" => $form->createView(),
            "isModification" => $operation->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/operation/{id}", name="supprimer", methods="delete")
     */
    public function suppression(Operation $operation = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($operation);
        $entityManager->flush();
        return $this->redirectToRoute("admin_operation");
    }
}