<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ComController extends AbstractController
{
    #[Route('/com', name: 'app_com')]
    public function index(): Response
    {
        return $this->render('com/index.html.twig', [
            'controller_name' => 'ComController',
        ]);
    }
}
