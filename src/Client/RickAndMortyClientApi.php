<?php

namespace App\Client;

use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RickAndMortyClientApi
{
    private const METHOD_GET = 'GET';

    private $client;

    public function __construct(#[Target('rickAndMortyApi')]HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCharacterCount()
    {
        $response = $this->client->request(
            self::METHOD_GET,
            '/api/character/'
        );
        $content = $response->getContent();
        $content = json_decode($content, true);

        return $content['info']['count'];
    }

    public function getRandomCharacter()
    {
        $response = $this->client->request(
            self::METHOD_GET,
            '/api/character/'.rand(1,$this->getCharacterCount())
        );
        $content = json_decode($response->getContent(), true);

        return $content;
    }
}