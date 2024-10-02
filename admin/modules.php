<?php

namespace Application;

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');

date_default_timezone_set('America/Sao_Paulo');

use Application\Core;
use Application\Model\Modules\Factory\ModuleModelFactory;

class Modules extends Controller
{
    public $_moduleModelFactory;

    public function __construct(ModuleModelFactory $moduleModelFactory) 
    {
        $this->_moduleModelFactory = $moduleModelFactory;
        parent::__construct();
    }

    public function init() 
    {
        parent::init();

        $this->params['TITLE'] = 'Gerenciamento de módulo para Magento';
        $this->loadAlerts();
        $this->render();

        Core::resetAlertMessage();
    }

    public function indexAction()
    {
        Core::resetAlertMessage();
        Core::redirect('templates/modules/index.html.twig', $this->params);
    }

    public function createAction()
    {

    }

    public function createSaveAction()
    {

    }

    public function updateAction()
    {

    }

    public function updateSaveAction()
    {

    }

    public function deleteAction()
    {

    }

    public function architectureAction() 
    {
        $version = $_GET['version'];
        if (empty($version)) {
            Core::redirect('templates/modules/index.html.twig');
            return;
        }

        if ($version === '1') {
            $this->params['TITLE'] = 'Listagem de módulo para Magento 1';
            $this->params['MODULES'] = $this->_moduleModelFactory->create()->loadMagentoOneModules();
            Core::redirect('templates/modules/list.html.twig', $this->params);
            return;
        }

        if ($version === '2') {
            $this->params['TITLE'] = 'Listagem de módulo para Magento 2';
            $this->params['MODULES'] = $this->_moduleModelFactory->create()->loadMagentoTwoModules();
            Core::redirect('templates/modules/list.html.twig', $this->params);
            return;
        }
    }
}

$modules = new Modules(new ModuleModelFactory());
$modules->init();
