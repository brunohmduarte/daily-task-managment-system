<?php

namespace Application;

session_start();

require_once(dirname(__DIR__).'/vendor/autoload.php');

use Application\Controller;
use Application\Core;
use Application\Helper\Paginator;
use Application\Helper\PrepareData as PrepareDataHelper;
use Application\Helper\HelperFactory;
use Application\Model\Reporters\Reporter;
use Application\Model\Stores\Store;
use Application\Model\Tickets\Ticket;
use Application\Model\Tickets\Factory\TicketModelFactory;
use Application\Model\WorkingTime\WorkingTime;
use Application\Model\WorkingTime\Factory\WorkingTimeModelFactory;
use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;
use PDO;

date_default_timezone_set('America/Sao_Paulo');

class Tickets extends Controller
{
    /** @var Ticket $ticketModel */
    public $ticketModel;

    /** @var WorkingTime $workingTimeModel */
    public $workingTimeModel;

    /** @var TicketModelFactory $_ticketModelFactory */
    protected $_ticketModelFactory;

    /** @var WorkingTimeModelFactory $_workingTimeModelFactory */
    protected $_workingTimeModelFactory;

    /** @var HelperFactory $_helperFactory */
    protected $_helperFactory;

    public function __construct(
        TicketModelFactory $ticketModelFactory,
        WorkingTimeModelFactory $workingTimeModelFactory,
        HelperFactory $helperFactory
    ) {
        $this->_ticketModelFactory = $ticketModelFactory;
        $this->_workingTimeModelFactory = $workingTimeModelFactory;
        $this->_helperFactory = $helperFactory;

        parent::__construct();
    }

    public function init()
    {
        parent::init();
        
        $this->params['TITLE'] = 'Gerenciamento de tickets';
        $this->loadAlerts();
        $this->render();
        Core::resetAlertMessage();
    }

    /** @override */
    public function getFormData(string $field = '', string $table = 'tickets') 
    {
        if (empty($field)) {
            return $this->dataForm[$table];
        }

        if (!array_key_exists($field, $this->dataForm[$table])) {
            return null;
        }

        return $this->dataForm[$table][$field];
    }

    public function indexAction()
    {
        $this->params['ITEMS_PER_PAGE'] = $this->getListParam();
        $this->params['TICKETS'] = $this->loadTickets();
        $this->params['PAGINATOR']['PAGINATION_NAV_LINK'] = $this->loadPaginateNavLink();
        $this->params['PAGINATOR']['PAGINATION_LINK_START'] = $this->getLinkStart();
        $this->params['PAGINATOR']['PAGINATION_LINK_END'] = $this->getLinkEnd();
        $this->params['PAGINATOR']['PAGINATION_CURRENT_PAGE'] = $this->getCurrentPage();
        $this->params['PAGINATOR']['PAGINATION_TOTAL_LINKS'] = $this->totalNumberLinks();

        Core::redirect('templates/tickets/index.html.twig', $this->params);
    }

    public function createAction()
    {
        $this->params['REPORTER_SELECT_OPT'] = $this->loadSelectOpt(new Reporter(), 'reporter_id');
        $this->params['STORE_SELECT_OPT'] = $this->loadSelectOpt(new Store(), 'store_id');
        $this->params['FORM_ACTION'] = 'createSave';
        $this->params['LINK'] = '';
        Core::redirect('templates/tickets/form.html.twig', $this->params);
    }

    public function createSaveAction()
    {
        $reference = $this->getFormData('reference');

        // Verificando se o ticekt já está cadastrado...
        $ticketExists = $this->_ticketModelFactory->create()->findByField('reference', $reference);
        if (!empty($ticketExists)) {
            $message = sprintf("O ticket de referência '#%s' já está cadastrado!", $reference);
            Core::errorSession($message);
            die(header('Location: '. Core::getUrlBase('admin/tickets.php?action=create')));
        }

        // Declarando os dados vindo do formulário...
        $ticket = $this->_ticketModelFactory->create();
        $ticket->reporter_id = $this->getFormData('reporter_id');
        $ticket->store_id    = $this->getFormData('store_id');
        $ticket->reference   = $reference;
        $ticket->status      = $this->getFormData('status');
        $ticket->title       = $this->getFormData('title');
        $ticket->description = $this->getFormData('description');
        $ticket->resolution  = $this->getFormData('resolution');
        $ticket->priority    = $this->getFormData('priority');
        
        try {
            // Salvando os dados do ticket...
            $isTicketSave = $ticket->save();
            if (empty($isTicketSave)) {
                throw new \Exception($ticket->fail()->getMessage());                    
            }

            // Salvando as horas de apontamento...
            if ($this->canSaveAppointments()) {
                $ticketId = $ticket->data()->ticket_id;
                $this->saveWokingTime($ticketId);
            }

            $message = sprintf("O ticket #%s foi cadastrado com sucesso!", $reference);
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/tickets.php')));

        } catch (\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/tickets.php?action=create')));
        }        
    }

