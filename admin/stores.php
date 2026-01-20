<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\StoresController;
    use Application\Core\Factory;

    AuthMiddleware::checkAccess();

    /** @var StoresController $controller */
    $controller = Factory::create(StoresController::class);

    $name            = '';
    $responsible     = '';
    $email           = '';
    $phone           = '';
    $brandLogo       = '';
    $platformVersion = '';
    $repository      = '';
    $urlLocal        = '';
    $urlSandbox      = '';
    $urlProduction   = '';
    $isActive        = '1';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller->init();

        if (isset($_GET['action']) && isset($_GET['id']) && $controller->storeExists($_GET['id'])) {
            $data            = $controller->getStoreModel()->findById($_GET['id'])->data();
            $name            = $data->name;
            $responsible     = $data->responsible;
            $email           = $data->email;
            $phone           = $data->phone;
            $brandLogo       = $data->brand_logo;   // uploade do arquivo não esta funcionando
            $platformVersion = $data->platform_version;
            $repository      = $data->repository;
            $urlLocal        = $data->url_local;
            $urlSandbox      = $data->url_sandbox;
            $urlProduction   = $data->url_production;
            $isActive        = $data->is_active;
        }

        $readonly    = ($controller->action === 'delete') ? 'readonly' : '';
        $disabled    = ($controller->action === 'delete') ? 'disabled' : '';
        $btnDisabled = ($controller->action === 'delete') ? 'disabled' : '';
        $btnColor    = ($controller->action === 'delete') ? 'btn-danger' : 'btn-primary';
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Daily | Gerenciamento de Lojas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Página de gerenciamento das lojas." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo getUrlFull('assets/images/favicon.ico'); ?>">

    <!-- Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <?= $controller->getCssExternal(); ?>

    <?php if ($controller->action == 'list') : ?>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css" />
    <?php endif; ?>

    <?php if ($controller->action !== 'list') : ?>
    <?php endif; ?>

    <!-- App CSS -->
    <link href="<?php echo getUrlFull('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- Config js -->
    <script src="<?php echo getUrlFull('assets/js/config.js'); ?>"></script>
