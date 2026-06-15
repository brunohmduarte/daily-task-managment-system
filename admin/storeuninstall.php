<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\StoresController;
    use Application\Core\Factory;

    AuthMiddleware::checkAccess();

    /** @var StoresController $controller */
    $controller = Factory::create(StoresController::class);
    
    $listStores = $controller->getNamesInstalledProjectsFolders();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Daily | Desinstalação de Lojas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Página de gerenciamento das lojas." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo getUrlFull('assets/images/favicon.ico'); ?>">

    <!-- Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <!-- App CSS -->
    <link href="<?php echo getUrlFull('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- Select2 CSS -->
    <link href="<?php echo getUrlFull('assets/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />

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
                                    <h4 class="page-title fs-3">Desinstalação de Lojas</h4>
                                    <p class="text-muted mt-1">Aqui vocês pode desinstalar as lojas configuradas em seu ambiente local para liberar espaço no seu ambiente de desenvolvimento.</p>
                                    
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="javascript:history.go(-1);" class="me-2 fs-6">
                                        <i class="mdi mdi-arrow-left"></i> Voltar
                                    </a>                                    
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="storeuninstall.php" method="post" name="formStoreUninstall" id="formStoreUninstall" class="form-horizontal needs-validation" novalidate>
                                                <div class="row mb-2">
                                                    <div class="col-6">
                                                        <label for="store_id" class="form-label">Loja</label>
                                                        <select data-plugin="customselect" class="form-select select2-hidden-accessible" data-select2-id="select2-data-1-cq0k" tabindex="-1" aria-hidden="true" name="store_name" id="store_name" required>
                                                            <option value="">Selecione uma loja</option>
                                                            <?php foreach ($listStores as $store): ?>
                                                                <option value="<?= $store ?>"><?= $store ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-danger mt-3">Desinstalar Loja</button>
                                                    </div>
                                                </div>

                                                <p class="text-muted text-danger">Tem certeza que deseja desinstalar a loja <strong><?php // echo htmlspecialchars($storeName) ?></strong>? <br/>Esta ação removerá todas as configurações associadas a esta loja no sistema e não será possivel recupera-las futuramente.</p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    
    <!-- Jquery Validation and Mask -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <!-- Jquery Mask -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-mask-plugin@1.14.16/dist/jquery.mask.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            
            // Validação do formulário
            $('#formStoreUninstall').validate({
                rules: {
                    store_name: {
                        required: true
                    }
                },
                messages: {
                    store_name: {
                        required: "Por favor, selecione uma loja."
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
            $('#formStoreUninstall').on('submit', function(e) {
                e.preventDefault();

                if ($(this).valid()) {
                    var formData = new FormData(this);

                    $.ajax({
                        url: `api/index.php?action=storeUninstall`,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        error: function(xhr, status, error) {
                            console.error('Ocorreu um erro ao salvar o relator.');
                        },
                        success: function(res) {
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
                                        window.location.reload();
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