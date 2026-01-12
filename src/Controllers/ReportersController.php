<?php

namespace Application\Controllers;

use Application\Core\ApplicationException;
use Application\Core\Factory;
use Application\Helpers\Data as DataHelper;
use Application\Helpers\Image as ImageHelper;
use Application\Model\Reporter as ReporterModel;
use Application\Interfaces\CrudInterfaces;
use CoffeeCode\Uploader\Image;

class ReportersController extends Controller implements CrudInterfaces
{
    public function init() 
    {
        $this->defineAction();
    }

    public function getReporterModel() 
    {
        /** @var ReporterModel $model */
        return Factory::create(ReporterModel::class);
    }

    public function create() {
        try {
            $name = trim($_POST['name']);
            $picture = '';

            // Upload de imagem
            $file = $_FILES['picture'] ?? null;
            if ($file && $file['error'] == 0) {
                // if ($file['error'] == 0) {
                //     $image = Factory::create(Image::class, ['../../assets/images', 'reporters']);
                //     $filename = strtolower($name) . date('YmdHis');
                //     $picture = $image->upload($file, $filename);
                // }

                /** @var ImageHelper $imageHelper */
                $imageHelper = Factory::create(ImageHelper::class);
                $picture = $imageHelper->upload($file, $name, 'reporters');
            }

            $reporterModel = $this->getReporterModel();
            $reporterModel->name = $name;
            $reporterModel->picture = $picture;
            $isSaved = $reporterModel->save();

            if (!$isSaved) {
                throw new ApplicationException("Reporter not saved", 500);
            }

            return [
                'status' => 'success',
                'message' => 'Relator criado como sucesso!'
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

    public function read() {
        $data = $this->getReporterModel()->listReporters();
        if (!is_array($data)) {
            return [];
        }

        /** @var DataHelper $helper */
        $helper = Factory::create(DataHelper::class);
        $fields = ['reporter_id', 'name', 'picture', 'created_at', 'actions'];
        $return = $helper->prepareDataTables($data, $fields);

        return $return;
    }

    public function update() {
        try {
            $id = $_POST['reporter_id'] ?? null;
            if (empty($id)) {
                throw new ApplicationException("Reporter not found", 404);
            }
            
            $reporter = $this->getReporterModel()->findById($id);
            if (!$reporter) {
                throw new ApplicationException("Reporter not found", 404);
            }

            $name = trim($_POST['name']);
            $file = $_FILES['picture'] ?? null;
            if ($file && $file['error'] == 0) {
                // Removendo a foto antiga.
                $removePhoto = $_POST['picture_remove'] ?? 'off'; 
                if ($removePhoto == 'on' && !empty($reporter->picture) && file_exists($reporter->picture)) {
                    unlink($reporter->picture);
                    $reporter->picture = '';
                }

                /** @var ImageHelper $imageHelper */
                $imageHelper = Factory::create(ImageHelper::class);
                $picture = $imageHelper->upload($file, $name, 'reporters');
                
                $reporter->picture = $picture;
            }

            $reporter->name = $name;
            $save = $reporter->save();

            if (!$save) {
                throw new ApplicationException("Reporter not updated", 500);
            }

            // die(header('Location: reporters.php'));
            return [
                'status' => 'success',
                'message' => 'Relator atualizado com sucesso!'
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

    public function delete() {
        try {
            $id = $_POST['reporter_id'] ?? null;
            if (empty($id)) {
                throw new ApplicationException("Reporter not found", 404);
            }
            
            $reporter = $this->getReporterModel()->findById($id);
            if (!$reporter) {
                throw new ApplicationException("Reporter not found", 404);
            }

            // Removendo a foto antiga.
            if (!empty($reporter->picture) && file_exists($reporter->picture)) {
                unlink($reporter->picture);
            }

            $isDestroyed = $reporter->destroy();
            if (!$isDestroyed) {
                throw new ApplicationException("Reporter not updated", 500);
            }

            return [
                'status' => 'success',
                'message' => 'Relator removido com sucesso!'
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

    public function checkIFReporterExists() {
        $id = $_GET['id'] ?? null;

        /** @var ReporterModel $reporterModel */
        $reporterModel = $this->getReporterModel();

        try {
            $reporter = $reporterModel->findById($id);
            if (!$reporter) {
                throw new ApplicationException("Reporter not found", "Reporter not found", 404);
            }

            return true;

        } catch (ApplicationException $e) {
            echo $e->getUserMessage();
            return false;
        }
    }
}

