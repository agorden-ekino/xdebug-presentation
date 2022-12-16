<?php

namespace App\Controller;

use App\Client\RickAndMortyClientApi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RickAndMortyClientApiController extends AbstractController
{

    private $clientApi;

    public function __construct(RickAndMortyClientApi $clientApi) {
        $this->clientApi = $clientApi;
    }

    #[Route('/random-character', name: 'random_character')]
    public function displayRandomCharacter(): Response
    {
        $randomCharacter = $this->clientApi->getRandomCharacter();

        return $this->render('rick_and_morty_client_api/random-character.html.twig', [
            'random_character' => $randomCharacter,
        ]);
    }

    #[Route('/filtered-characters', name: 'filtered_characters')]
    public function index(): Response
    {
        $filteredCharacters = $this->clientApi->getCharactersWithFilters();

        return $this->render('rick_and_morty_client_api/filtered-characters.html.twig', [
            'filtered_characters' => $filteredCharacters,
        ]);
    }
}
