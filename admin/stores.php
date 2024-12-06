<?php

namespace Application;

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');

use Application\Controller;
use Application\Core;
use Application\Helper\Paginator;
use Application\Model\Stores\Factory\StoreModelFactory;
use Application\Model\Stores\Store;
use CoffeeCode\DataLayer\Connect;
use CoffeeCode\Uploader\Image;
use PDO;

date_default_timezone_set('America/Sao_Paulo');

class stores extends Controller
{
    /** @var Store $storeModel */
    public $storeModel;

    /** @var array $params */
    public $params;

    /** @var StoreModelFactory $_storeModelFactory */
    protected $_storeModelFactory;

    public function __construct(StoreModelFactory $storeModelFactory) 
    {
        $this->_storeModelFactory = $storeModelFactory;
        parent::__construct();
    }

    public function init()
    {
        parent::init();
        
        $this->params['TITLE'] = 'Gerenciamento de lojas';
        $this->loadAlerts();
        $this->render();
        Core::resetAlertMessage();
    }

    public function indexAction()
    {
        $this->params['ITEMS_PER_PAGE'] = $this->getListParam();
        $this->params['STORES'] = $this->loadStores();
        $this->params['PAGINATOR']['PAGINATION_NAV_LINK'] = $this->loadPaginateNavLink();
        $this->params['PAGINATOR']['PAGINATION_LINK_START'] = $this->getLinkStart();
        $this->params['PAGINATOR']['PAGINATION_LINK_END'] = $this->getLinkEnd();
        $this->params['PAGINATOR']['PAGINATION_CURRENT_PAGE'] = $this->getCurrentPage();
        $this->params['PAGINATOR']['PAGINATION_TOTAL_LINKS'] = $this->totalNumberLinks();

        Core::resetAlertMessage();
        Core::redirect('templates/stores/index.html.twig', $this->params);
    }

    public function createAction()
    {
        $this->params['FORM_ACTION'] = 'createSave';
        Core::redirect('templates/stores/form.html.twig', $this->params);
    }

    public function createSaveAction()
    {
        // Capturando os dados do formulário...
        $name           = $this->getFormData('name');
        $responsible    = $this->getFormData('responsible');
        $email          = strtolower($this->getFormData('email'));
        $phone          = preg_replace('/\D/', '', $this->getFormData('phone'));
        $brandLogo      = $this->getFormData('brand_logo'); 
        $platform       = $this->getFormData('platform_version'); 
        $url_local      = $this->getFormData('url_local');
        $url_sandbox    = $this->getFormData('url_sandbox');
        $url_production = $this->getFormData('url_production');

        // Verifica se o registro existe na base  de dados...
        $storeExists = (bool) $this->_storeModelFactory->create()->findByField('email', $email);
        if ($storeExists === true) {
            $message = sprintf('A loja %s já está cadastrado!', $name);
            Core::errorSession($message);
            die(header('Location: ' . Core::getUrlBase('admin/stores.php?action=create')));
        }

        try {
            $store = $this->_storeModelFactory->create();
            $store->name             = $name;
            $store->responsible      = $responsible;
            $store->email            = $email;
            $store->phone            = $phone;
            $store->platform_version = $platform;
            $store->url_local        = $url_local;
            $store->url_sandbox      = $url_sandbox;
            $store->url_production   = $url_production;

            // Upload de imagem
            $file = $_FILES['brand_logo'] ?? null;
            if ($file['error'] == 0) {
                $image = new Image('../views/admin/assets/images', 'brandlogo');
                $filename = strtolower($name) . date('YmdHis');
                $brandLogo = $image->upload($file, $filename);
            }
            $store->brand_logo = $brandLogo;

            // Salvando os dados no banco de dados...
            if (empty($store->save())) {
                throw new \Exception('Não foi possível ');                        
            }

            $message = sprintf('A loja %s foi cadastrada com sucesso!', $name);
            Core::successSession($message);
            die(header('Location: '.Core::getUrlBase('admin/stores.php')));

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '.Core::getUrlBase('admin/stores.php?action=createSave')));
        }

    }

