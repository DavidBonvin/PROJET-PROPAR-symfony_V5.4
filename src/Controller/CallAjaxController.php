<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Util\Json;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SerializerSerializerInterface;

class CallAjaxController extends AbstractController
{
    /**
     * @Route("/call/ajax/operationsListe", name="app_call_ajax")
     */
    public function index(CommandeRepository $repository, NormalizerInterface $normalizer, SerializerSerializerInterface $serial): JsonResponse
    {
        $commandeProfil = $repository->findBy(
            array('user' =>  $this->getUser()),
            array('date' => 'desc'),
            null,
            null
        );
        $result = $normalizer->normalize($commandeProfil, 'json', ['groups' => 'show_product']);
        return $this->json([
            $result
        ]);
    }
}
