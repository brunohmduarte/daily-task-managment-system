<?php

namespace Application;

require_once(dirname(__DIR__).'/vendor/autoload.php');

use Application\Core;

abstract class Controller
{
    /** @var array $dataForm */
    public $dataForm = [];

    /** @var string $searchParams */
    public $searchParams;

    /** @var array $params */
    public $params;

    /** @var int $listParam */
    public $listParam = 10;

    public $continuePage = false;

    public function init() 
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->dataForm = $_POST['data'];
            
            if (isset($_GET['continuepage']) && $_GET['continuepage'] == 1) {
                $this->continuePage = true;
            }
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_GET['s'])) {
                $this->searchParams = strip_tags($_GET['s']);
            }
            if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['fs'])) {
                $this->searchParams = strip_tags($_GET['fs']);
            }
            if (isset($_GET['list'])) {
                $this->listParam = intval(strip_tags($_GET['list']));
            }
        }
    }

    abstract public function indexAction();

    abstract public function createAction();

    abstract public function createSaveAction();

    abstract public function updateAction();

    abstract public function updateSaveAction();

    abstract public function deleteAction();

    public function __construct() 
    {
        Core::existsSession('user');
        Core::initTwig('admin');
    }

    public function render() 
    {
        if (isset($_GET['action'])) {
            $methodname = $_GET['action'].'Action';
            $this->{$methodname}();
            return;
        }

        $this->indexAction();
        return;
    }

    protected function _checkExistsParam(string $paramName) 
    {
        if (empty($paramName)) {
            return false;
        }

        if (!isset($_GET[$paramName])) {
            return false;
        }

        return true;
    }

    public function getFormData(string $field = '') 
    {
        if (empty($field)) {
            return $this->dataForm;
        }

        if (!array_key_exists($field, $this->dataForm)) {
            return null;
        }

        return $this->dataForm[$field];
    }

    public function getListParam()
    {
        return $this->listParam;
    }

    public function getCurrentPage() 
    {
        $page = 1;
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        }

        return intval($page);
    }

    public function loadAlerts()
    {
        $this->loadSuccessAlert();
        $this->loadErrorAlert();
        $this->loadWarningAlert();
    }

    public function loadSuccessAlert()
    {
        if (isset($_SESSION['admin_success'])) {
            $this->params['SUCCESS_ALERT'] = Core::getAlertMessage('admin_success');
        }
    }

    public function loadErrorAlert()
    {
        if (isset($_SESSION['admin_error'])) {
            $this->params['ERROR_ALERT'] = Core::getAlertMessage('admin_error');
        }
    }

    public function loadWarningAlert()
    {
        if (isset($_SESSION['admin_warning'])) {
            $this->params['WARNING_ALERT'] = Core::getAlertMessage('admin_warning');
        }
    }

}
