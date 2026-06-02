<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ApiSecurityController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $client
    ) {
    }

    #[Route('/api-login', name: 'api_login', methods: ['GET', 'POST'])]
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $response = $this->client->request(
                'POST',
                $this->getParameter('app.api_url') . '/signin',
                [
                    'json' => [
                        'username' => $request->request->get('_username'),
                        'password' => $request->request->get('_password'),
                    ],
                ]
            );

            if (200 === $response->getStatusCode()) {
                $content = json_decode($response->getContent(), true);

                // Stocker le token JWT si present (API distante)
                if (isset($content['token'])) {
                    $request->getSession()->set('token', $content['token']);
                }

                // Stocker les cookies de session de l'API (API locale)
                $cookies = $response->getHeaders(false)['set-cookie'] ?? [];
                if (!empty($cookies)) {
                    $request->getSession()->set('api_cookies', $cookies);
                }

                return $this->redirectToRoute('api_character_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('api-security/login.html.twig');
    }
}
