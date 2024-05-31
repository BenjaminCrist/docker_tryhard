<?php

// src/Controller/TodoController.php

namespace App\Controller;

use App\Entity\Todo;
use App\Entity\TodoList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/api/todos", methods={"GET"})
     */
    public function index(EntityManagerInterface $em)
    {
        $todos = $em->getRepository(Todo::class)->findAll();
        return $this->json($todos);
    }

    /**
     * @Route("/api/todos", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        $todo = new Todo();
        $todo->setContent($data['content']);

        $todoList = $em->getRepository(TodoList::class)->find($data['todoListId']);
        if (!$todoList) {
            return $this->json(['message' => 'TodoList not found'], 404);
        }

        $todo->setTodoList($todoList);

        $em->persist($todo);
        $em->flush();

        return $this->json($todo, 201, ['Access-Control-Allow-Origin', '*']);
    }

    /**
     * @Route("/api/todos/{id}", methods={"PUT"})
     */
    public function update(int $id, Request $request, EntityManagerInterface $em)
    {
        $todo = $em->getRepository(Todo::class)->find($id);
        if (!$todo) {
            return $this->json(['message' => 'Todo not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        $todo->setContent($data['content']);

        $em->flush();

        return $this->json($todo);
    }

    /**
     * @Route("/api/todos/{id}", methods={"DELETE"})
     */
    public function delete(int $id, EntityManagerInterface $em)
    {
        $todo = $em->getRepository(Todo::class)->find($id);
        if (!$todo) {
            return $this->json(['message' => 'Todo not found'], 404);
        }

        $em->remove($todo);
        $em->flush();

        return $this->json(['message' => 'Todo deleted']);
    }
}

