<?php

namespace Application;

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');

date_default_timezone_set('America/Sao_Paulo');

use Application\Core;
use Application\Helper\Paginator;
use Application\Model\Reporters\Factory\ReporterModelFactory;
use Application\Model\Reporters\Reporter;
use CoffeeCode\Uploader\Image;

class Reporters extends Controller 
{
    /** @var Reporter $reporterModel */
    public $reporterModel;

    /** @var ReporterModelFactory $_reporterModelFactory */
    protected $_reporterModelFactory;

    public function __construct(ReporterModelFactory $reporterModelFactory) 
    {
        $this->_reporterModelFactory = $reporterModelFactory;
        parent::__construct();
    }

    public function init()
    {
        parent::init();

        $this->params['TITLE'] = 'Gerenciamento de relatores dos tickets';
        $this->loadAlerts();
        $this->render();
        Core::resetAlertMessage();
    }

    public function indexAction()
    {
        $this->params['ITEMS_PER_PAGE'] = $this->getListParam();
        $this->params['REPORTERS'] = $this->loadPaginationReporters();
        $this->params['PAGINATOR']['PAGINATION_NAV_LINK'] = $this->loadPaginateNavLink();
        $this->params['PAGINATOR']['PAGINATION_LINK_START'] = $this->getLinkStart();
        $this->params['PAGINATOR']['PAGINATION_LINK_END'] = $this->getLinkEnd();
        $this->params['PAGINATOR']['PAGINATION_CURRENT_PAGE'] = $this->getCurrentPage();
        $this->params['PAGINATOR']['PAGINATION_TOTAL_LINKS'] = $this->totalNumberLinks();
        
        Core::redirect('templates/reporters/index.html.twig', $this->params);
    }

    public function createAction()
    {
        $this->params['FORM_ACTION'] = 'createSave';
        Core::redirect('templates/reporters/form.html.twig', $this->params);
    }

    public function createSaveAction()
    {
        // Capturando os dados do formulário...
        $reporterId  = $this->getFormData('reporter_id');
        $name        = $this->getFormData('name');
        $picture     = '';

        // Verificando se o ticekt já está cadastrado...
        $reporterExists = (bool) $this->_reporterModelFactory->create()->findByField('name', $name);
        if ($reporterExists === true) {
            $message = sprintf('Este relator \'%s\' já está cadastrado!', $name);
            Core::errorSession($message);
            die(header('Location: '. Core::getUrlBase('admin/reporters.php?action=create')));
        }

        // Upload de imagem
        $file = $_FILES['picture'] ?? null;
        if ($file['error'] == 0) {
            $image = new Image('../views/admin/assets/images', 'reporters');
            $filename = strtolower($name) . date('YmdHis');
            $picture = $image->upload($file, $filename);
        }

        $reporter = $this->_reporterModelFactory->create();
        $reporter->reporter_id = $reporterId;
        $reporter->name        = $name;
        $reporter->picture     = $picture;

        try {
            $isReporter = $reporter->save();
            if (empty($isReporter)) {
                throw new \Exception($reporter->fail()->getMessage());                    
            }

            $message = sprintf("O relator '#%s' foi cadastrado com sucesso!", $name);
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/reporters.php')));

        } catch (\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/reporters.php?action=createSave')));
        }        
    }