</head>
<body>
    <div id="wrapper">
        <!-- Header -->
        <?php include_once(__DIR__ . '/components/header.php'); ?>

        <!-- Sidebar -->
        <?php include_once(__DIR__ . '/components/sidebar.php'); ?>

        <!-- Content -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="" style="width: 70%">
                                    <h4 class="page-title fs-3">Gerenciamento de Lojas</h4>
                                    <p class="text-muted mt-1">Aqui vocês pode gerenciar as informações das lojas cadastradas que receberão os devidos cuidados para manter a loja estável, navegável e com maior performance.</p>
                                    
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:history.go(-1);" class="me-2 fs-6">
                                        <i class="mdi mdi-arrow-left"></i> Voltar
                                    </a>
                                    <?php if ($controller->action == 'list'): ?>
                                    <a href="stores.php?action=create" class="btn btn-sm btn-primary fw-meidum fs-6">
                                        <i class="mdi mdi-plus"></i> Adicionar Loja
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($controller->action == 'delete'): ?>
                                <div class="alert alert-danger">
                                    <h4 class="alert-heading">Atenção!</h4>
                                    <p class="text-danger mb-1">Você está prestes a remover este registro, certifique-se de que esteja certo disso pois uma vez feito essa ação não poderá ser desfeito futuramente.</p>
                                    <p class="text-danger mb-0">Você deseja continuar com essa ação? <span class="text-primary text-decoration-underline ms-1 btnSaveOnOff" style="cursor: pointer">Sim</span></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <?php if ($controller->action == 'list') : ?>

                            <table id="listStores" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Loja</th>
                                        <th>Responsável</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        <?php else: ?>

                            <form action="stores.php" id="formStores" name="formStores" class="form-horizontal needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                                <input type="text" name="store_id" id="store_id" value="<?php echo $_GET['id'] ?? ''; ?>" hidden />
                                <input type="text" name="action" id="action" value="<?php echo $_GET['action'] ?? ''; ?>" hidden />

                                <div class="row mb-3">
                                    <label for="is_active" class="col-2 col-form-label">Ativo</label>
                                    <div class="col-7">
                                        <div class="form-check mb-1">
                                            <input type="radio" id="customRadio1" name="is_active" value="1" class="form-check-input" <?php echo ($isActive == 1) ? 'checked' : '' ?> <?= $readonly ?>>
                                            <label class="form-check-label" for="customRadio1">Sim</label>
                                        </div>
                                        <div class="form-check">
                                                <input type="radio" id="customRadio2" name="is_active" value="0" class="form-check-input" <?php echo ($isActive == 0) ? 'checked' : '' ?> <?= $readonly ?>>
                                                <label class="form-check-label" for="customRadio2">Não</label>
                                            </div>
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-2 col-form-label required">Nome</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="name" id="name" value="<?= $name ?>" autocomplete="off" required minlength="3" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="responsible" class="col-2 col-form-label required">Responsável</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="responsible" id="responsible" value="<?= $responsible ?>" autocomplete="off" required minlength="3" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-2 col-form-label required">E-mail</label>
                                    <div class="col-7">
                                        <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" autocomplete="off" required <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="phone" class="col-2 col-form-label">Celular</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="phone" id="phone" value="<?= $phone ?>" autocomplete="off" minlength="10" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="picture" class="col-2 col-form-label">Foto</label>
                                    <div class="col-7">
                                        <?php if ($controller->action !== 'delete'): ?>
                                            <input type="file" class="form-control" name="brand_logo" id="brand_logo" autocomplete="off" />
                                        <?php endif; ?>
                                        <?php if ($controller->action != 'create'): ?>
                                            <img src="<?php echo $brandLogo; ?>" alt="Adriana Silva" class="rounded-2 mt-2" width="60">
                                            <?php if ($controller->action !== 'delete'): ?>
                                                <div class="form-check form-switch mt-1">
                                                    <input type="checkbox" class="form-check-input" name="brand_logo_remove" id="brand_logo_remove">
                                                    <label class="form-check-label fw-medium" for="brand_logo_remove">
                                                        <small>Deseja excluir a foto atual?</small>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="platform_version" class="col-2 col-form-label">Versão da Plataforma</label>
                                    <div class="col-7">
                                        <select class="form-select" name="platform_version" id="platform_version" <?= $disabled ?>>
                                            <option value="">Selecione</option>
                                            <option value="M1" <?= ($platformVersion == 'M1') ? 'selected' : '' ?>>Magento 1</option>
                                            <option value="M2" <?= ($platformVersion == 'M2') ? 'selected' : '' ?>>Magento 2</option>
                                        </select>
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="repository" class="col-2 col-form-label ">Repositório</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="repository" id="repository" value="<?= $repository ?>" autocomplete="off" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="url_local" class="col-2 col-form-label">URL Local</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="url_local" id="url_local" value="<?= $urlLocal ?>" autocomplete="off" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="url_sandbox" class="col-2 col-form-label">URL Sandbox</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="url_sandbox" id="url_sandbox" value="<?= $urlSandbox ?>" autocomplete="off" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="url_production" class="col-2 col-form-label">URL Produção</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="url_production" id="url_production" value="<?= $urlProduction ?>" autocomplete="off" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-0 justify-content-end">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-sm <?= $btnColor ?> fw-medium fs-6" id="btnSave" data-stayonpage="0" <?= $btnDisabled ?>>
                                            <?php if (in_array($controller->action, ['update','create'])): ?>    
                                                <span class="mdi mdi-content-save"></span> Salvar
                                            <?php endif; ?>
                                            <?php if ($controller->action == 'delete'): ?>    
                                                <span class="mdi mdi-delete"></span> Remover
                                            <?php endif; ?>
                                        </button>

                                        <?php if ($controller->action == 'update'): ?>
                                            <button type="submit" class="btn btn-sm btn-primary fw-medium fs-6 ms-2" id="btnSaveStayOnPage" data-stayonpage="1">
                                                <span class="mdi mdi-content-save"></span> Salvar e permanecer na página
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>

                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Settings -->
    <?php include_once(__DIR__ . '/components/sidebar-settings.php'); ?>

    <!-- Modal Spinner -->
     <div class="modal " id="centermodal" tabindex="-1" aria-labelledby="myCenterModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="d-flex justify-content-center align-items-center" >
                    <div class="spinner-border text-dark m-2" role="status">
                        <span class="visually-hidden"></span>
                    </div>
                    Processando...
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-backdrop fade show" id="backcentermodal" style="display: none;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Icons CDN -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js" defer></script>

    <!-- Lucide Icons CDN -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.min.js" defer></script>

    <!-- Initialize Feather Icons -->
    <script defer>
        if (typeof feather !== 'undefined' && feather.replace) {
            document.addEventListener('DOMContentLoaded', function() {
                feather.replace();
            });
        }
    </script>

    <?= $controller->getJsExternal(); ?>

    <?php if ($controller->action == 'list'): ?>
        <!-- DataTables Plugin -->
        <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>
    <?php endif; ?>
    
    <?php if ($controller->action !== 'list'): ?>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>
    <?php endif; ?>

    <!-- page js - MUST come after jQuery and moment -->
    <!-- <script src="<?php echo getUrlFull('assets/js/pages/dashboard.init.js'); ?>" defer></script> -->

    <!-- App js -->
    <script src="<?php echo getUrlFull('assets/js/app.js'); ?>" defer></script>

    <script>
        $(document).ready(function() {
            // Como DataTables extende o jQuery, podemos verificar se o plugin foi carregado
            if ($.fn.dataTable) {
                var columnsOption = [                
                    { 
                        data: "store",
                        searchable: true
                    },
                    { 
                        data: "responsible",
                        searchable: true
                    },
                    { 
                        data: "email",
                        searchable: true
                    },
                    { 
                        data: "phone",
                        searchable: true
                    },
                    { 
                        data: "isActive"
                    },
                    { 
                        data: "actions"
                    }
                ];

                var order = [
                    [0, "asc"]
                ];

                $('#listStores').DataTable({
                    paging: true,
                    scrollY: 400,
                    ajax: 'api/index.php?action=listStores',
                    columns: columnsOption,
                    order: order,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                    }
                });
            }

            if ($.fn.mask) {
                $('#phone').mask('(00) #0000-0000');
            }

            // Validação do formulário
            $('#formStores').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    responsible: {
                        required: true,
                        minlength: 3
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: false,
                        minlength: 10
                    }
                },
                messages: {
                    name: {
                        required: "Por favor, insira o nome do relator.",
                        minlength: "O nome deve ter no mínimo 3 caracteres."
                    },
                    responsible: {
                        required: "Por favor, insira o nome do responsável.",
                        minlength: "O nome deve ter no mínimo 3 caracteres."
                    },
                    email: {
                        required: "Por favor, insira o e-mail.",
                        email: "Por favor, insira um e-mail válido."
                    },
                    phone: {
                        required: "Por favor, insira o telefone.",
                        minlength: "O telefone deve ter no mínimo 10 caracteres."
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-7').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                }
            });

            // Formulário de submissão via AJAX
            $('#formStores').on('submit', function(e) {
                e.preventDefault();

                if ($(this).valid()) {
                    var formData = new FormData(this);
                    let action = formData.get('action');

                    $.ajax({
                        url: `api/index.php?action=${action}Store`,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) { console.log('response:', res);
                            // hide modal spinner
                            $('#centermodal').hide();
                            $('#backcentermodal').hide();

                            // success
                            if (res.code === 200 && res.data.status === 'success') {                                
                                let dataStayOnPage = $(document.activeElement).data('stayonpage');
                                // Handle success response
                                Swal.fire({
                                    icon: 'success',
                                    text: res.data.message,
                                    showConfirmButton: true,
                                    // timer: 2000
                                }).then(() => {
                                    if (dataStayOnPage == 1) {
                                        window.location.href = window.location.search;
                                    } else {
                                        window.location.href = 'stores.php';
                                    }
                                });
                            } 
                            
                            // error
                            if (res.code !== 200 || res.data.status === 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    text: res.data.message || 'Ocorreu um erro ao salvar o relator.',
                                    showConfirmButton: true,
                                });
                            }
                        },
                        beforeSend: function() {
                            $('#centermodal').show();
                            $('#backcentermodal').show();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            Swal.fire({
                                icon: 'error',
                                text: res.data.message || 'Ocorreu um erro ao salvar o relator.',
                                showConfirmButton: true,
                            });
                        }
                    });
                }
            });

            // Habilita o botão caso o registro seja deletado e alterna o texto da mensagem de aviso.
            $('.btnSaveOnOff').on('click', function() {
                let btnSave = $('#btnSave');
                let property = btnSave.prop('disabled');
                let LabelLink = (property === true) ? 'Não' : 'Sim';
                
                btnSave.prop('disabled', !property);
                $(this).text(LabelLink);
            });
            
        });
    </script>
</body>
</html>