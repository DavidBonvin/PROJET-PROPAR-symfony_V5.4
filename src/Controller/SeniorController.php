<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeniorController extends AbstractController
{
    /**
     * @Route("/senior", name="app_senior")
     */
    public function index(): Response
    {
        return $this->render('senior/index.html.twig', [
            'controller_name' => 'SeniorController',
        ]);
    }
}
