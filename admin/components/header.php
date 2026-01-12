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
            <a href="index.php" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="https://coderthemes.com/shreyu/assets/images/logo-sm.png" alt="" height="24">
                </span>
                <span class="logo-lg">
                    <img src="https://coderthemes.com/shreyu/assets/images/logo-dark.png" alt="" height="24">
                </span>
            </a>

            <a href="index.php" class="logo logo-light">
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
        </ul>

        <div class="clearfix"></div>
    </div>
</div>