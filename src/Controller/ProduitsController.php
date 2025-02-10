<?php
declare (strict_types = 1);
namespace MyApp\Controller;

use MyApp\Entity\Produits;
use MyApp\Entity\Type;
use MyApp\Model\ProduitsModel;
use MyApp\Model\TypeModel;
use MyApp\Service\DependencyContainer;
use Twig\Environment;

class ProduitsController
{
    private $twig;
    private ProduitsModel $produitsModel;
    private TypeModel $typeModel;
    public function __construct(Environment $twig, DependencyContainer
         $dependencyContainer) {
        $this->twig = $twig;
        $this->produitsModel = $dependencyContainer->get('ProduitsModel');
        $this->typeModel = $dependencyContainer->get('TypeModel');
    }
    public function listProduct()
    {
        $products = $this->produitsModel->getAllProduits();
        echo $this->twig->render('productController/listproduct.html.twig', ['products' =>$products]);
    }
    public function addProduits()
    {
        $types = $this->typeModel->getAllTypes();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description',
                FILTER_SANITIZE_STRING);
            $prix = filter_input(INPUT_POST, 'prix',
                FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
            $idType = filter_input(INPUT_POST, 'idType',
                FILTER_SANITIZE_NUMBER_INT);
            if (!empty($nom) && !empty($description) && !empty($prix) && !empty($stock)
                && !empty($idType)) {
                $type = $this->typeModel->getOneType(intVal($idType));
                if ($type == null) {
                    $_SESSION['message'] = 'Erreur sur le type.';
                } else {
                    $produits = new Produits(null, $nom, floatVal($prix), $description,
                        intVal($stock), $type);
                    $success = $this->produitsModel->createProduct($produits);
                }
            } else {
                $_SESSION['message'] = 'Veuillez saisir toutes les données.';
            }
        }
        echo $this->twig->render('productController/addProduits.html.twig', ['types' =>$types]);
    }
    public function updateProduits()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $prix = filter_input(INPUT_POST, 'prix', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            if (!empty($_POST['prix'])&($_POST['prix'])) {
                $Produits = new Produits(intVal($id), $nom, floatVal($prix));
                $success = $this->produitsModel->updateProduits($Produits);
                if ($success) {
                    header('Location: index.php?page=produits');
                }
            }
        } else {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        }
        $Produits = $this->produitsModel->getOneProduits(intVal($id));
        echo $this->twig->render('defaultController/updateProduits.html.twig', ['Produits' => $produits], ['types' =>$types]);
    }
}
