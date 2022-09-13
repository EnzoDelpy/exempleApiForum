<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        $content = $this->getMessages();
        dump($content);
        $content = $content['hydra:member'];
        return $this->render('base/index.html.twig', [
            'messages' => $content
        ]);
    }

    public function getMessages(){
        $client = HttpClient::create();
        $response = $client->request('GET', 'http://localhost/forum/public/api/messages'
        );
        $statusCode = $response->getStatusCode();

        $content = '';
        if ($statusCode == 200) {
            $content = $response->getContent();
            $content = json_decode($content, true);           
        }
        return $content;
    }
}
