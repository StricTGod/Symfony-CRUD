<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="products", methods={"GET"})
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $products = $doctrine->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/open-create-modal", name="open_create_modal", methods={"GET"})
     */
    public function openCreateModal(ManagerRegistry $doctrine): Response
    {
        $categories = $doctrine->getManager()->getRepository(Category::class)->findAll();

        return $this->render('product/new.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("product/create", name="product_create", methods={"POST"})
     */
    public function createProduct(ManagerRegistry $doctrine, Request $request): Response
    {
        $product = new Product();
        $entityManager = $doctrine->getManager();
        $category = $entityManager->getRepository(Category::class)->find($request->get('category'));

        $product->setName($request->get('name'));
        $product->setPrice($request->get('price'));
        $product->setDescription($request->get('description'));
        $product->setIsHidden($request->get('is_hidden'));
        $product->setCategory($category);

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('The product was created');
    }

    /**
     * @Route("/open-update-modal/{id}", name="open_update_modal", methods={"GET"})
     */
    public function openUpdateModal(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('product/open_update_modal.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product-update", name="product_update", methods={"POST"})
     */
    public function updateProduct(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($request->get('id'));

        $product->setName($request->get('name'));
        $product->setPrice($request->get('price'));
        $product->setDescription($request->get('description'));

        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('The product was updated');
    }

    /**
     * @Route("/product-delete/{id}", name="product_delete", methods={"GET"})
     */
    public function deleteProduct(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('products');
    }
}
