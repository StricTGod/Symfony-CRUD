<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface $em;

    public function __construct(
        CategoryRepository $categoryRepository,
        EntityManagerInterface $em
    ){
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;
    }

    /**
     * @Route("/categories", name="categories", methods={"GET"})
     */
    public function listOfCategory(Request $request): Response
    {
        $sortDir = $request->query->get('sortDir') ?? 'ASC';

        $categories = $this->categoryRepository->getCategories($sortDir);

        return $this->render('category/list_of_category.html.twig', ['categories' => $categories]);
    }

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
    public function createCategory(Request $request): Response
    {
        $category = new Category();

        $category->setName($request->get('name'));

        $this->em->persist($category);
        $this->em->flush();

        return new Response('The category was created');
    }
}
