<div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas" style="width: 260px;">
    <div class="px-3 m-0 py-2 text-uppercase bg-light offcanvas-header">
        <h6 class="fw-medium d-block mb-0">Configurações</h6>
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

        <!-- Width -->
        <h6 class="fw-medium mt-4 mb-2 pb-1">Width</h6>
        <div class="form-switch d-flex align-items-center gap-1 mb-1">
            <input type="checkbox" class="form-check-input mt-0" name="layout-width" value="fluid" id="fluid-check" checked />
            <label class="form-check-label" for="fluid-check">Fluid</label>
        </div>
        <div class="form-switch d-flex align-items-center gap-1 mb-1">
            <input type="checkbox" class="form-check-input mt-0" name="layout-width" value="boxed" id="boxed-check" />
            <label class="form-check-label" for="boxed-check">Boxed</label>
        </div>

        <!-- Menu positions -->
        <h6 class="fw-medium mt-4 mb-2 pb-1">Menu Position</h6>

        <div class="form-switch d-flex align-items-center gap-1 mb-1">
            <input type="checkbox" class="form-check-input mt-0" name="menu-position" value="fixed" id="fixed-check" checked />
            <label class="form-check-label" for="fixed-check">Fixed</label>
        </div>

        <div class="form-switch d-flex align-items-center gap-1 mb-1">
            <input type="checkbox" class="form-check-input mt-0" name="menu-position" value="scrollable" id="scrollable-check" />
            <label class="form-check-label" for="scrollable-check">Scrollable</label>
        </div>

        <!-- Left Sidebar-->
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

        <!-- size -->
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

        <!-- User info -->
        <div id="sidebarUser">
            <h6 class="fw-medium mt-4 mb-2 pb-1">Sidebar User Info</h6>

            <div class="form-switch d-flex align-items-center gap-1 mb-1">
                <input type="checkbox" class="form-check-input mt-0" name="leftsidebar-user" value="fixed" id="sidebaruser-check" />
                <label class="form-check-label" for="sidebaruser-check">Enable</label>
            </div>
        </div>

        <!-- Topbar -->
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