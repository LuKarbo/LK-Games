<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Menu publico -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/Proyecto_2/LK-Games/public/index.php">
        <div class="sidebar-brand-icon">
            <i class="fas fa-dragon"></i>
        </div>
        <div class="sidebar-brand-text mx-3">LK Games</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="/Proyecto_2/LK-Games/public/index.php">
            <i class="fas fa-dice"></i>
            <span>Juegos</span>
        </a>
    </li>

    <?php if ($_SESSION['userPermissionsLVL'] == 3) : ?>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            BackOffice Access
        </div>
        <li class="nav-item">
            <a class="nav-link" href="/Proyecto_2/LK-Games/public/BackOffice/Admin/adminMenu.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Admin Menu</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/Proyecto_2/LK-Games/public/BackOffice/Admin/userAdminMenu.php">
                <i class="fas fa-fw fa-user-friends"></i>
                <span>User Admin Menu</span>
            </a>
        </li>
    <?php endif ?>
    <div style="flex-grow: 1;"></div>

</ul>