    public function updateAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/reporters.php')));
        }

        $id = $_GET['id'] ?? null;
        $reporter = $this->_reporterModelFactory->create()->findById($id);

        $this->params['FORM_ACTION'] = 'updateSave&id='. $id;
        $this->params['DATA'] = $reporter->data();

        Core::redirect('templates/reporters/form.html.twig', $this->params);
    }

    public function updateSaveAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/reporters.php')));
        }
        
        $id = $_GET['id'] ?? null;
        $reporter = $this->_reporterModelFactory->create()->findById($id);
        if (empty($reporter)) {
            Core::errorSession('O relator que você está procurndo não está cadastrado!');
            die(header('Location: ' . Core::getUrlBase('admin/reporters.php?action=update&id='.$id)));
        }

        try {
            $reporter->name = $this->getFormData('name');

            // Removendo o arquivo de foto antiga.
            $removePhoto = $this->getFormData('picture_remove'); 
            if ($removePhoto == 'on' && !empty($reporter->picture) && file_exists($reporter->picture)) {
                $pos = strpos($reporter->picture, 'reporters');
                $filenameRemoved = substr($reporter->picture, $pos+18);
                $message = sprintf('O arquivo \'%s\' foi removido com sucesso', $filenameRemoved);

                Core::warningSession($message);
                unlink($reporter->picture);

                $reporter->picture = '';
            }

            // Upload de imagem
            $file = $_FILES['picture'] ?? null;
            if ($file['error'] == 0) {
                $image = new Image('../views/admin/assets/images', 'reporters');
                $filename = strtolower($this->getFormData('name')) . date('YmdHis');
                $picture = $image->upload($file, $filename);
                $reporter->picture = $picture;
            }

            $isSave = $reporter->save();
            if (empty($isSave)) {
                throw new \Exception('Não foi possível salvar os dados do relator.');                        
            }

            $message = sprintf('O relator \'%s\' foi alterada com sucesso!', $this->getFormData('name'));
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/reporters.php')));

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/reporters.php?action=update&id='. $id)));
        }
    }

    public function deleteAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/stores.php')));
        }
        
        $id = $_GET['id'] ?? null;
        $reporter = $this->_reporterModelFactory->create()->findById($id);
        if (empty($reporter)) {
            Core::errorSession('O relator que você está procurndo não está cadastrado!');
            die(header('Location: ' . Core::getUrlBase('admin/reporters.php?action=update&id='.$id)));
        }

        try {
            // Removendo o arquivo de foto...
            if (!empty($reporter->picture) && file_exists($reporter->picture)) {
                $pos = strpos($reporter->picture, 'reporters');
                $filenameRemoved = substr($reporter->picture, $pos+18);
                $message = sprintf('O arquivo \'%s\' foi removido com sucesso', $filenameRemoved);

                Core::warningSession($message);
                unlink($reporter->picture);

                $reporter->picture = '';
            }

            $isDeleted = $reporter->destroy();
            if (empty($isDeleted)) {
                throw new \Exception('Não foi possível remover o relator.');                        
            }

            $message = sprintf('O relator \'%s\' foi removido com sucesso!', $this->getFormData('name'));
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/reporters.php')));

        } catch(\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/reporters.php?action=update&id='. $id)));
        }
    }

    public function loadPaginationReporters(): array
    {
        $loadSearch = $this->loadReporters();
        $paginator = new Paginator($loadSearch, 'reporters', $this->getCurrentPage(), $this->getListParam());
        return $paginator->paginate(); 
    }

    public function loadReporters(): ?array
    {
        if (!empty($this->searchParams)) {
            return $this->loadReportersSearch($this->searchParams);
        }
        
        if (empty($this->searchParams)) {
            return $this->loadAllReporters();
        }

        return null;
    }

    public function loadReportersSearch(string $search) 
    {
        $reporter = $this->_reporterModelFactory->create();
        $result = $reporter->find()->like("name", $search)->order('name')->fetch(true);
        return $result;
    }

    public function loadAllReporters() 
    {
        $reporter = $this->_reporterModelFactory->create();
        return $reporter->find()->order('name')->fetch(true);
    }

    public function loadPaginateNavLink(): array
    {
        $paginator = new Paginator(
            $this->loadReporters(), 'reporters', $this->getCurrentPage(), $this->getListParam()
        );
        return $paginator->render();
    }

    public function getLinkStart() 
    {
        $paginator = new Paginator($this->loadReporters(), 'reporters', $this->getCurrentPage(), $this->getListParam());
        return $paginator->getLinkStart();
    }

    public function getLinkEnd() 
    {
        $paginator = new Paginator($this->loadReporters(), 'reporters', $this->getCurrentPage(), $this->getListParam());
        return $paginator->getLinkEnd();
    }

    public function totalNumberLinks() 
    {
        $paginator = new Paginator($this->loadReporters(), 'reporters', $this->getCurrentPage(), $this->getListParam());
        return $paginator->totalNumberLinks();
    }
}

$reporters = new Reporters(new ReporterModelFactory());
$reporters->init();