    public function updateAction()
    {
        if (!$this->_checkExistsParam('id')) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/tickets.php')));
        }

        $id = $_GET['id'] ?? null;
        $ticket = (new Ticket())->findById($id);

        /**
         * puxar os dados da loja para poder pegar os links e enviar para o template
         */

        $this->params['REPORTER_SELECT_OPT'] = $this->loadSelectOpt(new Reporter(), 'reporter_id');
        $this->params['STORE_SELECT_OPT'] = $this->loadSelectOpt(new Store(), 'store_id');
        $this->params['FORM_ACTION'] = 'updateSave&id='. $id;
        $this->params['LINK'] = Core::getUrlBase("admin/tickets.php?action=delete&id={$id}");
        $this->params['DATA'] = $ticket->data();
        
        /** @var Store $storeModel */
        $storeModel = $this->_helperFactory->prepare(Store::class)->create();
        $this->params['DATA']->store = $storeModel->findById($ticket->store_id)->data();

        $appoiments = $this->_workingTimeModelFactory
            ->create()
            ->find("ticket_id = :id", "id={$id}")
            ->order('created_at ASC')
            ->fetch(true);

        if (!empty($appoiments)) {
            $this->params['DATA']->appoiments = $appoiments;
        }

        Core::redirect('templates/tickets/form.html.twig', $this->params);
    }

    public function updateSaveAction()
    { 
        // Capturando os dados do formulário...
        $ticketId  = $this->getFormData('ticket_id');
        $reference = $this->getFormData('reference');

        // Verificando se o ticekt já está cadastrado...
        $ticket = $this->_ticketModelFactory->create()->findById($ticketId);
        if (empty($ticket)) {
            Core::errorSession('Registro não encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/tickets.php?action=update&id='.$ticketId)));
        }

        // Declarando os dados atualiados para o registro de banco de dados... 
        $ticket->reporter_id = $this->getFormData('reporter_id');
        $ticket->store_id    = $this->getFormData('store_id');
        $ticket->reference   = $reference;
        $ticket->status      = $this->getFormData('status');
        $ticket->title       = $this->getFormData('title');
        $ticket->description = $this->getFormData('description');
        $ticket->resolution  = $this->getFormData('resolution');
        $ticket->priority    = $this->getFormData('priority');
        
        try {
            $isSave = $ticket->save();
            if (empty($isSave)) {
                throw new \Exception($ticket->fail()->getMessage());                    
            }

            if (!empty($this->getFormData('', 'working_time'))) {
                $ticketId = $ticket->data()->ticket_id;
                $this->updateWokingTime($ticketId);
            }

            $message = sprintf("O ticket #%s foi alterado com sucesso!", $reference);
            Core::successSession($message);

            $continuePage = ($this->continuePage) ? '?action=update&id='. $ticketId : '';            
            die(header('Location: '. Core::getUrlBase('admin/tickets.php'.$continuePage)));

        } catch (\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/tickets.php?action=createSave')));
        } 
    }

    public function deleteAction() 
    {
        if ( !$this->_checkExistsParam('id') ) {
            Core::errorSession('Não foi possível carregar o registro, o parâmetro de identificação não foi encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/tickets.php')));
        }

        $id = $_GET['id'] ?? null;

        /** @var Ticket $ticket */
        $ticket = $this->_ticketModelFactory->create()->findById($id);
        if (empty($ticket)) {
            Core::errorSession('Registro não encontrado!');
            die(header('Location: '. Core::getUrlBase('admin/tickets.php?action=update&id='.$id)));
        }

        try {
            if (empty($ticket->destroy())) {
                throw new \Exception($ticket->fail()->getMessage());                    
            }

            $message = sprintf("O ticket '#%s' foi excluído com sucesso!", $ticket->reference);
            Core::successSession($message);

            die(header('Location: '. Core::getUrlBase('admin/tickets.php')));

        } catch (\Exception $e) {
            Core::errorSession($e->getMessage());
            die(header('Location: '. Core::getUrlBase('admin/tickets.php?action=createSave')));
        } 
    }

    public function summarydailyAction()
    {
        if (isset($_GET['date'])) {
            $dateParam = strip_tags($_GET['date']);
            $response = $this->loadSummaryDailyByDate($dateParam);
            print json_encode($response);
            return;
        }

        $response = $this->loadSummaryDaily(Connect::getInstance(DATA_LAYER_CONFIG));
        print json_encode($response);
        return;
    }

    public function loadAllTickets(): array
    {
        $ticketModel = $this->_ticketModelFactory->create();
        $tickets = $ticketModel->find(
            null, null, 'tickets.*, r.name AS reporter, r.picture AS reporter_thumb, s.name AS store'
        )->innerJoin(
            ['r' => 'reporters'], 'tickets.reporter_id = r.reporter_id'
        )->innerJoin(
            ['s' => 'stores'], 'tickets.store_id = s.store_id'
        )->order(
            'tickets.status ASC, tickets.ticket_id DESC, tickets.reference ASC'
        )->fetch(true);
            
        return !empty($tickets) ? $tickets : [];
    }

    public function loadTickets(): array
    {
        $loadSearch = '';
        if (!empty($this->searchParams)) {
            $loadSearch = $this->loadTicktesSearch($this->searchParams);
        }
        
        if (empty($this->searchParams)) {
            $loadSearch = $this->loadAllTickets();
        }
        
        $paginator = new Paginator($loadSearch, 'tickets', $this->getCurrentPage(), $this->getListParam());
        return $paginator->paginate();

    }

    public function loadSummaryDaily(PDO $connect): array
    {
        $query = "
            SELECT s.name AS store, t.reference, t.title, t.resolution, t.`status`, 
                (
                    SELECT TIME_FORMAT(
                        SEC_TO_TIME(
                            SUM(
                                TIME_TO_SEC(
                                    TIMEDIFF(wt.development_end, wt.development_begin)
                                )
                            )
                        ), 
                        '%H:%i'
                    )
                ) AS development_hours,
                DATE_FORMAT(wt.done_at, '%d/%m/%Y') AS done_at
            FROM tickets AS t
                INNER JOIN working_time AS wt ON (t.ticket_id = wt.ticket_id)
                INNER JOIN stores AS s ON(t.store_id = s.store_id)            
            WHERE t.updated_at >= (
                    SELECT 
                        CASE  
                            WHEN DAYOFWEEK(CURDATE()) = 1 THEN
                                SUBDATE(CURDATE(), INTERVAL 2 DAY)
                            WHEN DAYOFWEEK(CURDATE()) = 2 THEN
                                SUBDATE(CURDATE(), INTERVAL 3 DAY)
                            ELSE SUBDATE(CURDATE(), INTERVAL 1 DAY)		
                        END
                )                
            GROUP BY t.ticket_id, wt.done_at
            ORDER BY t.status DESC, t.ticket_id ASC
        ";
        $tickets = $connect->query($query);

        return $tickets->fetchAll(PDO::FETCH_OBJ);
    }

    public function loadSummaryDailyByDate(string $dateParam)
    {
        if (empty($dateParam)) {
            return [];
        }

        $query = "
            SELECT s.name AS store, t.reference, t.title, t.resolution, t.`status`, 
                (
                    SELECT TIME_FORMAT(
                        SEC_TO_TIME(
                            SUM(
                                TIME_TO_SEC(
                                    TIMEDIFF(wt.development_end, wt.development_begin)
                                )
                            )
                        ), 
                        '%H:%i'
                    )
                ) AS development_hours                
            FROM tickets AS t
                INNER JOIN working_time AS wt ON (t.ticket_id = wt.ticket_id)
                INNER JOIN stores AS s ON(t.store_id = s.store_id)            
            WHERE t.updated_at >= (
                    SELECT 
                        CASE  
                            WHEN DAYOFWEEK('{$dateParam}') = 1 THEN
                                SUBDATE('{$dateParam}', INTERVAL 2 DAY)
                            WHEN DAYOFWEEK('{$dateParam}') = 2 THEN
                                SUBDATE('{$dateParam}', INTERVAL 3 DAY)
                            ELSE SUBDATE('{$dateParam}', INTERVAL 1 DAY)		
                        END
                )                
            GROUP BY t.ticket_id            
            ORDER BY t.status DESC, t.ticket_id ASC
        ";

        $connect = Connect::getInstance(DATA_LAYER_CONFIG);
        $tickets = $connect->query($query);

        return $tickets->fetchAll(PDO::FETCH_OBJ);

        // $conditions = [">=" => "(
        //     SELECT 
        //         CASE  
        //             WHEN DAYOFWEEK('{$dateParam}') = 1 THEN
        //                 SUBDATE('{$dateParam}', INTERVAL 2 DAY)
        //             WHEN DAYOFWEEK('{$dateParam}') = 2 THEN
        //                 SUBDATE('{$dateParam}', INTERVAL 3 DAY)
        //             ELSE SUBDATE('{$dateParam}', INTERVAL 1 DAY)		
        //         END
        // )"];

        // $ticket = $this->_ticketModelFactory->create();
        // $tickets = $ticket->find(
        //     "", 
        //     null, 
        //     "s.name AS store, tickets.reference, tickets.title, tickets.resolution, tickets.`status`, 
        //     (
        //         SELECT TIME_FORMAT(
        //             SEC_TO_TIME(
        //                 SUM(
        //                     TIME_TO_SEC(
        //                         TIMEDIFF(wt.development_end, wt.development_begin)
        //                     )
        //                 )
        //             ), 
        //             '%H:%i'
        //         )
        //     ) AS development_hours"
        // )
        // ->innerJoin(['wt' => 'working_time'], 'tickets.ticket_id = wt.ticket_id')
        // ->innerJoin(['s' => 'stores'], 'tickets.store_id = s.store_id')
        // ->where('tickets.updated_at', $conditions)
        // ->group('tickets.ticket_id')
        // ->order('tickets.status DESC, tickets.ticket_id ASC')
        // ->fetch(true);

        // return $tickets;
    }

    public function loadTicktesSearch(string $search)
    {
        $ticket = $this->_ticketModelFactory->create();
        $tickets = $ticket->find(
            null, null, 'tickets.*, r.name AS reporter, r.picture AS reporter_thumb, s.name AS store'
        )
        ->innerJoin(["r" => "reporters"], 'tickets.reporter_id = r.reporter_id')
        ->innerJoin(['s' => 'stores'], 'tickets.store_id = s.store_id')
        ->like('tickets.title', $search)
        ->like('tickets.reference', $search)
        ->like('tickets.resolution', $search)
        ->like('r.name', $search)
        ->like('s.name', $search)
        ->order('tickets.status ASC, tickets.ticket_id DESC, tickets.reference ASC')
        ->fetch(true);
        
        return !empty($tickets) ? $tickets : [];
    }

    public function loadSelectOpt(DataLayer $model, string $value = 'id', string $label = 'name')
    {
        $collection = $model->find()->order('name ASC')->fetch(true);
        $dataHelper = $this->_helperFactory->prepare(PrepareDataHelper::class)->create();
        $reporterSelectOpt = $dataHelper->prepareSelectOpt($collection, $value, $label);

        array_unshift($reporterSelectOpt, ['value' => '', 'label' => 'Selecione']);

        return $reporterSelectOpt;
    }

    public function saveWokingTime(int $ticketId) 
    {
        if (empty($ticketId)) {
            return false;
        }

        /** @var WorkingTime $workingTime */
        $workingTime = $this->_workingTimeModelFactory->create();
        $workingTime->ticket_id = $ticketId;

        $qtyLoops = count($this->getFormData('development_date', 'working_time'));
        $i=0;

        do {
            $workingTime->development_date  = $this->getFormData('development_date', 'working_time')[$i];
            $workingTime->development_begin = $this->getFormData('development_begin', 'working_time')[$i];
            $workingTime->development_end   = $this->getFormData('development_end', 'working_time')[$i];

            $isWorkingTimeSave = $workingTime->save();
            if (empty($isWorkingTimeSave)) {
                throw new \Exception($workingTime->fail()->getMessage());                    
            }

            $i++;

        } while($i < $qtyLoops);

        return true;
    }

    public function updateWokingTime(int $ticketId) 
    {
        if (empty($ticketId)) {
            return false;
        }
        
        $this->updateRecordWorkingTime($ticketId);
        $this->saveNewRecordWorkingTime($ticketId);
        // $this->destroyRecordWorkingTime($ticketId);

        return true;
    }

    public function updateRecordWorkingTime(int $ticketId) 
    {
        if (empty($ticketId)) {
            return false;
        }

        $appoiments = $this->_workingTimeModelFactory
            ->create()
            ->find("ticket_id=:ticketId", "ticketId={$ticketId}")
            ->fetch(true);

        if (empty($appoiments)) {
            return false;
        }
        
        foreach ($appoiments as $appoiment) {
            if (!isset($this->getFormData('development_date', 'working_time')[$appoiment->time_id])) {
                continue;
            }

            $appoiment->development_date = $this->getFormData('development_date', 'working_time')[$appoiment->time_id];
            $appoiment->development_begin = $this->getFormData('development_begin', 'working_time')[$appoiment->time_id];
            $appoiment->development_end = $this->getFormData('development_end', 'working_time')[$appoiment->time_id];
            // exit($this->getFormData('status'));
            if ($this->getFormData('status') == 4) {
                $appoiment->done_at = date('Y-m-d');
            }
            
            $isSave = $appoiment->save();
            if (empty($isSave)) {
                throw new \Exception($appoiment->fail()->getMessage());                    
            } 
        }

        return true;
    }

    public function saveNewRecordWorkingTime(int $ticketId) 
    {
        if (empty($ticketId)) {
            return false;
        }

        $appoiments = $this->_workingTimeModelFactory
            ->create()
            ->find("ticket_id=:ticketId", "ticketId={$ticketId}", 'time_id')
            ->fetch(true);

        if (empty($appoiments)) {
            return false;
        }

        $idExists = [];
        foreach ($appoiments as $appoiment) {
            $idExists[] = $appoiment->time_id;
        }

        foreach ($this->getFormData('development_date', 'working_time') as $key => $value) {
            if (in_array($key, $idExists)) {
                continue;
            }

            /** @var WorkingTime $wokingTimeModel */
            $wokingTimeModel = $this->_workingTimeModelFactory->create();
            $wokingTimeModel->ticket_id = $ticketId;
            $wokingTimeModel->development_date  = $this->getFormData('development_date', 'working_time')[$key];
            $wokingTimeModel->development_begin = $this->getFormData('development_begin', 'working_time')[$key];
            $wokingTimeModel->development_end   = $this->getFormData('development_end', 'working_time')[$key];

            $isSave = $wokingTimeModel->save();
            if (empty($isSave)) {
                throw new \Exception($wokingTimeModel->fail()->getMessage());                    
            }
        }

        return true;
    }

    public function destroyRecordWorkingTime(int $ticketId)
    {
        if (empty($ticketId)) {
            return false;
        }

        $appoiments = $this->_workingTimeModelFactory
            ->create()
            ->find("ticket_id=:ticketId", "ticketId={$ticketId}")
            ->fetch(true);

        if (empty($appoiments)) {
            return false;
        }

        $idsAllowed = array_keys($this->getFormData('development_date', 'working_time'));

        foreach ($appoiments as $appoiment) {
            if (in_array($appoiment->time_id, $idsAllowed)) {
                continue;
            }
            
            $isDestroy = $appoiment->destroy();
            if (empty($isDestroy)) {
                throw new \Exception($appoiment->fail()->getMessage());                    
            }
        }
    }

    public function loadPaginateNavLink(): array
    {
        $tickets = $this->loadAllTickets();
        $paginator = new Paginator($tickets, 'tickets', $this->getCurrentPage(), $this->getListParam());
        return $paginator->render();
    }

    public function getLinkStart() 
    {
        $paginator = new Paginator(
            $this->loadTickets(), 
            'tickets', 
            $this->getCurrentPage(),
            $this->getListParam()
        );
        return $paginator->getLinkStart();
    }

    public function getLinkEnd() 
    {
        $paginator = new Paginator(
            $this->loadTickets(), 
            'tickets', 
            $this->getCurrentPage(), 
            $this->getListParam()
        );
        return $paginator->getLinkEnd();
    }

    public function totalNumberLinks() 
    {
        $paginator = new Paginator(
            $this->loadTickets(), 
            'tickets', 
            $this->getCurrentPage(), 
            $this->getListParam()
        );
        return $paginator->totalNumberLinks();
    }

    public function getCurrentPage() 
    {
        $page = 1;
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $page = $_GET['page'];
        }

        return intval($page);
    }

    public function canSaveAppointments() 
    {
        if (!empty($this->getFormData('development_date', 'working_time')) ||
            !empty($this->getFormData('development_begin', 'working_time')) ||
            !empty($this->getFormData('development_end', 'working_time'))
        ) {
            return true;
        }
        return false;
    }
}

$ticket = new Tickets(
    new TicketModelFactory(),
    new WorkingTimeModelFactory(),
    new HelperFactory()
);
$ticket->init();
