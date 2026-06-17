<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\TicketsController;
    use Application\Core\Factory;

    AuthMiddleware::checkAccess();

    /** @var TicketsController $controller */
    $controller = Factory::create(TicketsController::class);

    list(
        $reporterId, $storeId, $reference, $title, $description, $resolution, $status, $priority, $open
    ) = [
        '', '', '', '', '', '', '', '', ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller->init();

        if (isset($_GET['action']) && isset($_GET['id']) && $controller->ticketExists($_GET['id'])) {
            $data        = $controller->getTicketModel()->findById($_GET['id'])->data();
            $reporterId  = $data->reporter;
            $storeId     = $data->store;
            $reference   = $data->reference;
            $title       = $data->title;
            $description = $data->description;
            $resolution  = $data->resolution;
            $status      = $data->status;
            $priority    = $data->priority;
            $open        = $data->open;
        }

        $readonly    = ($controller->action === 'delete') ? 'readonly' : '';
        $disabled    = ($controller->action === 'delete') ? 'disabled' : '';
        $btnDisabled = ($controller->action === 'delete') ? 'disabled' : '';
        $btnColor    = ($controller->action === 'delete') ? 'btn-danger' : 'btn-primary';
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Página de gerenciamento das lojas." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />    
    <title>Daily | Gerenciamento de Tickets</title>

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
    <!-- Header -->
    <?php include_once(__DIR__ . '/components/header.php'); ?>

    <!-- Sidebar -->
    <?php include_once(__DIR__ . '/components/sidebar.php'); ?>

    <!-- Content -->
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <!-- Header -->
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

                <!-- Content -->
                <div class="row">
                    <div class="col-12">
                        <?php if ($controller->action == 'list') : ?>

                            <table id="listTickets" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Referência</th>
                                        <th>Título</th>
                                        <th>Loja</th>
                                        <th>Relator</th>
                                        <th>Status</th>
                                        <th>Criado em</th>
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
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        <?php else: ?>
                            <p>Formulário de cadastro de ticket</p>
                        <?php endif; ?>
                    </div>
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
                        data: "reference",
                        searchable: true
                    },
                    { 
                        data: "title",
                        searchable: true
                    },
                    { 
                        data: "store",
                        searchable: true
                    },
                    { 
                        data: "reporter",
                        searchable: true
                    },
                    { 
                        data: "status"
                    },
                    { 
                        data: "create_at"
                    },
                    { 
                        data: "actions"
                    }
                ];

                var order = [
                    [0, "asc"]
                ];

                $('#listTickets').DataTable({
                    paging: true,
                    scrollY: 400,
                    ajax: 'api/index.php?action=listTickets',
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
            /*
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
            */

            // Formulário de submissão via AJAX
            /*
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
            */

            // Habilita o botão caso o registro seja deletado e alterna o texto da mensagem de aviso.
            /*
            $('.btnSaveOnOff').on('click', function() {
                let btnSave = $('#btnSave');
                let property = btnSave.prop('disabled');
                let LabelLink = (property === true) ? 'Não' : 'Sim';
                
                btnSave.prop('disabled', !property);
                $(this).text(LabelLink);
            });
            */
        });
    </script>
</body>
</html>