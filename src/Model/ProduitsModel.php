<?php
declare (strict_types = 1);
namespace MyApp\Model;

use MyApp\Entity\Produits;
use MyApp\Entity\Type;
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
        $sql = "SELECT p.id as idProduit, nom, description, prix, stock, t.id as idType, label FROM Produits p inner join Type t on p.idType = t.id order by nom";
        $stmt = $this->db->query($sql);
        $Produits = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $type = new Type($row['idType'], $row['label']);
            $Produits[] = new Produits($row['idType'], $row['nom'], $row['prix'], $row['description'], $row['stock'], $type);
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
        return new Produits($row['id'], $row['nom'], $row['prix'], $row['description'], $row['stock']);
    }
    public function updateProduits(Produits $Produits): bool
    {
        $sql = "UPDATE product SET nom = :nom, description = :description, prix = :prix,
        stock = :stock, idType = :idType WHERE id = :id";
        $stmt->bindValue(':prix', $Produits->getprix(), PDO::PARAM_STR);
        $stmt->bindValue(':nom', $Produits->getnom(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $Produits->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function createProduct(Produits $product): bool
    {
        $sql = "INSERT INTO product (nom, description, prix, stock, idType) VALUES (:nom, :description, :prix, :stock, :idType)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nom', $product->getnom(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $product->getdescription(), PDO::PARAM_STR);
        $stmt->bindValue(':prix', $product->getprix(), PDO::PARAM_STR);
        $stmt->bindValue(':stock', $product->getstock(), PDO::PARAM_INT);
        $stmt->bindValue(':idType', $product->gettype()->getid(), PDO::PARAM_INT);
        return $stmt->execute();
    }
}
