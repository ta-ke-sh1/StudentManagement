<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/homepage', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    #[Route('/login', name: 'login')]
    public function Login()
    {
        return $this->render('page/login.html.twig');
    }
}

