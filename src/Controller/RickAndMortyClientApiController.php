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

    #[Route('/rick/and/morty/client/api', name: 'app_rick_and_morty_client_api')]
    public function index(): Response
    {
        $randomCharacter = $this->clientApi->getRandomCharacter();

        return $this->render('rick_and_morty_client_api/index.html.twig', [
            'random_character' => $randomCharacter,
        ]);
    }
}
