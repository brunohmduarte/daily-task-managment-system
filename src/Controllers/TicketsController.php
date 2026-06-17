<?php

namespace Application\Controllers;

use Application\Core\ApplicationException;
use Application\Core\Factory;
use Application\Helpers\Data as DataHelper;
use Application\Helpers\FilesManipulation as FilesHelper;
use Application\Helpers\Image as ImageHelper;
use Application\Model\Ticket as TicketModel;
use Application\Model\Resource\DataDefinition;
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

    public function create()
    {
        try {
            $name            = trim($_POST['name']);
            $responsible     = trim($_POST['responsible']);
            $email           = $_POST['email'];
            $phone           = $_POST['phone'];
            $platformVersion = $_POST['platform_version'];
            $repository      = $_POST['repository'];
            $urlLocal        = $_POST['url_local'];
            $urlSandbox      = $_POST['url_sandbox'];
            $urlProduction   = $_POST['url_production'];
            $isActive        = $_POST['is_active'];
            $picture = '';

            // Upload de imagem
            $file = $_FILES['brand_logo'] ?? null;
            if ($file && $file['error'] == 0) {
                /** @var ImageHelper $imageHelper */
                $imageHelper = Factory::create(ImageHelper::class);

                $picture = $imageHelper->upload($file, $name, 'stores');
            }

            $storeModel = $this->getStoreModel();
            $storeModel->name             = $name;
            $storeModel->responsible      = $responsible;
            $storeModel->email            = $email;
            $storeModel->phone            = preg_replace('/\D/', '', $phone);
            $storeModel->platform_version = $platformVersion;
            $storeModel->repository       = $repository;
            $storeModel->url_local        = $urlLocal;
            $storeModel->url_sandbox      = $urlSandbox;
            $storeModel->url_production   = $urlProduction;
            $storeModel->is_active        = $isActive;
            $storeModel->brand_logo       = $picture;

            $isSaved = $storeModel->save();
            if (!$isSaved) {
                throw new ApplicationException("Não foi possível criar a nova loja.", 500);
            }

            return [
                'status' => 'success',
                'message' => 'Loja criada com sucesso!'
            ];

        } catch (ApplicationException $e) {
            return [
                'status' => 'error',
                'message' => $e->getUserMessage()
            ];
            /**
             * @todo 
             * 1. Criar um mecânismo de padronização de mensagens. Ex: crud messages
             * 2. Registrar o erro real em um arquivo de log
             * 3. Enviar a mensagem amigável para a tela
             */
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
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
        try {
            $name            = trim($_POST['name']) ?? null;
            $responsible     = trim($_POST['responsible']) ?? null;
            $email           = $_POST['email'] ?? null;
            $phone           = $_POST['phone'] ?? null;
            $platformVersion = $_POST['platform_version'] ?? null;
            $repository      = $_POST['repository'] ?? null;
            $urlLocal        = $_POST['url_local'] ?? null;
            $urlSandbox      = $_POST['url_sandbox'] ?? null;
            $urlProduction   = $_POST['url_production'] ?? null;
            $isActive        = $_POST['is_active'] ?? null;
            $id              = $_POST['store_id'] ?? null;
            $file            = $_FILES['brand_logo'] ?? null;
            $picture         = '';

            if (empty($id)) {
                throw new ApplicationException("Loja não encontrada", 404);
            }

            $store = $this->getStoreModel()->findById($id);
            if (!$store) {
                throw new ApplicationException("Loja não encontrada", 404);
            }

            if ($file && $file['error'] == 0) {
                // Removendo a foto antiga.
                $removePhoto = $_POST['picture_remove'] ?? 'off'; 
                if ($removePhoto == 'on' && !empty($store->brand_logo) && file_exists($store->brand_logo)) {
                    unlink($store->brand_logo);
                    $store->brand_logo = '';
                }

                /** @var ImageHelper $imageHelper */
                $imageHelper = Factory::create(ImageHelper::class);
                $picture = $imageHelper->upload($file, $name, 'stores');

                $store->brand_logo = $picture;
            }

            $store->name             = $name;
            $store->responsible      = $responsible;
            $store->email            = $email;
            $store->phone            = preg_replace('/\D/', '', $phone);
            $store->platform_version = $platformVersion;
            $store->repository       = $repository;
            $store->url_local        = $urlLocal;
            $store->url_sandbox      = $urlSandbox;
            $store->url_production   = $urlProduction;
            $store->is_active        = $isActive;

            $save = $store->save();

            if (!$save) {
                throw new ApplicationException("Não foi possível atualizar os dados da loja.", 500);
            }

            return [
                'status' => 'success',
                'message' => 'Loja atualizada com sucesso!'
            ];
        
        } catch (ApplicationException $e) {
            return [
                'status' => 'error',
                'message' => $e->getUserMessage()
            ];
            /**
             * @todo 
             * 1. Criar um mecânismo de padronização de mensagens. Ex: crud messages
             * 2. Registrar o erro real em um arquivo de log
             * 3. Enviar a mensagem amigável para a tela
             */
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function delete()
    {
        try {
            $name            = trim($_POST['name']) ?? null;
            $responsible     = trim($_POST['responsible']) ?? null;
            $email           = $_POST['email'] ?? null;
            $phone           = $_POST['phone'] ?? null;
            $platformVersion = $_POST['platform_version'] ?? null;
            $repository      = $_POST['repository'] ?? null;
            $urlLocal        = $_POST['url_local'] ?? null;
            $urlSandbox      = $_POST['url_sandbox'] ?? null;
            $urlProduction   = $_POST['url_production'] ?? null;
            $isActive        = $_POST['is_active'] ?? null;
            $id              = $_POST['store_id'] ?? null;
            $file            = $_FILES['brand_logo'] ?? null;

            if (empty($id)) {
                throw new ApplicationException("Loja não encontrada", 404);
            }
            
            $store = $this->getStoreModel()->findById($id);
            if (!$store) {
                throw new ApplicationException("Loja não encontrada", 404);
            }

            // Removendo a foto antiga.
            if (!empty($store->brand_logo) && file_exists($store->brand_logo)) {
                unlink($store->brand_logo);
            }

            $isDestroyed = $store->destroy();
            if (!$isDestroyed) {
                throw new ApplicationException("Não foi possivel remover a loja.", 500);
            }

            return [
                'status' => 'success',
                'message' => 'Loja removida com sucesso!'
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

        $response = [];
        foreach ($data as $datalayer) {
            $record = (array) $datalayer->data();
            $html['reference'] = $record['reference'];
            $html['title']     = $record['title'];
            $html['store']     = $record['store_id'];
            $html['reporter']  = $record['reporter_id'];
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