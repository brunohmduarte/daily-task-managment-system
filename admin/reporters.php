<?php
    require_once dirname(__FILE__, 2) . '/vendor/autoload.php';

    use Application\Core\Factory;
    use Application\Controllers\ReportersController;

    /** @var ReportersController $reportersController */
    $reportersController = Factory::create(ReportersController::class);
    $reportersController->init();

?>
<h1>Página de Relatores</h1>