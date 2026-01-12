<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\ReportersController;
    use Application\Core\Factory;

    AuthMiddleware::checkAccess();

    /** @var ReportersController $controller */
    $controller = Factory::create(ReportersController::class);

    $name = '';
    $picture = '';

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller->init();

        if (isset($_GET['action']) && isset($_GET['id']) && $controller->checkIFReporterExists()) {
            $data = $controller->getReporterModel()->findById($_GET['id'])->data();
            $name = $data->name;
            $picture = $data->picture;
        }

        $readonly = ($controller->action === 'delete') ? 'readonly' : '';
        $btnDisabled = ($controller->action === 'delete') ? 'disabled' : '';
        $btnColor = ($controller->action === 'delete') ? 'btn-danger' : 'btn-primary';
    }

    // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    //     $action = $_GET['action'];
    //     if (method_exists($controller, $action)) {
    //         $controller->$action();
    //     } else {
    //         // Handle unknown action
    //         http_response_code(400);
    //         echo "Ação desconhecida.";
    //         exit;
    //     }
    // }

    // echo '<pre>'. print_r($_SERVER, true) .'</pre>';
    // exit;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Daily | Relatores de tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Página de gerenciamento dos relatores dos tickets." name="description" />
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
                                    <h4 class="page-title fs-3">Relatores de Tickets</h4>
                                    <p class="text-muted mt-1">O relatorio de relatores de tickets é a pessoa responsável por entender as necessidades da loja do clientes e transformar em tickets internos para que o desenvolvedores possa implementar, corrigir, realizar orçamento de tempo de desenvolvimento e outras tarefas relacionadas aos tickets.</p>
                                    
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:history.go(-1);" class="me-2 fs-6">
                                        <i class="mdi mdi-arrow-left"></i> Voltar
                                    </a>
                                    <?php if ($controller->action == 'list'): ?>
                                    <a href="reporters.php?action=create" class="btn btn-sm btn-primary fw-meidum fs-6">
                                        <i class="mdi mdi-plus"></i> Adicionar Relator
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($controller->action == 'delete'): ?>
                                <div class="alert alert-danger">
                                    <h4 class="alert-heading">Atenção!</h4>
                                    <p class="text-danger mb-1">Você está prestes a remover este registro, certifique-se de que esteja certo disso pois uma vez feito essa ação apagará o registro permanentemente e não poderá ser desfeito futuramente.</p>
                                    <p class="text-danger mb-0">Você deseja continuar com essa ação? <span class="text-primary text-decoration-underline ms-1 btnSaveOnOff" style="cursor: pointer">Sim</span></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        <?php if ($controller->action == 'list') : ?>

                            <table id="listTicketReporters" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Cadastrado em:</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        <?php endif; ?>

                        <?php if ($controller->action != 'list'): ?>
                            <form action="reporters.php" id="formReporters" name="formReporters" class="form-horizontal needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                                <input type="text" name="reporter_id" id="reporter_id" value="<?php echo $_GET['id'] ?? ''; ?>" hidden />
                                <input type="text" name="action" id="action" value="<?php echo $_GET['action'] ?? ''; ?>" hidden />
                                <div class="row mb-3">
                                    <label for="name" class="col-2 col-form-label required">Nome</label>
                                    <div class="col-7">
                                        <input type="text" class="form-control" name="name" id="name" value="<?= $name ?>" autocomplete="off" required minlength="3" <?= $readonly ?> />
                                    </div>
                                    <div class="col-3"></div>
                                </div>

                                <div class="row mb-3">
                                    <label for="picture" class="col-2 col-form-label">Foto</label>
                                    <div class="col-7">
                                        <?php if ($controller->action !== 'delete'): ?>
                                            <input type="file" class="form-control" name="picture" id="picture" autocomplete="off" />
                                        <?php endif; ?>
                                        <?php if ($controller->action != 'create'): ?>
                                            <img src="<?php echo $picture; ?>" alt="Adriana Silva" class="rounded-2 mt-2" width="60">
                                            <?php if ($controller->action !== 'delete'): ?>
                                                <div class="form-check form-switch mt-1">
                                                    <input type="checkbox" class="form-check-input" name="picture_remove" id="picture_remove">
                                                    <label class="form-check-label fw-medium" for="picture_remove">
                                                        <small>Deseja excluir a foto atual?</small>
                                                    </label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
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
        </div>
    </div>

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
                        data: "reporter_id",
                        searchable: true
                    },
                    { 
                        data: "name",
                        searchable: true
                    },
                    { 
                        data: "created_at",
                        searchable: true
                    },
                    { 
                        data: "actions"
                    }
                ];

                var order = [
                    [0, "asc"]
                ];

                $('#listTicketReporters').DataTable({
                    paging: true,
                    scrollY: 400,
                    ajax: 'api/index.php?action=listTicketReporters',
                    columns: columnsOption,
                    order: order,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/pt-BR.json'
                    }
                });
            }

            // Validação do formulário
            $('#formReporters').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3
                    },
                    picture: {
                        required: false,
                        // extension: "jpg|jpeg|png|gif"
                    }
                },
                messages: {
                    name: {
                        required: "Por favor, insira o nome do relator.",
                        minlength: "O nome deve ter nom mínimo 3 caracteres."
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
            $('#formReporters').on('submit', function(e) {
                e.preventDefault();
                if ($(this).valid()) {
                    // Submit via AJAX
                    var formData = new FormData(this);
                    let action = formData.get('action');

                    $.ajax({
                        url: `api/index.php?action=${action}Reporter`,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(res) { console.log('response:', res);
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
                                        window.location.href = 'reporters.php';
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