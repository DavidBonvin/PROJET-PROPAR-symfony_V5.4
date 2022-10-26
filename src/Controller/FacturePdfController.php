<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Service\PdfService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FacturePdfController extends AbstractController
{
    /**
     * @Route("/pdf/{id}", name="afficherCommande")
     */
    public function afficherCommandeTermine(Commande $commande = null, PdfService $pdf)
    {
        $html = $this->render('pdf/basepdf.html.twig', [
            "commande" => $commande,
        ]);
        $pdf->showPdfFile($html);
        return $this->render('pdf/basepdf.html.twig', [
            "commande" => $commande,
        ]);
    }
}
