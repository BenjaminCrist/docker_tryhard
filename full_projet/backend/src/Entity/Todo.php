<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoRepository::class)]
class Todo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'todos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TodoList $todoList = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getTodoList(): ?TodoList
    {
        return $this->todoList;
    }

    public function setTodoList(?TodoList $todoList): static
    {
        $this->todoList = $todoList;

        return $this;
    }
}
