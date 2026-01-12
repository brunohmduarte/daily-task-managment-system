<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\DashboardController;
    use Application\Core\Factory;

    AuthMiddleware::checkAccess();

    /** @var DashboardController $dashboardController */
    $dashboardController = Factory::create(DashboardController::class);
    $dashboardController->init();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Daily | Admin - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo getUrlFull('assets/images/favicon.ico'); ?>">

    <!-- plugins -->
    <link href="<?php echo getUrlFull('assets/libs/flatpickr/flatpickr.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- Icons CSS -->
    <!-- <link href="<?php //echo getUrlFull('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">

    <?= $dashboardController->getCssExternal(); ?>

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
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Dashboard</h4>
                            </div>
                        </div>
                    </div>

                    <!-- stats boxes -->
                    <div class="row">
                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted text-uppercase fs-12 fw-bold">Tickets</span>
                                            <h3 class="mb-0"><?= $dashboardController->getTotalNumberOfTickets() ?></h3>
                                        </div>
                                        <div class="align-self-center flex-shrink-0">
                                            <div id="today-revenue-chart" class="apex-charts"></div>
                                            <span class="text-success fw-bold fs-13">
                                                <i class='uil uil-arrow-up'></i> 100%
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted text-uppercase fs-12 fw-bold">Resolvidos</span>
                                            <h3 class="mb-0"><?= $dashboardController->getTicketsResolved() ?></h3>
                                        </div>
                                        <div class="align-self-center flex-shrink-0">
                                            <div id="today-new-customer-chart" class="apex-charts"></div>
                                            <span class="text-success fw-bold fs-13">
                                                <i class='uil uil-arrow-up'></i> <?= $dashboardController->getTicketsResolvedPercentage() ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted text-uppercase fs-12 fw-bold">Pausado</span>
                                            <h3 class="mb-0"><?= $dashboardController->getTicketsPaused() ?></h3>
                                        </div>
                                        <div class="align-self-center flex-shrink-0">
                                            <div id="today-new-visitors-chart" class="apex-charts"></div>
                                            <span class="text-danger fw-bold fs-13">
                                                <i class='uil uil-arrow-down'></i> <?= $dashboardController->getTicketsPausedPercentage() ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <span class="text-muted text-uppercase fs-12 fw-bold">Fechados</span>
                                            <h3 class="mb-0"><?= $dashboardController->getTicketsClosed() ?></h3>
                                        </div>
                                        <div class="align-self-center flex-shrink-0">
                                            <div id="today-product-sold-chart" class="apex-charts"></div>
                                            <span class="text-danger fw-bold fs-13">
                                                <i class='uil uil-arrow-down'></i> <?= $dashboardController->getTicketsClosedPercentage() ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- stats + charts -->
                    <div class="row">
                        <!-- Overview stats -->
                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="p-3">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="mdi mdi-dots-vertical fs-4"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-refresh me-2"></i>Refresh
                                                </a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-user-plus me-2"></i>Add New
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                    <i class="uil uil-exit me-2"></i>Exit
                                                </a>
                                            </div>
                                        </div>

                                        <h5 class="card-title header-title mb-0">Visão Geral</h5>
                                    </div>

                                    <!-- Total Tickets -->
                                    <div class="d-flex p-3 border-bottom">
                                        <div class="flex-grow-1">
                                            <h4 class="mt-0 mb-1 fs-22"><?= $dashboardController->getTotalNumberOfTickets() ?></h4>
                                            <span class="text-muted">Total Tickets</span>
                                        </div>
                                        <!-- <i data-feather="users" class="align-self-center icon-dual icon-md"></i> -->
                                        <span class="mdi mdi-ticket-confirmation fs-1"></span>
                                    </div>

                                    <!-- Total Lojas -->
                                    <div class="d-flex p-3 border-bottom">
                                        <div class="flex-grow-1">
                                            <h4 class="mt-0 mb-1 fs-22"><?= $dashboardController->getTotalStores() ?></h4>
                                            <span class="text-muted">Total Lojas</span>
                                        </div>
                                        <!-- <i data-feather="image" class="align-self-center icon-dual icon-md"></i> -->
                                        <span class="mdi mdi-store fs-1"></span>
                                    </div>

                                    <!-- Relatores -->
                                    <div class="d-flex p-3 border-bottom">
                                        <div class="flex-grow-1">
                                            <h4 class="mt-0 mb-1 fs-22"><?= $dashboardController->getTotalReporters() ?></h4>
                                            <span class="text-muted">Relatores</span>
                                        </div>
                                        <!-- <i data-feather="shopping-bag" class="align-self-center icon-dual icon-md"></i> -->
                                        <span class="mdi mdi-account-group fs-1"></span>
                                    </div>

                                    <a href="" class="p-2 d-block text-end d-flex justify-content-end align-items-center text-primary">
                                        Ver mais <span class="mdi mdi-arrow-right ms-1 fs-5"></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tickets during the period -->
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="mdi mdi-dots-vertical fs-4"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Hoje</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Últimos 7 Dias</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Últimos 15 Dias</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0);" class="dropdown-item">Último Mês</a>
                                            <a href="javascript:void(0);" class="dropdown-item">Últimos 6 Mês</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:void(0);" class="dropdown-item active">Último Ano</a>
                                        </div>
                                    </div>
                                    <h5 class="card-title mb-0 header-title">Volume de Tickets</h5>

                                    <div id="revenue-chart" class="apex-charts mt-3" dir="ltr"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <i class="uil uil-refresh me-2"></i>Refresh
                                            </a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <i class="uil uil-user-plus me-2"></i>Add New
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                <i class="uil uil-exit me-2"></i>Exit
                                            </a>
                                        </div>
                                    </div>

                                    <h5 class="card-title header-title">Targets</h5>
                                    <div id="targets-chart" class="apex-charts mt-3" dir="ltr"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- products -->
                    <div class="row">
                        <div class="col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <i class="uil uil-refresh me-2"></i>Refresh
                                            </a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <i class="uil uil-user-plus me-2"></i>Add New
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                <i class="uil uil-exit me-2"></i>Exit
                                            </a>
                                        </div>
                                    </div>
                                    <h5 class="card-title mt-0 mb-0 header-title">Sales By Category</h5>
                                    <div id="sales-by-category-chart" class="apex-charts mb-0 mt-4" dir="ltr"></div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div>
                        
                        <div class="col-xl-7">
                            <div class="card">
                                <div class="card-body">
                                    <a href="" class="btn btn-primary btn-sm float-end">
                                        <i class='uil uil-export me-1'></i> Export
                                    </a>
                                    <h5 class="card-title mt-0 mb-0 header-title">Recent Orders</h5>

                                    <div class="table-responsive mt-4">
                                        <table class="table table-hover table-nowrap mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#98754</td>
                                                    <td>ASOS Ridley High</td>
                                                    <td>Otto B</td>
                                                    <td>$79.49</td>
                                                    <td><span class="badge badge-soft-warning py-1">Pending</span></td>
                                                </tr>
                                                <tr>
                                                    <td>#98753</td>
                                                    <td>Marco Lightweight Shirt</td>
                                                    <td>Mark P</td>
                                                    <td>$125.49</td>
                                                    <td><span class="badge badge-soft-success py-1">Delivered</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#98752</td>
                                                    <td>Half Sleeve Shirt</td>
                                                    <td>Dave B</td>
                                                    <td>$35.49</td>
                                                    <td><span class="badge badge-soft-danger py-1">Declined</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#98751</td>
                                                    <td>Lightweight Jacket</td>
                                                    <td>Shreyu N</td>
                                                    <td>$49.49</td>
                                                    <td><span class="badge badge-soft-success py-1">Delivered</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>#98750</td>
                                                    <td>Marco Shoes</td>
                                                    <td>Rik N</td>
                                                    <td>$69.49</td>
                                                    <td><span class="badge badge-soft-danger py-1">Declined</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- end table-responsive-->
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>

                    <!-- widgets -->
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="header-title mb-3">Top Performers</h6>
                                    <div class="d-flex border-top pt-2">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-7.jpg" class="avatar rounded me-3" alt="shreyu">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-1 mb-0 fs-15">Shreyu N</h5>
                                            <h6 class="text-muted fw-normal mt-1 mb-2">Senior Sales Guy</h6>
                                        </div>
                                        <div class="dropdown align-self-center float-end">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-edit-alt me-2"></i>Edit
                                                </a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-exit me-2"></i>Remove from Team
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                    <i class="uil uil-trash me-2"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-1 border-top pt-2">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-9.jpg" class="avatar rounded me-3" alt="shreyu">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-1 mb-0 fs-15">Greeva Y</h5>
                                            <h6 class="text-muted fw-normal mt-1 mb-2">Social Media Campaign</h6>
                                        </div>
                                        <div class="dropdown align-self-center float-end">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-edit-alt me-2"></i>Edit
                                                </a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-exit me-2"></i>Remove from Team
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                    <i class="uil uil-trash me-2"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-1 border-top pt-2">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-4.jpg" class="avatar rounded me-3" alt="shreyu">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-1 mb-0 fs-15">Nik G</h5>
                                            <h6 class="text-muted fw-normal mt-1 mb-2">Inventory Manager</h6>
                                        </div>
                                        <div class="dropdown align-self-center float-end">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-edit-alt me-2"></i>Edit
                                                </a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-exit me-2"></i>Remove from Team
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                    <i class="uil uil-trash me-2"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex mt-1 border-top pt-2">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-1.jpg" class="avatar rounded me-3" alt="shreyu">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-1 mb-0 fs-15">Hardik G</h5>
                                            <h6 class="text-muted fw-normal mt-1 mb-2">Sales Person</h6>
                                        </div>
                                        <div class="dropdown align-self-center float-end">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-edit-alt me-2"></i>Edit
                                                </a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-exit me-2"></i>Remove from Team
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                    <i class="uil uil-trash me-2"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-1 border-top pt-2">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-8.jpg" class="avatar rounded me-3" alt="shreyu">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-1 mb-0 fs-15">GB Patel G</h5>
                                            <h6 class="text-muted fw-normal mt-1 mb-2">Sales Person</h6>
                                        </div>
                                        <div class="dropdown align-self-center float-end">
                                            <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-edit-alt me-2"></i>Edit
                                                </a>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item">
                                                    <i class="uil uil-exit me-2"></i>Remove from Team
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <!-- item-->
                                                <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                    <i class="uil uil-trash me-2"></i>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <a href="task-list.html" class="btn btn-primary btn-sm float-end">
                                        View All
                                    </a>
                                    <h5 class="mb-4 header-title">Tasks</h5>
                                    <div data-simplebar class="px-1" style="max-height: 352px;">
                                        <div>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task1">
                                                <label class="form-check-label" for="task1">
                                                    Draft the new contract document for sales team
                                                </label>
                                                <p class="fs-13 text-muted">Due on 24 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task2">
                                                <label class="form-check-label" for="task2">
                                                    iOS App home page
                                                </label>
                                                <p class="fs-13 text-muted">Due on 23 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task3">
                                                <label class="form-check-label" for="task3">
                                                    Write a release note for Shreyu
                                                </label>
                                                <p class="fs-13 text-muted">Due on 22 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task4">
                                                <label class="form-check-label" for="task4">
                                                    Invite Greeva to a project shreyu admin
                                                </label>
                                                <p class="fs-13 text-muted">Due on 21 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task5">
                                                <label class="form-check-label" for="task5">
                                                    Enable analytics tracking for main website
                                                </label>
                                                <p class="fs-13 text-muted">Due on 20 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task6">
                                                <label class="form-check-label" for="task6">
                                                    Invite user to a project
                                                </label>
                                                <p class="fs-13 text-muted">Due on 18 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>

                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="task7">
                                                <label class="form-check-label" for="task7">
                                                    Write a release note
                                                </label>
                                                <p class="fs-13 text-muted">Due on 14 Aug, 2019</p>
                                            </div> <!-- end checkbox -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <i class="uil uil-refresh me-2"></i>Refresh
                                            </a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">
                                                <i class="uil uil-user-plus me-2"></i>Add New
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item text-danger">
                                                <i class="uil uil-exit me-2"></i>Exit
                                            </a>
                                        </div>
                                    </div>
                                    <h4 class="header-title mb-4">Recent Conversation</h4>

                                    <div class="chat-conversation">
                                        <div data-simplebar style="height: 314px;">
                                            <ul class="conversation-list">
                                                <li class="clearfix">
                                                    <div class="chat-avatar">
                                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-5.jpg" alt="male">
                                                        <i>10:00</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>Geneva</i>
                                                            <p>Hello!</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="clearfix odd">
                                                    <div class="chat-avatar">
                                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-1.jpg" alt="Female">
                                                        <i>10:01</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>Dominic</i>
                                                            <p>Hi, How are you? What about our next meeting?</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="clearfix">
                                                    <div class="chat-avatar">
                                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-5.jpg" alt="male">
                                                        <i>10:01</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>Geneva</i>
                                                            <p>Yeah everything is fine</p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="clearfix odd">
                                                    <div class="chat-avatar">
                                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-1.jpg" alt="male">
                                                        <i>10:02</i>
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <i>Dominic</i>
                                                            <p>Wow that's great</p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <form class="needs-validation" novalidate name="chat-form" id="chat-form">
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" class="form-control chat-input" placeholder="Enter your text" required>
                                                    <div class="invalid-feedback">
                                                        Please enter your messsage
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <button type="submit" class="btn btn-danger chat-send w-100 waves-effect waves-light">Send</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div> <!-- end .chat-conversation-->
                                </div>
                            </div> <!-- end card-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Settings -->
    <?php include_once(__DIR__ . '/components/sidebar-settings.php'); ?>

    <!-- jQuery CDN -->
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

    <?= $dashboardController->getJsExternal(); ?>

    <!-- optional plugins -->
    <script src="<?php echo getUrlFull('assets/libs/moment/min/moment.min.js'); ?>" defer></script>
    <script src="<?php echo getUrlFull('assets/libs/apexcharts/apexcharts.min.js'); ?>" defer></script>
    <script src="<?php echo getUrlFull('assets/libs/flatpickr/flatpickr.min.js'); ?>" defer></script>

    <!-- page js - MUST come after jQuery and moment -->
    <script src="<?php echo getUrlFull('assets/js/pages/dashboard.init.js'); ?>" defer></script>

    <!-- App js -->
    <script src="<?php echo getUrlFull('assets/js/app.js'); ?>" defer></script>
</body>
</html>