<?php
declare (strict_types = 1);
namespace MyApp\Entity;

class Currency
{
    private ?int $id = null;
    private string $name;
    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getid(): ?int
    {
        return $this->id;
    }

    public function setid(?int $id): void
    {
        $this->id = $id;
    }

    public function getname(): string
    {
        return $this->name;
    }

    public function setname(string $name): void
    {
        $this->name = $name;
    }
}