    public function updateAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/stores.php')));
        }

        $id = $_GET['id'] ?? null;
        $store = $this->_storeModelFactory->create()->findById($id);

        $this->params['FORM_ACTION'] = 'updateSave&id='. $id;
        $this->params['DATA'] = $store->data();

        Core::redirect('templates/stores/form.html.twig', $this->params);
    }

    public function updateSaveAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/stores.php')));
        }
        
        $id = $_GET['id'] ?? null;
        $store = $this->_storeModelFactory->create()->findById($id);
        if (empty($store)) {
            Core::errorSession('A loja que você está tentando acessar não está cadastrada!');
            die(header('Location: ' . Core::getUrlBase('admin/stores.php?action=update&id='.$id)));
        }

        try {
            $store->name             = $this->getFormData('name');
            $store->responsible      = $this->getFormData('responsible');
            $store->email            = strtolower($this->getFormData('email'));
            $store->phone            = $this->getFormData('phone');
            $store->platform_version = $this->getFormData('platform_version');
            $store->url_local        = $this->getFormData('url_local');
            $store->url_sandbox      = $this->getFormData('url_sandbox');
            $store->url_production   = $this->getFormData('url_production');

            // Removendo o arquivo da logomarca antigo.
            $removeLogo = $this->getFormData('logomarca_remove'); 
            if ($removeLogo == 'on' && !empty($store->brand_logo) && file_exists($store->brand_logo)) {
                $pos = strpos($store->brand_logo, 'brandlogo');
                $filenameRemoved = substr($store->brand_logo, $pos+18);
                $message = sprintf('O arquivo \'%s\' foi removido com sucesso', $filenameRemoved);

                Core::warningSession($message);
                unlink($store->brand_logo);

                $store->brand_logo = '';
            }

            // Upload de imagem
            $file = $_FILES['brand_logo'] ?? null;
            if ($file['error'] == 0) {
                $image = new Image('../views/admin/assets/images', 'brandlogo');
                $filename = strtolower($this->getFormData('name')) . date('YmdHis');
                $brandLogo = $image->upload($file, $filename);
                $store->brand_logo = $brandLogo;
            }

            $isSave = $store->save();
            if (empty($isSave)) {
                throw new \Exception('Não foi possível salvar os dados da loja.');                        
            }

            $message = sprintf('A loja \'%s\' foi alterada com sucesso!', $this->getFormData('name'));
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/stores.php')));

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/stores.php?action=update&id='. $id)));
        }
    }

    public function deleteAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/stores.php')));
        }
        
        $id = $_GET['id'] ?? null;
        $store = $this->_storeModelFactory->create()->findById($id);
        if (empty($store)) {
            Core::errorSession('A loja que você está tentando acessar não está cadastrada!');
            die(header('Location: ' . Core::getUrlBase('admin/stores.php?action=update&id='.$id)));
        }

        try {
            $storeName = $store->name;
            $isDeleted = $store->destroy();
            if (empty($isDeleted)) {
                throw new \Exception('Não foi possível remover a loja.');                        
            }

            $message = sprintf('A loja \'%s\' foi removida com sucesso!', $storeName);
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/stores.php')));

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/stores.php?action=update&id='. $id)));
        }
    }

    /**
     * Method responsible to uninstall the store
     */
    public function uninstallStoreAction()
    {
        try {
            $this->params['TITLE'] = 'Desinstalação de loja';
            $this->params['FORM_ACTION'] = 'uninstallStoreSave';
            Core::redirect('templates/stores/uninstallStore.html.twig', $this->params);

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/stores.php')));
        }
    }

    public function uninstallStoreSaveAction()
    {
        try {
            // print_r($_POST);
            // $this->_storeModelFactory->create()->uninstallStore();
            // Core::successSession('Loja desinstalada com sucesso!');
            // die(header('Location: '. Core::getUrlBase('admin/stores.php')));

            /**
             * TODO 
             * 
             * Remover a pasta da loja
             * Remover o arquivo de mapeamento do VSCode da loja
             * Deletar o banco de dados da loja
             */
            

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/stores.php')));
        }
    }

    public function loadStoresSearch(string $search)
    {
        $store = $this->_storeModelFactory->create();
        $result = $store->find()
            ->like("name", $search)
            ->like("responsible", $search)
            ->like("email", $search)
            ->order("name ASC")
            ->fetch(true);

        return empty($result) ? [] : $result;
    }

    public function loadAllStores(): array
    {
        $store = $this->_storeModelFactory->create();
        return $store->find()->order('name ASC')->fetch(true);
    }
    
    public function loadStores(): array
    {
        $loadSearch = '';
        if (!empty($this->searchParams)) {
            $loadSearch = $this->loadStoresSearch($this->searchParams);
        }
        
        if (empty($this->searchParams)) {
            $loadSearch = $this->loadAllStores();
        }

        $paginator = new Paginator($loadSearch, 'stores', $this->getCurrentPage(), $this->getListParam());
        return $paginator->paginate(); 
    }

    public function loadAlerts()
    {
        $this->loadSuccessAlert();
        $this->loadErrorAlert();
        $this->loadWarningAlert();
    }

    public function loadPaginateNavLink(): array
    {
        $paginator = new Paginator($this->loadAllStores(), 'stores', $this->getCurrentPage(), $this->getListParam());
        return $paginator->render();
    }

    public function getLinkStart() 
    {
        $paginator = new Paginator($this->loadStores(), 'stores', $this->getCurrentPage(), $this->getListParam());
        return $paginator->getLinkStart();
    }

    public function getLinkEnd() 
    {
        $paginator = new Paginator($this->loadStores(), 'stores', $this->getCurrentPage(), $this->getListParam());
        return $paginator->getLinkEnd();
    }

    public function totalNumberLinks() 
    {
        $paginator = new Paginator($this->loadStores(), 'stores', $this->getCurrentPage(), $this->getListParam());
        return $paginator->totalNumberLinks();
    }
}

$stores = new Stores(new StoreModelFactory);
$stores->init();
