<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;


class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf = new Dompdf();
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'serial');

        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html)
    {

        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("facture.pdf", [
            'Attachement' => false
        ]);
    }
    public function getPdfEmail($html)
    {
        $this->domPdf->loadHtml($html);
        $this->domPdf->setPaper("A4", "portrait");
        $this->domPdf->render();
        $this->domPdf->output();
    }
}
