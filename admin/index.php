<?php
    require_once dirname(__DIR__) . '/vendor/autoload.php';
    
    use Application\Middleware\AuthMiddleware;
    use Application\Controllers\AdminController;
    use Application\Core\Factory;


    AuthMiddleware::checkAccess();

    /** @var AdminController $adminController */
    $adminController = Factory::create(AdminController::class);
    // $adminController->init();
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

    <?php if (!isset($_GET['action'])): ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https//cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">
    <?php endif; ?>

    <!-- App CSS -->
    <link href="<?php echo getUrlFull('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- Config js -->
    <script src="<?php echo getUrlFull('assets/js/config.js'); ?>"></script>
</head>
<body>
    <div id="wrapper">
        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-end mb-0">
                    <li class="d-none d-lg-block">
                        <form class="app-search">
                            <div class="app-search-box dropdown">
                                <div class="input-group">
                                    <input type="search" class="form-control" placeholder="Search..." id="top-search">
                                    <button class="btn input-group-text" type="submit">
                                        <i class="uil uil-search"></i>
                                    </button>
                                </div>

                                <div class="dropdown-menu dropdown-lg" id="search-dropdown">
                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h5 class="text-overflow mb-2">Found 05 results</h5>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="uil uil-sliders-v-alt me-1"></i>
                                        <span>User profile settings</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="uil uil-home-alt me-1"></i>
                                        <span>Analytics Report</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="uil uil-life-ring me-1"></i>
                                        <span>How can I help you?</span>
                                    </a>

                                    <!-- item-->
                                    <div class="dropdown-header noti-title">
                                        <h6 class="text-overflow mb-2 text-uppercase">Users</h6>
                                    </div>

                                    <div class="notification-list">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="d-flex text-align-start">
                                                <img class="me-2 rounded-circle" src="https://coderthemes.com/shreyu/assets/images/users/avatar-2.jpg" alt="Generic placeholder image" height="32">
                                                <div class="flex-grow-1">
                                                    <h5 class="m-0 fs-14">Shirley Miller</h5>
                                                    <span class="fs-12 mb-0">UI Designer</span>
                                                </div>
                                            </div>
                                        </a>

                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                                            <div class="d-flex text-align-start">
                                                <img class="me-2 rounded-circle" src="https://coderthemes.com/shreyu/assets/images/users/avatar-5.jpg" alt="Generic placeholder image" height="32">
                                                <div class="flex-grow-1">
                                                    <h5 class="m-0 fs-14">Timothy Moreno</h5>
                                                    <span class="fs-12 mb-0">Frontend Developer</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </li>

                    <li class="dropdown d-inline-block d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i data-feather="search"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                            <form class="p-3">
                                <input type="text" class="form-control" placeholder="Search ..." aria-label="search here">
                            </form>
                        </div>
                    </li>

                    <li class="d-none d-lg-inline-block">
                        <a class="nav-link"  id="light-dark-mode" href="#">
                            <i data-feather="sun" class="light-mode"></i>
                            <i data-feather="moon" class="dark-mode"></i>
                        </a>
                    </li>

                    <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none" data-toggle="fullscreen" href="#">
                            <i data-feather="maximize"></i>
                        </a>
                    </li>

                    <!--
                    <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i data-feather="grid"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
                            <div class="p-1">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="https://coderthemes.com/shreyu/assets/images/brands/slack.png" alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="https://coderthemes.com/shreyu/assets/images/brands/github.png" alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="https://coderthemes.com/shreyu/assets/images/brands/dribbble.png" alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    -->

                    <!--
                    <li class="dropdown d-none d-lg-inline-block topbar-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i data-feather="globe"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="https://coderthemes.com/shreyu/assets/images/flags/us.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">English</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="https://coderthemes.com/shreyu/assets/images/flags/germany.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">German</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="https://coderthemes.com/shreyu/assets/images/flags/italy.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Italian</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="https://coderthemes.com/shreyu/assets/images/flags/spain.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Spanish</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="https://coderthemes.com/shreyu/assets/images/flags/russia.jpg" alt="user-image" class="me-1" height="12">
                                <span class="align-middle">Russian</span>
                            </a>
                        </div>
                    </li>
                    -->

                    <!-- Notification -->
                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle position-relative" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i data-feather="bell"></i>
                            <span class="badge bg-danger rounded-circle noti-icon-badge">6</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-lg">
                            <div class="dropdown-item noti-title">
                                <h5 class="m-0">
                                    <span class="float-end">
                                        <a href="" class="text-dark"><small>Clear All</small></a>
                                    </span>Notification
                                </h5>
                            </div>

                            <div class="noti-scroll" data-simplebar>
                                <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                    <div class="notify-icon bg-primary"><i class="uil uil-user-plus"></i></div>
                                    <p class="notify-details">New user registered.<small class="text-muted">5 hours ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                    <div class="notify-icon">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-1.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <p class="notify-details">Karen Robinson</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Wow ! this admin looks good and awesome design</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                    <div class="notify-icon">
                                        <img src="https://coderthemes.com/shreyu/assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle" alt="" />
                                    </div>
                                    <p class="notify-details">Cristina Pride</p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Hi, How are you? What about our next meeting</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom active">
                                    <div class="notify-icon bg-success"><i class="uil uil-comment-message"></i> </div>
                                    <p class="notify-details">
                                        Jaclyn Brunswick commented on Dashboard<small class="text-muted">1 min ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item border-bottom">
                                    <div class="notify-icon bg-danger"><i class="uil uil-comment-message"></i></div>
                                    <p class="notify-details">
                                        Caleb Flakelar commented on Admin<small class="text-muted">4 days ago</small>
                                    </p>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="notify-icon bg-primary">
                                        <i class="uil uil-heart"></i>
                                    </div>
                                    <p class="notify-details">
                                        Carlos Crouch liked <b>Admin</b> <small class="text-muted">13 days ago</small>
                                    </p>
                                </a>
                            </div>

                            <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                View all <i class="fe-arrow-right"></i>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?php echo getUrlFull('assets/images/bruno-duarte.png'); ?>" alt="user-image" class="rounded-circle">
                            <span class="pro-user-name d-sm-inline d-none ms-1">
                                Bruno Duarte <i class="uil uil-angle-down"></i>
                            </span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end profile-dropdown">                            
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Bem-vindo!</h6>
                            </div>

                            <a href="pages-profile.html" class="dropdown-item notify-item">
                                <i data-feather="user" class="icon-dual icon-xs me-1"></i>
                                <span>Minha Conta</span>
                            </a>

                            <!--
                            <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                                <i data-feather="lock" class="icon-dual icon-xs me-1"></i>
                                <span>Lock Screen</span>
                            </a>
                            -->

                            <div class="dropdown-divider"></div>

                            <a href="logout.php" class="dropdown-item notify-item">
                                <i data-feather="log-out" class="icon-dual icon-xs me-1"></i>
                                <span>Sair</span>
                            </a>
                        </div>
                    </li>

                    <!-- Settings -->
                    <li class="dropdown notification-list">
                        <button class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" type="button">
                            <i data-feather="settings"></i>
                        </button>
                    </li>
                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="https://coderthemes.com/shreyu/assets/images/logo-sm.png" alt="" height="24">
                        </span>
                        <span class="logo-lg">
                            <img src="https://coderthemes.com/shreyu/assets/images/logo-dark.png" alt="" height="24">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="https://coderthemes.com/shreyu/assets/images/logo-sm.png" alt="" height="24">
                        </span>
                        <span class="logo-lg">
                            <img src="https://coderthemes.com/shreyu/assets/images/logo-light.png" alt="" height="24">
                        </span>
                    </a>
                </div>

                <!-- Menu Mobile -->
                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile">
                            <i data-feather="menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                    </li>
                    <!--
                    <li class="dropdown d-none d-xl-block">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            Create New
                            <i class="uil uil-angle-down"></i>
                        </a>
                        <div class="dropdown-menu">
                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="uil uil-bag me-1"></i><span>New Projects</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="uil uil-user-plus me-1"></i><span>Create Users</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="uil uil-chart-pie me-1"></i><span>Revenue Report</span>
                            </a>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="uil uil-cog me-1"></i><span>Settings</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <a href="javascript:void(0);" class="dropdown-item">
                                <i class="uil uil-question-circle me-1"></i><span>Help & Support</span>
                            </a>
                        </div>
                    </li>
                    -->
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>

        <!-- Left Sidebar End -->
        <div class="left-side-menu">
            <div class="h-100" data-simplebar>
                <!-- User box -->
                <div class="user-box text-center">
                    <img src="<?php echo getUrlFull('assets/images/bruno-duarte.png'); ?>" alt="user-img" title="Mat Helme" class="rounded-circle avatar-md">
                    <div class="dropdown">
                        <a href="javascript: void(0);" class="dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown">Bruno Duarte</a>
                        <div class="dropdown-menu user-pro-dropdown">
                            <a href="pages-profile.html" class="dropdown-item notify-item">
                                <i data-feather="user" class="icon-dual icon-xs me-1"></i><span>My Account</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i data-feather="settings" class="icon-dual icon-xs me-1"></i><span>Settings</span>
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i data-feather="help-circle" class="icon-dual icon-xs me-1"></i><span>Support</span>
                            </a>
                            <a href="pages-lock-screen.html" class="dropdown-item notify-item">
                                <i data-feather="lock" class="icon-dual icon-xs me-1"></i><span>Lock Screen</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i data-feather="log-out" class="icon-dual icon-xs me-1"></i><span>Sair</span>
                            </a>
                        </div>
                    </div>
                    <p>Admin Head</p>
                </div>

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul class="side-menu">
                        <li>
                            <a href="index.php" data-bs-toggle="collapse">
                                <span class="mdi mdi-home fs-4"></span>
                                <span>Dashboards</span>
                            </a>
                        </li>
                        
                        <li class="menu-title mt-2 fw-semibold">Tickets</li>
                        <li>
                            <a href="tickets.php" data-bs-toggle="collapse">
                                <span class="mdi mdi-ticket-confirmation"></span>
                                <span>Tickets</span>
                            </a>
                        </li>

                        <li class="menu-title mt-2 fw-semibold">Lojas</li>
                        <li>
                            <a href="stores.php">
                                <span class="mdi mdi-store fs-4"></span>
                                <span>Lojas</span>
                            </a>
                        </li>
                        <li>
                            <a href="storeuninstall.php">
                                <span class="mdi mdi-store-remove fs-4"></span>
                                <span>Desinstalar</span>
                            </a>
                        </li>

                        <li class="menu-title mt-2 fw-semibold">Módulos</li>
                        <li>
                            <a href="magentoone.php">
                                <span class="mdi mdi-package-up fs-4"></span>
                                <span>Magento 1</span>
                            </a>
                        </li>
                        <li>
                            <a href="magentotwo.php">
                                <span class="mdi mdi-package-up fs-4"></span>
                                <span>Magento 2</span>
                            </a>
                        </li>

                        <li class="menu-title mt-2 fw-semibold">Relatores</li>
                        <li>
                            <a href="index.php?route=reporters">
                                <span class="mdi mdi-account-arrow-up fs-4"></span>
                                <span>Relatores</span>
                            </a>
                        </li>

                        <!--
                        <li>
                            <a href="#sidebarMultilevel" data-bs-toggle="collapse">
                                <i data-feather="share-2"></i>
                                <span> Multi Level </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarMultilevel">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="#sidebarMultilevel2" data-bs-toggle="collapse">
                                            Second Level <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarMultilevel2">
                                            <ul class="nav-second-level">
                                                <li><a href="javascript: void(0);">Item 1</a></li>
                                                <li><a href="javascript: void(0);">Item 2</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                    <li>
                                        <a href="#sidebarMultilevel3" data-bs-toggle="collapse">
                                            Third Level <span class="menu-arrow"></span>
                                        </a>
                                        <div class="collapse" id="sidebarMultilevel3">
                                            <ul class="nav-second-level">
                                                <li><a href="javascript: void(0);">Item 1</a></li>
                                                <li>
                                                    <a href="#sidebarMultilevel4" data-bs-toggle="collapse">
                                                        Item 2 <span class="menu-arrow"></span>
                                                    </a>
                                                    <div class="collapse" id="sidebarMultilevel4">
                                                        <ul class="nav-second-level">
                                                            <li><a href="javascript: void(0);">Item 1</a></li>
                                                            <li><a href="javascript: void(0);">Item 2</a></li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        -->
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div><!-- Sidebar -left -->
        </div>

        <!-- Start Page Content here -->
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <?php $adminController->routes(); ?>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Theme Settings --
    <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas" style="width: 260px;">
        <div class="px-3 m-0 py-2 text-uppercase bg-light offcanvas-header">
            <h6 class="fw-medium d-block mb-0">Theme Settings</h6>
            <button type="button" class="btn-close fs-14" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body" data-simplebar style="height: calc(100% - 50px);">
            <div class="alert alert-warning" role="alert">
                <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
            </div>

            <h6 class="fw-medium mt-4 mb-2 pb-1">Color Scheme</h6>
            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="color-scheme-mode" value="light" id="light-mode-check" checked />
                <label class="form-check-label" for="light-mode-check">Light Mode</label>
            </div>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="color-scheme-mode" value="dark" id="dark-mode-check" />
                <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
            </div>

            <!-- Width --
            <h6 class="fw-medium mt-4 mb-2 pb-1">Width</h6>
            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="layout-width" value="fluid" id="fluid-check" checked />
                <label class="form-check-label" for="fluid-check">Fluid</label>
            </div>
            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="layout-width" value="boxed" id="boxed-check" />
                <label class="form-check-label" for="boxed-check">Boxed</label>
            </div>

            <!-- Menu positions --
            <h6 class="fw-medium mt-4 mb-2 pb-1">Menu Position</h6>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="menu-position" value="fixed" id="fixed-check" checked />
                <label class="form-check-label" for="fixed-check">Fixed</label>
            </div>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="menu-position" value="scrollable" id="scrollable-check" />
                <label class="form-check-label" for="scrollable-check">Scrollable</label>
            </div>

            <!-- Left Sidebar--
            <h6 class="fw-medium mt-4 mb-2 pb-1">Menu Color</h6>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="menu-color" value="light" id="light-check" checked />
                <label class="form-check-label" for="light-check">Light</label>
            </div>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="menu-color" value="dark" id="dark-check" />
                <label class="form-check-label" for="dark-check">Dark</label>
            </div>

            <!-- <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="menu-color" value="brand" id="brand-check" />
                <label class="form-check-label" for="brand-check">Brand</label>
            </div> --

            <!-- size --
            <div id="sidebarSize">
                <h6 class="fw-medium mt-4 mb-2 pb-1">Left Sidebar Size</h6>

                <div class="form-switch d-flex align-items-center gap-1 mb-1">
                    <input type="checkbox" class="form-check-input mt-0" name="leftsidebar-size" value="default" id="default-size-check" checked />
                    <label class="form-check-label" for="default-size-check">Default</label>
                </div>

                <div class="form-switch d-flex align-items-center gap-1 mb-1">
                    <input type="checkbox" class="form-check-input mt-0" name="leftsidebar-size" value="condensed" id="condensed-check" />
                    <label class="form-check-label" for="condensed-check">Condensed <small>(Extra Small size)</small></label>
                </div>

                <div class="form-switch d-flex align-items-center gap-1 mb-1">
                    <input type="checkbox" class="form-check-input mt-0" name="leftsidebar-size" value="compact" id="compact-check" />
                    <label class="form-check-label" for="compact-check">Compact <small>(Small size)</small></label>
                </div>
            </div>

            <!-- User info --
            <div id="sidebarUser">
                <h6 class="fw-medium mt-4 mb-2 pb-1">Sidebar User Info</h6>

                <div class="form-switch d-flex align-items-center gap-1 mb-1">
                    <input type="checkbox" class="form-check-input mt-0" name="leftsidebar-user" value="fixed" id="sidebaruser-check" />
                    <label class="form-check-label" for="sidebaruser-check">Enable</label>
                </div>
            </div>

            <!-- Topbar --
            <h6 class="fw-medium mt-4 mb-2 pb-1">Topbar</h6>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="topbar-color" value="dark" id="darktopbar-check" checked />
                <label class="form-check-label" for="darktopbar-check">Dark</label>
            </div>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="topbar-color" value="light" id="lighttopbar-check" />
                <label class="form-check-label" for="lighttopbar-check">Light</label>
            </div>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="topbar-color" value="brand" id="brandtopbar-check" />
                <label class="form-check-label" for="brandtopbar-check">Brand</label>
            </div>
        </div>

        <div class="d-flex flex-column gap-2 px-3 py-2 offcanvas-header border-top border-dashed">
            <button class="btn btn-primary w-100" id="resetBtn">Reset to Default</button>
            <a href="https://1.envato.market/shreyu_admin" class="btn btn-danger w-100" target="_blank">
                <i class="mdi mdi-basket me-1"></i> Purchase Now
            </a>
        </div>
    </div>
    -->

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

    <?php if (!isset($_GET['action'])): ?>
    <!-- DataTables JS -->
    <script src="https//cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>
    <?php endif; ?>

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