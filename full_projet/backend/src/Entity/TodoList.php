<?php

namespace App\Entity;

use App\Repository\TodoListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TodoListRepository::class)]
class TodoList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'todoList', targetEntity: Todo::class, cascade: ['persist', 'remove'])]
    private Collection $todos;

    public function __construct()
    {
        $this->todos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Todo>
     */
    public function getTodos(): Collection
    {
        return $this->todos;
    }

    public function addTodo(Todo $todo): self
    {
        if (!$this->todos->contains($todo)) {
            $this->todos->add($todo);
            $todo->setTodoList($this);
        }

        return $this;
    }

    public function removeTodo(Todo $todo): self
    {
        if ($this->todos->removeElement($todo)) {
            // set the owning side to null (unless already changed)
            if ($todo->getTodoList() === $this) {
                $todo->setTodoList(null);
            }
        }

        return $this;
    }
}
