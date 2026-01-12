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
        <?php include_once(__DIR__ . '/views/components/header.php'); ?>

        <!-- Sidebar -->
        <?php include_once(__DIR__ . '/views/components/sidebar.php'); ?>

        <!-- Content -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                </div>
            </div>
        </div>
    </div>

    <!-- Theme Settings -->
    <?php include_once(__DIR__ . '/components/settings.php'); ?>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?= $dashboardController->getJsExternal(); ?>
    
    <!-- App js -->
    <script src="<?php echo getUrlFull('assets/js/app.js'); ?>" defer></script>
</body>
</html>