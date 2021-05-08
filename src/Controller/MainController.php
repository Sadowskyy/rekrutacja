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

    #[Route('/users', name: 'create_user')]
    public function create(Request $request): Response
    {
        $response = $this->httpClient->request(
            'POST',
            self::URL,
            ['body' => [
                'name' => $request->request->get('name'),
                'job' => $request->request->get('job')
            ]]
        )->getContent();

        return new Response($response);
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
