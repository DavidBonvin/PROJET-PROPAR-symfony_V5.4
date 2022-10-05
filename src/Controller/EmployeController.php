<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Operation;
use App\Form\EmployeType;
use App\Form\OperationType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as SecurityCore;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class EmployeController extends AbstractController
{
    /**
     * @Route("/expert/employe", name="liste_employe")
     */
    public function index(UserRepository $repository): Response
    {
        $employe = $repository->findAll();

        return $this->render(
            'employe/liste.html.twig',
            array('employe' => $employe)
        );
    }

    /**
     * @Route("/expert/employe/{id}" , name="employe_delete", methods="delete")
     */
    public function deleteEmploye($id, UserRepository $repository,  Request $request, EntityManagerInterface $entityManager)
    {
        if ($this->isCsrfTokenValid("SUP" . $id, $request->get('_token'))) {

            $employe = $repository->find($id);

            $entityManager->remove($employe);
            $entityManager->flush();
            return $this->redirectToRoute("liste_employe");
        };
    }

    /**
     * @Route("/expert/employe/{id}", name="expert_modifier", methods="POST|GET")
     */
    public function modification(User $employe = null, Request $request, EntityManagerInterface $entityManager): Response
    { {
            if (!$employe) {
                $employe = new User();
            }
        }
        $form = $this->createForm(EmployeType::class, $employe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employe);
            $entityManager->flush();
            $this->addFlash("success", "La modification a été efffectuée");
            return $this->redirectToRoute("liste_employe");
        }
        return $this->render('employe/modificationEmploye.html.twig', [
            "employe" => $employe,
            "form" => $form->createView(),
            "isModification" => $employe->getId() !== null
        ]);
    }
}
