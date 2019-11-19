<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/home", name="home_index")
     */
    public function index(): Response
    {
        return $this->render('home.html.twig', ['home' => 'Bienvenue']);
    }
}