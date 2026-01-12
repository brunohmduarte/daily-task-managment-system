<?php
/**
 * API Router para Dashboard
 * 
 * Uso (jQuery/AJAX):
 * $.get('admin/api/dashboard.php?action=getTicketStatsJson', function(response) {
 *     console.log(response.data);
 * });
 * 
 * Ou com parâmetros:
 * $.get('admin/api/dashboard.php?action=getTicketById&id=123', function(response) {
 *     console.log(response.data);
 * });
 */

// session_start();

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use Application\Core\Router;
use Application\Controllers\DashboardController;
use Application\Controllers\ReportersController;
use Application\Middleware\AuthMiddleware;

// Verificar autenticação
AuthMiddleware::checkAccess();

// Rotas para o Dashboard
$dashboardController = new DashboardController();
Router::on('getAllTimeStatistics', [$dashboardController, 'getAllTimeStatistics']);

// Rotas para Reporters
$reportersController = new ReportersController();
Router::on('createReporter', [$reportersController, 'create']);
Router::on('updateReporter', [$reportersController, 'update']);
Router::on('deleteReporter', [$reportersController, 'delete']);
Router::on('listTicketReporters', [$reportersController, 'read']);


// Você pode adicionar mais ações assim:
// Router::on('getTicketById', [$dashboardController, 'getTicketById']);
// Router::on('createTicket', [$dashboardController, 'createTicket']);
// Router::on('updateTicket', [$dashboardController, 'updateTicket']);
// Router::on('deleteTicket', [$dashboardController, 'deleteTicket']);

// Disparar a rota
Router::dispatch();