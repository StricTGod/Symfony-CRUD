<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    /**
     * @Route("/open-create-category", name="open_create_category", methods={"GET"})
     */
    public function openCreateCategory(): Response
    {
        return $this->render('category/open_create_category.html.twig');
    }

    /**
     * @Route("category/create", name="category_create", methods={"POST"})
     */
    public function createCategory(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $category = new Category();

        $category->setName($request->get('name'));

        $entityManager->persist($category);
        $entityManager->flush();

        return new Response('The category was created');
    }

}
