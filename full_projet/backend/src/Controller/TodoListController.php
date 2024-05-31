<?php
// src/Controller/TodoListController.php

namespace App\Controller;

use App\Entity\TodoList;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoListController extends AbstractController
{
    /**
     * @Route("/api/todolists", methods={"GET"})
     */
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $todoLists = $em->getRepository(TodoList::class)->findAll();
        return $this->json($todoLists);
    }

    /**
     * @Route("/api/todolists", methods={"POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['name'])) {
            return $this->json(['message' => 'Invalid data'], 400);
        }
        $todoList = new TodoList();
        $todoList->setName($data['name']);

        $em->persist($todoList);
        $em->flush();

        return $this->json($data, 201);
    }

    /**
     * @Route("/api/todolists/{id}", methods={"GET"})
     */
    public function show(int $id, EntityManagerInterface $em): JsonResponse
    {
        $todoList = $em->getRepository(TodoList::class)->find($id);
        if (!$todoList) {
            return $this->json(['message' => 'TodoList not found'], 404);
        }

        return $this->json($todoList);
    }

    /**
     * @Route("/api/todolists/{id}", methods={"PUT"})
     */
    public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $todoList = $em->getRepository(TodoList::class)->find($id);
        if (!$todoList) {
            return $this->json(['message' => 'TodoList not found'], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['name'])) {
            return $this->json(['message' => 'Invalid data'], 400);
        }

        $todoList->setName($data['name']);
        $em->flush();

        return $this->json($todoList);
    }

    /**
     * @Route("/api/todolists/{id}", methods={"DELETE"})
     */
    public function delete(int $id, EntityManagerInterface $em): JsonResponse
    {
        $todoList = $em->getRepository(TodoList::class)->find($id);
        if (!$todoList) {
            return $this->json(['message' => 'TodoList not found'], 404);
        }

        $em->remove($todoList);
        $em->flush();

        return $this->json(['message' => 'TodoList deleted'], 200);
    }
}
