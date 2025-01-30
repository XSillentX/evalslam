<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Currency;
use PDO;

class CurrencyModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function getAllCurrency(): array
    {
        $sql = "SELECT * FROM Currency";
        $stmt = $this->db->query($sql);
        $currency = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $currency[] = new Currency($row['id'], $row['name']);
        }
        return $currency;
    }
    public function getOneCurrency(int $id): ?Currency
    {
        $sql = "SELECT * from Currency where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Currency($row['id'], $row['name']);
    }
    public function updateCurrency(Currency $Currency): bool
    {
        $sql = "UPDATE Currency SET name = :name WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $Currency->getname(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $Currency->getid(), PDO::PARAM_INT);
        return $stmt->execute();
    }
}
