<?php

namespace Application\Controllers;

use Application\Core\ApplicationException;
use Application\Core\Factory;
use Application\Model\Reporter as ReporterModel;
use Application\Model\Store as StoreModel;
use Application\Model\Ticket as TicketModel;
use Application\Interfaces\CrudInterfaces;

class TicketsController extends Controller implements CrudInterfaces
{
    public function init() 
    {
        $this->defineAction();
    }

    public function getTicketModel() 
    {
        /** @var TicketModel $model */
        return Factory::create(TicketModel::class);
    }

    public function getStoreModel(): StoreModel
    {
        return Factory::create(StoreModel::class);
    }

    public function getReporterModel(): ReporterModel
    {
        return Factory::create(ReporterModel::class);
    }

    public function create()
    {
        return $this->saveTicket();
    }

    public function read(): array
    {
        $data = $this->getTicketModel()->listTickets();
        if (!is_array($data)) {
            return [];
        }

        return $data;
    }

    public function update()
    {
        return $this->saveTicket(true);
    }

    public function delete()
    {
        try {
            $id = filter_var($_POST['ticket_id'] ?? null, FILTER_VALIDATE_INT);
            if (!$id || $id < 1) {
                throw new ApplicationException("Ticket não encontrado.", "Invalid ticket ID", 400);
            }

            $ticket = $this->getTicketModel()->findById($id);
            if (!$ticket) {
                throw new ApplicationException("Ticket não encontrado.", "Ticket not found", 404);
            }

            if (!$ticket->destroy()) {
                throw new ApplicationException("Não foi possível remover o ticket.", "Ticket deletion failed", 500);
            }

            return [
                'status' => 'success',
                'message' => 'Ticket removido com sucesso!'
            ];

        } catch (ApplicationException $e) {
            return [
                'status' => 'error',
                'message' => $e->getUserMessage()
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    private function saveTicket(bool $isUpdate = false): array
    {
        try {
            $input = $_POST['data']['tickets'] ?? $_POST;
            if (!is_array($input)) {
                throw new ApplicationException("Os dados do ticket são inválidos.", "Invalid ticket payload", 400);
            }

            $ticketId = filter_var($input['ticket_id'] ?? $_POST['ticket_id'] ?? null, FILTER_VALIDATE_INT);
            if ($isUpdate && (!$ticketId || $ticketId < 1)) {
                throw new ApplicationException("Ticket não encontrado.", "Invalid ticket ID", 400);
            }

            $requiredFields = ['reference', 'title', 'description', 'reporter_id', 'store_id', 'status', 'priority'];
            foreach ($requiredFields as $field) {
                if (!isset($input[$field]) || !is_scalar($input[$field]) || trim((string) $input[$field]) === '') {
                    throw new ApplicationException("Preencha todos os campos obrigatórios.", "Missing field: {$field}", 400);
                }
            }

            if (strlen(trim((string) $input['title'])) < 3
                || strlen(trim((string) $input['description'])) < 3
            ) {
                throw new ApplicationException("O título e a descrição devem ter pelo menos 3 caracteres.", "Ticket text is too short", 400);
            }

            $reporterId = filter_var($input['reporter_id'], FILTER_VALIDATE_INT);
            $storeId = filter_var($input['store_id'], FILTER_VALIDATE_INT);
            $status = filter_var($input['status'], FILTER_VALIDATE_INT);
            $priority = filter_var($input['priority'], FILTER_VALIDATE_INT);

            if (!$reporterId || !$storeId || !$status || !$priority
                || $status < 1 || $status > 5
                || $priority < 1 || $priority > 3
            ) {
                throw new ApplicationException("Selecione um relator, uma loja, uma situação e uma prioridade válidos.", "Invalid ticket selection", 400);
            }

            if (!$this->getReporterModel()->findById($reporterId)
                || !$this->getStoreModel()->findById($storeId)
            ) {
                throw new ApplicationException("O relator ou a loja selecionados não foram encontrados.", "Invalid reporter or store", 400);
            }

            $ticket = $isUpdate
                ? $this->getTicketModel()->findById($ticketId)
                : $this->getTicketModel();

            if (!$ticket) {
                throw new ApplicationException("Ticket não encontrado.", "Ticket not found", 404);
            }

            $ticket->reference = trim((string) $input['reference']);
            $ticket->title = trim((string) $input['title']);
            $ticket->description = trim((string) $input['description']);
            $ticket->resolution = trim((string) ($input['resolution'] ?? ''));
            $ticket->reporter_id = $reporterId;
            $ticket->store_id = $storeId;
            $ticket->status = $status;
            $ticket->priority = $priority;

            if (!$ticket->save()) {
                throw new ApplicationException("Não foi possível salvar o ticket.", "Ticket save failed", 500);
            }

            return [
                'status' => 'success',
                'message' => $isUpdate ? 'Ticket atualizado com sucesso!' : 'Ticket criado com sucesso!'
            ];
        } catch (ApplicationException $e) {
            return [
                'status' => 'error',
                'message' => $e->getUserMessage()
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function listTickets() 
    {
        $data = $this->read();
        if (!is_array($data)) {
            return [];
        }

        /* @var DataHelper $helper */
        // $helper = Factory::create(DataHelper::class);

        $stores = Factory::create(StoreModel::class)->listStores();
        $storesById = [];
        if (is_array($stores)) {
            foreach ($stores as $store) {
                $storeRecord = (array) $store->data();
                $storesById[$storeRecord['store_id']] = $storeRecord;
            }
        }

        $reporters = Factory::create(ReporterModel::class)->listReporters();
        $reportersById = [];
        if (is_array($reporters)) {
            foreach ($reporters as $reporter) {
                $reporterRecord = (array) $reporter->data();
                $reportersById[$reporterRecord['reporter_id']] = $reporterRecord;
            }
        }

        $response = [];
        foreach ($data as $datalayer) {
            $record = (array) $datalayer->data();
            $storeId = $record['store_id'] ?? '';
            $store = $storesById[$storeId] ?? [];
            $storeName = (string) ($store['name'] ?? $storeId);
            $storeNameHtml = htmlspecialchars($storeName, ENT_QUOTES, 'UTF-8');
            $storeImage = '';

            if (!empty($store['brand_logo'])) {
                $storeImageUrl = htmlspecialchars(
                    URL_BASE . '/' . ltrim($store['brand_logo'], '/'),
                    ENT_QUOTES,
                    'UTF-8'
                );
                $storeImage = "<img src=\"{$storeImageUrl}\" alt=\"{$storeNameHtml}\" title=\"{$storeNameHtml}\" class=\"rounded-circle me-3 shadow\" height=\"48\">";
            }

            $reporterId = $record['reporter_id'] ?? '';
            $reporter = $reportersById[$reporterId] ?? [];
            $reporterName = htmlspecialchars(
                (string) ($reporter['name'] ?? $reporterId),
                ENT_QUOTES,
                'UTF-8'
            );

            $html['reference'] = $record['reference'];
            $html['title']     = $record['title'];
            $html['store']     = $storeImage . $storeNameHtml;
            $html['reporter']  = !empty($reporterId)
                ? "<a href=\"reporters.php?action=update&id=" . rawurlencode((string) $reporterId) . "\">{$reporterName}</a>"
                : $reporterName;
            $html['status']    = $this->badgeHtml($record['status']);
            $html['create_at'] = date('d/m/Y', strtotime($record['created_at']));
            $html['actions']   = "
                <a href=\"?action=update&id={$record['ticket_id']}\" class=\"me-1 text-body-secondary\" title=\"Editar o registro\">
                    <span class=\"mdi mdi-text-box-edit fs-3\"></span>
                </a>
                <a href=\"?action=delete&id={$record['ticket_id']}\" class=\"text-body-secondary\" title=\"Deletar o registro\">
                    <span class=\"mdi mdi-delete fs-3\"></span>
                </a>
            ";
            array_push($response, $html);
        }

        return $response;
    }

    public function ticketExists(int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        
        try {
            $ticket = $this->getTicketModel()->findById($id);
            if (!$ticket) {
                throw new ApplicationException("Ticket not found", "Ticket not found", 404);
            }

            return true;

        } catch (ApplicationException $e) {
            echo $e->getUserMessage();
            return false;
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function badgeHtml($status)
    {
        $html = '<span class="badge badge-soft-success">Ativa</span>';
        return $html;
    }
}