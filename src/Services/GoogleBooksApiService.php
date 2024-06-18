<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleBooksApiService
{
    private $client;
    private $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function getBookByIsbn(string $isbn): ?array
    {
        $url = sprintf('https://www.googleapis.com/books/v1/volumes?q=isbn:%s&key=%s', $isbn, $this->apiKey);
        $response = $this->client->request('GET', $url);

        $data = $response->toArray();

        if (!isset($data['items'][0]['volumeInfo'])) {
            return null;
        }

        return $data['items'][0]['volumeInfo'];
    }
}
