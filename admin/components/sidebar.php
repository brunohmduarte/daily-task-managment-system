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
                    <a href="reporters.php">
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