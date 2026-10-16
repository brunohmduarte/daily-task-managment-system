<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\TicketsController;
    use Application\Core\Factory;

    AuthMiddleware::checkAccess();

    /** @var TicketsController $controller */
    $controller = Factory::create(TicketsController::class);

    $controller->init();
    $ticketRecord = [];
    $reporters = [];
    $stores = [];
    $formError = '';
    $escape = static function ($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    };

    if (in_array($controller->action, ['create', 'update', 'delete'], true)) {
        $reporters = $controller->getReporterModel()->listReporters() ?: [];
        $stores = $controller->getStoreModel()->listStores() ?: [];

        if ($controller->action !== 'create') {
            $ticketId = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
            $ticket = ($ticketId && $ticketId > 0)
                ? $controller->getTicketModel()->findById($ticketId)
                : null;

            if ($ticket) {
                $ticketRecord = (array) $ticket->data();
            } else {
                $formError = 'O ticket solicitado não foi encontrado.';
                $controller->action = 'list';
            }
        }
    }

    $isDelete = $controller->action === 'delete';
    $isForm = in_array($controller->action, ['create', 'update', 'delete'], true);
    $isReadOnly = $isDelete ? 'disabled' : '';
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

    <!-- Select2 CSS -->
    <link href="<?php echo getUrlFull('assets/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />

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
                                <h4 class="page-title fs-3">Gerenciamento de Tickets</h4>
                                <p class="text-muted mt-1">Aqui vocês pode gerenciar as informações dos tickets cadastrados que receberão os devidos cuidados para manter o sistema estável, navegável e com maior performance.</p>
                                
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <a href="javascript:history.go(-1);" class="me-2 fs-6">
                                    <i class="mdi mdi-arrow-left"></i> Voltar
                                </a>
                                <?php if ($controller->action == 'list'): ?>
                                <a href="tickets.php?action=create" class="btn btn-sm btn-primary fw-meidum fs-6">
                                    <i class="mdi mdi-plus"></i> Adicionar Ticket
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($isDelete): ?>
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
                        <?php if ($formError !== ''): ?>
                            <div class="alert alert-danger" role="alert"><?= $escape($formError) ?></div>
                        <?php endif; ?>

                        <?php if (!$isForm) : ?>

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

                            <div class="card">
                                <div class="card-body">
                                    <form class="form-horizontal needs-validation" action="api/index.php?action=<?= $isDelete ? 'deleteTicket' : ($controller->action === 'update' ? 'updateTicket' : 'createTicket') ?>" method="POST" id="formTickets" novalidate>
                                        <input type="hidden" name="ticket_id" value="<?= $escape($ticketRecord['ticket_id'] ?? '') ?>">

                                        <div class="row mb-3">
                                            <label for="reporter_id" class="col-3 col-form-label required">Relator</label>
                                            <div class="col-6">
                                                <select data-plugin="customselect" class="form-select select2-hidden-accessible" name="data[tickets][reporter_id]" id="reporter_id" required <?= $isReadOnly ?>>
                                                    <option value="">Selecione</option>
                                                    <?php foreach ($reporters as $reporter): $reporterData = (array) $reporter->data(); ?>
                                                        <option value="<?= $escape($reporterData['reporter_id'] ?? '') ?>" <?= (string) ($ticketRecord['reporter_id'] ?? '') === (string) ($reporterData['reporter_id'] ?? '') ? 'selected' : '' ?>>
                                                            <?= $escape($reporterData['name'] ?? '') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="reference" class="col-3 col-form-label required">Código de referência</label>
                                            <div class="col-6">
                                                <input class="form-control" type="text" name="data[tickets][reference]" id="reference" value="<?= $escape($ticketRecord['reference'] ?? '') ?>" autocomplete="off" required minlength="1" <?= $isDelete ? 'disabled' : '' ?>>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="title" class="col-3 col-form-label required">Título</label>
                                            <div class="col-6">
                                                <input class="form-control" type="text" name="data[tickets][title]" id="title" value="<?= $escape($ticketRecord['title'] ?? '') ?>" autocomplete="off" required minlength="3" <?= $isDelete ? 'disabled' : '' ?>>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="store_id" class="col-3 col-form-label required">Loja</label>
                                            <div class="col-6">
                                                <select class="form-select select2-hidden-accessible" name="data[tickets][store_id]" id="store_id" required <?= $isReadOnly ?>>
                                                    <option value="">Selecione</option>
                                                    <?php foreach ($stores as $store): $storeData = (array) $store->data(); ?>
                                                        <option value="<?= $escape($storeData['store_id'] ?? '') ?>" <?= (string) ($ticketRecord['store_id'] ?? '') === (string) ($storeData['store_id'] ?? '') ? 'selected' : '' ?>>
                                                            <?= $escape($storeData['name'] ?? '') ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="status" class="col-3 col-form-label required">Situação</label>
                                            <div class="col-6">
                                                <select class="form-select select2-hidden-accessible" name="data[tickets][status]" id="status" required <?= $isReadOnly ?>>
                                                    <option value="">Selecione uma situação</option>
                                                    <?php foreach (['Fazendo', 'Bloqueado', 'Pausado', 'Resolvido', 'Fechado'] as $label): ?>
                                                        <option value="<?= $label ?>" <?= (string) ($ticketRecord['status'] ?? '') === (string) $label ? 'selected' : '' ?>><?= $label ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="priority" class="col-3 col-form-label required">Nível de prioridade</label>
                                            <div class="col-6">
                                                <select class="form-select select2-hidden-accessible" name="data[tickets][priority]" id="priority" required <?= $isReadOnly ?>>
                                                    <option value="">Selecione um nível</option>
                                                    <?php foreach ([1 => 'Baixa', 2 => 'Média', 3 => 'Alta'] as $value => $label): ?>
                                                        <option value="<?= $value ?>" <?= (string) ($ticketRecord['priority'] ?? '') === (string) $value ? 'selected' : '' ?>><?= $label ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="description" class="col-3 col-form-label required">Descrição do problema</label>
                                            <div class="col-6">
                                                <textarea class="form-control" name="data[tickets][description]" id="description" rows="6" required minlength="3" <?= $isDelete ? 'disabled' : '' ?>><?= $escape($ticketRecord['description'] ?? '') ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="resolution" class="col-3 col-form-label">Como foi resolvido?</label>
                                            <div class="col-6">
                                                <textarea class="form-control" name="data[tickets][resolution]" id="resolution" rows="4" <?= $isDelete ? 'disabled' : '' ?>><?= $escape($ticketRecord['resolution'] ?? '') ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row justify-content-end">
                                            <div class="col-9">
                                                <button type="submit" class="btn btn-sm <?= $isDelete ? 'btn-danger' : 'btn-primary' ?>" id="btnSave">
                                                    <?php if ($isDelete): ?>
                                                        <span class="mdi mdi-delete"></span> Remover
                                                    <?php else: ?>
                                                        <span class="mdi mdi-content-save"></span> Salvar
                                                    <?php endif; ?>
                                                </button>
                                                <a href="tickets.php" class="btn btn-sm btn-light ms-2">Cancelar</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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

    <!-- Select2 JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="<?php echo getUrlFull('assets/libs/select2/js/select2.min.js'); ?>"></script>

    <!-- page js - MUST come after jQuery and moment -->
    <!-- <script src="<?php echo getUrlFull('assets/js/pages/dashboard.init.js'); ?>" defer></script> -->

    <!-- App js -->
    <script src="<?php echo getUrlFull('assets/js/app.js'); ?>" defer></script>

    <script>
        $(document).ready(function() {
            if ($('.select2-hidden-accessible').length > 0) {
                $('.select2-hidden-accessible').select2();
            }

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

            if ($('#formTickets').length && $.fn.validate) {
                $('#formTickets').validate({
                    rules: {
                        'data[tickets][reporter_id]': { required: true },
                        'data[tickets][reference]': { required: true },
                        'data[tickets][title]': { required: true, minlength: 3 },
                        'data[tickets][store_id]': { required: true },
                        'data[tickets][status]': { required: true },
                        'data[tickets][priority]': { required: true },
                        'data[tickets][description]': { required: true, minlength: 3 }
                    },
                    messages: {
                        'data[tickets][reporter_id]': { required: 'Selecione o relator do ticket.' },
                        'data[tickets][reference]': { required: 'Informe o código de referência.' },
                        'data[tickets][title]': {
                            required: 'Informe o título do ticket.',
                            minlength: 'O título deve ter pelo menos 3 caracteres.'
                        },
                        'data[tickets][store_id]': { required: 'Selecione a loja.' },
                        'data[tickets][status]': { required: 'Selecione a situação do ticket.' },
                        'data[tickets][priority]': { required: 'Selecione o nível de prioridade.' },
                        'data[tickets][description]': {
                            required: 'Descreva o problema.',
                            minlength: 'A descrição deve ter pelo menos 3 caracteres.'
                        }
                    },
                    errorElement: 'div',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.col-6').append(error);
                    },
                    highlight: function(element) {
                        $(element).addClass('is-invalid').removeClass('is-valid');
                    },
                    unhighlight: function(element) {
                        $(element).addClass('is-valid').removeClass('is-invalid');
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: 'POST',
                            data: $(form).serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                $('#btnSave').prop('disabled', true);
                                $('#centermodal, #backcentermodal').show();
                            },
                            success: function(response) {
                                const result = response && response.data;
                                if (response.code === 200 && result && result.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        text: result.message,
                                        confirmButtonText: 'OK'
                                    }).then(function() {
                                        window.location.href = 'tickets.php';
                                    });
                                    return;
                                }

                                Swal.fire({
                                    icon: 'error',
                                    text: (result && result.message) || 'Não foi possível salvar o ticket.'
                                });
                            },
                            error: function(xhr) {
                                const message = xhr.responseJSON && xhr.responseJSON.message
                                    ? xhr.responseJSON.message
                                    : 'Não foi possível concluir a operação.';
                                Swal.fire({ icon: 'error', text: message });
                            },
                            complete: function() {
                                $('#btnSave').prop('disabled', false);
                                $('#centermodal, #backcentermodal').hide();
                            }
                        });
                    }
                });
            }

        });
    </script>
</body>
</html>