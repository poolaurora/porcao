<?php

namespace App\Services;

use GuzzleHttp\Client;

class BinLookupService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getBinDetails($binNumber)
    {
        if (!$binNumber) {
            return null; // Retorna null ou lança uma exceção, dependendo da sua preferência de design
        }
    
        $response = $this->client->request('GET', "https://data.handyapi.com/bin/{$binNumber}");

        // Verifica se a resposta foi bem-sucedida
        if ($response->getStatusCode() === 200) {
            $details = json_decode($response->getBody()->getContents(), true);
            
            if ($details['Status'] !== 'SUCCESS') {
                return null; // Retorna null ou algum indicativo de falha
            }

            // Extrai apenas os campos desejados
            $filteredDetails = [
                'card-brand' => $details['Scheme'] ?? null,
                'card-type' => $details['Type'] ?? null,
                'issuer' => $details['Issuer'] ?? null,
                'card-category' => $details['CardTier'] ?? null,
                'country' => $details['Country']['Name'] ?? null,
                'valid' => $details['Luhn'] ?? 'false', // Asumindo um valor padrão
            ];

            return $filteredDetails; // Retorna um array com os detalhes
        }

        return null; // Retorna null se a resposta não for 200
    }
}



