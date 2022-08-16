<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;
    private EntityManagerInterface $em;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $em
    ){
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;
    }

    /**
     * @Route("/products", name="products", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $sortDir = $request->query->get('sortDir') ?? 'ASC';
        $products = $this->productRepository->getProducts($sortDir);

        return $this->render('product/index.html.twig', ['products' => $products]);
    }

    /**
     * @Route("/open-create-modal", name="open_create_modal", methods={"GET"})
     */
    public function openCreateModal(Request $request): Response
    {
        $sortDir = $request->query->get('sortDir') ?? 'ASC';
        $categories = $this->categoryRepository->getCategories($sortDir);

        return $this->render('product/new.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("product/create", name="product_create", methods={"POST"})
     */
    public function createProduct(Request $request): Response
    {
        $product = new Product();
        $category = $this->categoryRepository->getCategoryById($request->get('category_id'));

        $product->setName($request->get('name'));
        $product->setPrice($request->get('price'));
        $product->setDescription($request->get('description'));
        $product->setIsHidden($request->get('is_hidden'));
        $product->setCategory($category);

        $this->em->persist($product);
        $this->em->flush();

        return new Response('The product was created');
    }

    /**
     * @Route("/open-update-modal/{id}", name="open_update_modal", methods={"GET"})
     */
    public function openUpdateModal(int $id): Response
    {
        $product = $this->productRepository->getProductById($id);

        return $this->render('product/open_update_modal.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/product-update", name="product_update", methods={"POST"})
     */
    public function updateProduct(Request $request): Response
    {
        $product = $this->productRepository->getProductById($request->get('id'));

        $product->setName($request->get('name'));
        $product->setPrice($request->get('price'));
        $product->setDescription($request->get('description'));

        $this->em->persist($product);
        $this->em->flush();

        return new Response('The product was updated');
    }

    /**
     * @Route("/product-delete/{id}", name="product_delete", methods={"GET"})
     */
    public function deleteProduct(int $id): Response
    {
        $product = $this->productRepository->getProductById($id);

        $this->em->remove($product);
        $this->em->flush();

        return $this->redirectToRoute('products');
    }
}
