<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Economic;
use MyApp\Entity\Currency;
use PDO;

class EconomicModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function getAllEconomic(): array
    {
        $sql = "SELECT m.id as id_zone, name, m.id as id, name FROM Economic m inner join Currency c on m.id = m.id order by name";
        $stmt = $this->db->query($sql);
        $economic = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $economic[] = new Economic($row['id_zone'], $row['name']);
        }
        return $economic;
    }
    public function getOneEconomic(int $id_zone): ?Economic
    {
        $sql = "SELECT * from Economic where id_zone = :id_zone";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Economic($row['id_zone'], $row['name']);
    }
}
