<?php

namespace App\Service;


use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiAdresseService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getApiGouv(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/?q=135 rue jeanne &limit=15&postcode=59110'
        );
        return $response->toArray();
    }
}
