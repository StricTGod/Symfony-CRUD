<?php

namespace App\Controller;

use App\DataFixtures\AppFixtures;
use App\Repository\TodoRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    private TodoRepository $todoRepository;

    public function __construct(
        TodoRepository $todoRepository,
    ){
        $this->todoRepository = $todoRepository;
    }

    /**
     * @Route("/todo", name="todo", methods={"GET"})
     */
    public function index(): Response
    {
        $todos = $this->todoRepository->findBy([], ['created_at' => 'DESC']);

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }
}
