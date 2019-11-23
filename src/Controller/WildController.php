<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', ['website' => 'Wild Series',]);
    }

    /**
     * @Route("/wild/show/{slug}", name="wild_show", requirements={"slug"="[a-z0-9\-]*"})
     * @param $slug
     * @return Response
     */
    public function show($slug): Response
    {
        if ($slug ==='') {
            return $this->render('wild/show.html.twig', ['slug' => $slug = "Aucune série sélectionnée, veuillez choisir une série"]);
        }

        return $this->render('wild/show.html.twig', ['slug' => $slug = ucwords(str_replace('-', ' ', $slug))]);
    }
}
