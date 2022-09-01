<?php

namespace App\Controller;

use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    private TodoRepository $todoRepository;
    private EntityManagerInterface $em;

    public function __construct(
        TodoRepository         $todoRepository,
        EntityManagerInterface $em,
    )
    {
        $this->todoRepository = $todoRepository;
        $this->em = $em;
    }

    /**
     * @Route("/todo", name="todo", methods={"GET"})
     */
    public function index(): Response
    {
        $todos = $this->todoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    /**
     * @Route("/show-todo-data", name="show_todo_data", methods={"GET"})
     */
    public function showTodoData(): \Symfony\Component\HttpFoundation\JsonResponse
    {
        return $this->json($this->todoRepository->findAll());
    }

    /**
     * @Route("/is-completed-action", name="is_completed_action", methods={"POST"})
     */
    public function isCompletedAction(Request $request): Response
    {
        $todo = $this->todoRepository->getTodoById($request->get('id'));

        $isCompleted = $request->get('isCompleted');
        $todo->setIsCompleted((int)$isCompleted);

        $this->em->persist($todo);
        $this->em->flush();

        return $this->redirectToRoute('todo');
    }
}