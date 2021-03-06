<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MainController extends AbstractController
{
    const URL = 'https://reqres.in/api/users/';

    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    #[Route('/users/{id}', name: 'get_user')]
    public function findUser(int $id): Response
    {
        $response = $this->httpClient->request(
            'GET',
            self::URL . $id
        )->getContent();

        return new Response($response);
    }

}
