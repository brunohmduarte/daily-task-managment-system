<?php

namespace Application\Controllers;

use Application\Core\ApplicationException;
use Application\Core\Factory;
use Application\Helpers\Data as DataHelper;
use Application\Helpers\Image as ImageHelper;
use Application\Model\Store as StoreModel;
use Application\Interfaces\CrudInterfaces;

class StoresController extends Controller implements CrudInterfaces
{
    public function init() 
    {
        $this->defineAction();
    }

    public function getStoreModel() 
    {
        /** @var StoreModel $model */
        return Factory::create(StoreModel::class);
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

    public function read() 
    {
        $data = $this->getStoreModel()->listStores();
        if (!is_array($data)) {
            return [];
        }

        /** @var DataHelper $helper */
        $helper = Factory::create(DataHelper::class);

        $response = [];
        foreach ($data as $datalayer) {
            $record = (array) $datalayer->data();
            $html['store']       = "<img src=\"" . URL_BASE . "/{$record['brand_logo']}\" class=\"rounded\" alt=\"{$record['name']}\" height=\"32\" width=\"32\"> {$record['name']}";
            $html['responsible'] = $record['responsible'];
            $html['email']       = $record['email'];
            $html['phone']       = (!empty($record['phone'])) ? $helper->formatPhone($record['phone']) : '';
            $html['isActive']    = $record['is_active'] ? '<span class="badge badge-soft-success">Ativa</span>' : '<span class="badge badge-soft-danger">Inativa</span>';
            $html['actions']     = "
                <a href=\"?action=update&id={$record['store_id']}\" class=\"me-1 text-body-secondary\" title=\"Editar o registro\">
                    <span class=\"mdi mdi-text-box-edit fs-3\"></span>
                </a>
                <a href=\"?action=delete&id={$record['store_id']}\" class=\"text-body-secondary\" title=\"Deletar o registro\">
                    <span class=\"mdi mdi-delete fs-3\"></span>
                </a>
            ";
            array_push($response, $html);
        }

        return $response;
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

    public function storeExists(int $id): bool
    {
        if (empty($id)) {
            return false;
        }
        
        try {
            $store = $this->getStoreModel()->findById($id);
            if (!$store) {
                throw new ApplicationException("Store not found", "Store not found", 404);
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

}