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

        if (isset($content['episode'])) {
            foreach ($content['episode'] as $episodeUrl) {
                $episodeNumber = basename($episodeUrl);
                $content['episodes_detailed']['episode_'.$episodeNumber] = $this->getEpisodeByNumber($episodeNumber);
            }
        }

        if (isset($content['origin']['url']) && $content['origin']['name'] !== 'unknown') {
            $originNumber = basename($content['origin']['url']);
            $content['origin_detailed'] = $this->getLocationByNumber($originNumber);
        }

        if (isset($content['location']['url']) && $content['location']['name'] !== 'unknown') {
            $locationNumber = basename($content['location']['url']);
            $content['location_detailed'] = $this->getLocationByNumber($locationNumber);
        }

        return $content;
    }

    public function getCharactersWithFilters()
    {
        $response = $this->client->request(
            self::METHOD_GET,
            '/api/character/',
            [
                'query' => [
                    'status' => 'unknown',
                    ]
            ]
        );
        $content = json_decode($response->getContent(), true);

        return $content;
    }

    public function getEpisodeByNumber(int $number)
    {
        $response = $this->client->request(
            self::METHOD_GET,
            '/api/episode/'.$number,
        );
        $content = json_decode($response->getContent(), true);

        return $content;
    }

    public function getLocationByNumber(int $number)
    {
        $response = $this->client->request(
            self::METHOD_GET,
            '/api/location/'.$number,
        );
        $content = json_decode($response->getContent(), true);

        return $content;
    }
}