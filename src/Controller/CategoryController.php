<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $em =$this->getDoctrine()->getManager();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $category = $form->getData();
            $em->persist($category);
            $em->flush();
        }



        return $this->render('category/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
