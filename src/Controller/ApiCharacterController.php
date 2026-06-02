<?php

namespace App\Controller;

use App\Form\ApiCharacterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/api-character')]
final class ApiCharacterController extends AbstractController
{
    public function __construct(
        private HttpClientInterface $client,
    ) {
    }

    private function getApiHeaders(Request $request): array
    {
        $headers = ['Accept' => 'application/json'];

        // Token JWT (API distante)
        $token = $request->getSession()->get('token');

        // Cookies de session (API locale)
        $cookies = $request->getSession()->get('api_cookies');
        if ($cookies) {
            $cookieStrings = [];
            foreach ($cookies as $cookie) {
                $cookieStrings[] = explode(';', $cookie)[0];
            }
            $headers['Cookie'] = implode('; ', $cookieStrings);
        }

        return $headers;
    }

    private function getApiOptions(Request $request): array
    {
        $options = ['headers' => $this->getApiHeaders($request)];

        $token = $request->getSession()->get('token');
        if ($token) {
            $options['auth_bearer'] = $token;
        }

        return $options;
    }

    #[Route('/', name: 'api_character_index', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $response = $this->client->request(
            'GET',
            $this->getParameter('app.api_url') . '/characters/',
            $this->getApiOptions($request)
        );

        return $this->render('api-character/index.html.twig', [
            'characters' => $response->toArray(),
        ]);
    }

    #[Route('/new', name: 'api_character_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $character = [];
        $form = $this->createForm(ApiCharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all()['api_character'];
            unset($data['_token']);
            $options = $this->getApiOptions($request);
            $options['json'] = $data;
            $response = $this->client->request(
                'POST',
                $this->getParameter('app.api_url') . '/characters/',
                $options
            );

            return $this->redirectToRoute('api_character_show', [
                'identifier' => $response->toArray()['identifier']
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api-character/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}', name: 'api_character_show', methods: ['GET'])]
    public function show(Request $request, string $identifier): Response
    {
        $response = $this->client->request(
            'GET',
            $this->getParameter('app.api_url') . '/characters/' . $identifier,
            $this->getApiOptions($request)
        );

        return $this->render('api-character/show.html.twig', [
            'character' => $response->toArray(),
        ]);
    }

    #[Route('/{identifier}/edit', name: 'api_character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, string $identifier): Response
    {
        $response = $this->client->request(
            'GET',
            $this->getParameter('app.api_url') . '/characters/' . $identifier,
            $this->getApiOptions($request)
        );
        $character = $response->toArray();

        $form = $this->createForm(ApiCharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->all()['api_character'];
            unset($data['_token']);
            $options = $this->getApiOptions($request);
            $options['json'] = $data;
            $this->client->request(
                'PUT',
                $this->getParameter('app.api_url') . '/characters/' . $identifier,
                $options
            );

            return $this->redirectToRoute('api_character_show', [
                'identifier' => $identifier
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('api-character/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{identifier}', name: 'api_character_delete', methods: ['POST'])]
    public function delete(Request $request, string $identifier): Response
    {
        if ($this->isCsrfTokenValid('delete' . $identifier, $request->request->get('_token'))) {
            $this->client->request(
                'DELETE',
                $this->getParameter('app.api_url') . '/characters/' . $identifier,
                $this->getApiOptions($request)
            );
        }

        return $this->redirectToRoute('api_character_index', [], Response::HTTP_SEE_OTHER);
    }
}
