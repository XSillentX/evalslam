<?php
declare (strict_types = 1);
namespace MyApp\Entity;
use MyApp\Entity\Currency;

class economic
{
    private ?int $id_zone = null;
    private string $name;
    private Currency $currency;
    
    public function __construct(?int $id, string $name, Currency $currency) 
    {
        $this->id = $id;
        $this->name = $name;
        $this->currency = $currency;
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
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
    public function getCurrency(): Currency
    {
        return $this->currency;
    }
    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }
}
