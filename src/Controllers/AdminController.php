<?php

namespace Application\Controllers;

class AdminController extends Controller
{
    /**
     * Initializes the admin controller.
     *
     * This function sets the custom CSS and JavaScript files for the admin panel.
     * It is called automatically when the admin controller is instantiated.
     */
    public function init(): void
    {
        // $this->setCssExternal('assets/css/admin-custom.css');
        // $this->setJsExternal('assets/js/admin-custom.js');
    }

    /**
     * This function is responsible for handling the routes of the admin panel.
     * It checks if a route is specified in the URL and if so, it requires the corresponding PHP file.
     * If the route is not specified, it requires the dashboard.php file by default.
     * If the route is specified but the file does not exist, it requires the 404.php file.
     *
     * Example routes:
     * - https://daily.dvl.to/admin/index.php
     * - https://daily.dvl.to/admin/index.php?route=dashboard
     * - https://daily.dvl.to/admin/index.php?route=stores&action=list
     * - https://daily.dvl.to/admin/index.php?route=stores&action=create
     * - https://daily.dvl.to/admin/index.php?route=stores&action=edit&id=1
     * - https://daily.dvl.to/admin/index.php?route=stores&action=delete&id=1
     */
    public function routes(): void
    {
        $fileDashboard = dirname(__DIR__, 2). '/admin/dashboard.php';
        if (!empty($_GET['route'])) {
            $file = dirname(__DIR__, 2). '/admin/'.$_GET['route'].'.php';
            if (file_exists($file)) {
                require_once $file;
            } else {
                require_once dirname(__DIR__, 2). '/admin/404.php';
            }
        }

        require_once $fileDashboard;
    }
}