<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Produits;
use PDO;

class ProduitsModel
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllProduits(): array
    {
        $sql = "SELECT * FROM Produits";
        $stmt = $this->db->query($sql);
        $Produits = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $Produits[] = new Produits($row['id'], $row['nom'], $row['prix']);
        }
        return $Produits;
    }
    public function getOneProduits(int $id): ?Produits
    {
        $sql = "SELECT * from Produits where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new Produits($row['id'], $row['nom'], $row['prix']);
    }
    public function updateProduits(Produits $Produits): bool
    {
        $sql = "UPDATE Produits SET prix = :prix, nom = :nom WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':prix', $Produits->getprix(), PDO::PARAM_STR);
        $stmt->bindValue(':nom', $Produits->getnom(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $Produits->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }
}
