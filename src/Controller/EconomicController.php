<?php
declare (strict_types = 1);
namespace MyApp\Controller;

use MyApp\Model\EconomicModel;
use MyApp\Entity\Economic;
use MyApp\Entity\Currency;
use MyApp\Model\CurrencyModel;
use MyApp\Service\DependencyContainer;
use Twig\Environment;

class EconomicController
{
    private $twig;
    private EconomicModel $economicModel;
    private CurrencyModel $currencyModel;
    public function __construct(Environment $twig, DependencyContainer
         $dependencyContainer) {
        $this->twig = $twig;
        $this->economicModel = $dependencyContainer->get('EconomicModel');
        $this->currencyModel = $dependencyContainer->get('CurrencyModel');
    }
    public function listEconomic()
    {
        $economic = $this->economicModel->getAlleconomics();
        echo $this->twig->render('EconomicController/listEconomic.html.twig', ['economic' => $economic]);
    }
    public function addEconomic()
    {
        $currency = $this->currencyModel->getAllCurrency();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $id = filter_input(INPUT_POST, 'id',FILTER_SANITIZE_NUMBER_INT);
            if (!empty($name)) {
                $currency = $this->CurrencyModel->getOneCurrency;
                    $_SESSION['message'] = 'Erreur sur le type.';
                } else {
                    $economic = new Economic(null, $nom, $currency);
                    $success = $this->economicModel->createEconomic($economic);
                }
            } else {
                $_SESSION['message'] = 'Veuillez saisir toutes les données.';
            }
        }
}
