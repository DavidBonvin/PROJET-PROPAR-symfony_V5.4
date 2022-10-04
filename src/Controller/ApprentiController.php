<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApprentiController extends AbstractController
{
    /**
     * @Route("/apprenti", name="app_apprenti")
     */
    public function index(): Response
    {
        return $this->render('apprenti/index.html.twig', [
            'controller_name' => 'ApprentiController',
        ]);
    }
}
