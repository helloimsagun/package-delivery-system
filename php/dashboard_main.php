<?php
$currentPage = basename($_SERVER['PHP_SELF'], ".php");

if ($userType == 1) {
    echo '<title>User Dashboard</title>';
} elseif ($userType == 2) {
    echo '<title>Admin Dashboard</title>';
} elseif ($userType == 3) {
    echo '<title>Delivery Personnel Dashboard</title>';
} else {
    // Invalid user type
    echo "Invalid User Type";
    exit();
}
?>


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <li>
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                    <div class="sidebar-brand-icon">
                        <img src="images/logo.svg" alt="Logo" width="60vw">

                    </div>
                    <div class="sidebar-brand-text mx-3">SwiftStreams Pvt Ltd</div>
                </a>
            </li>
            <!-- Divider -->
            <li class="sidebar-divider my-0">
                <hr>
            </li>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="sidebar-divider">
                <hr>
            </li>
            <?php if ($userType != 3) : ?>
                <!-- Heading -->
                <li class="sidebar-heading">
                    Packages
                </li>

                <!-- Nav Item - Package Records -->
                <?php if ($userType == 1) : ?>
                    <li class="nav-item <?php echo ($currentPage === 'user_package_records') ? 'active' : ''; ?>">
                        <a class="nav-link" href="user_package_records.php">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Package Records</span>
                        </a>

                    </li>
                <?php endif; ?>
                <?php if ($userType == 2) : ?>
                    <li class="nav-item <?php echo ($currentPage === 'admin_package_records') ? 'active' : ''; ?>">
                        <a class="nav-link" href="admin_package_records.php">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Package Records</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($userType == 2) : ?>
                <!-- Divider -->
                <li class="sidebar-divider">
                    <hr>
                </li>

                <!-- Heading -->
                <li class="sidebar-heading">
                    Admin Options
                </li>

                <!-- Nav Item - Registered Users -->
                <li class="nav-item <?php echo ($currentPage === 'registered_users') ? 'active' : ''; ?>">
                    <a class="nav-link" href="registered_users.php">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Registered Users</span>
                    </a>
                </li>

                <!-- Nav Item - Delivery Personnel -->
                <li class="nav-item <?php echo ($currentPage === 'delivery_personnel') ? 'active' : ''; ?>">
                    <a class="nav-link" href="delivery_personnel.php">
                        <i class="fas fa-fw fa-truck"></i>
                        <span>Delivery Personnel</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($userType == 3) : ?>
                <!-- Heading -->
                <li class="sidebar-heading">
                    Packages
                </li>

                <!-- Nav Item - Waiting for Pickup -->
                <li class="nav-item <?php echo ($currentPage === 'delivery_personnel_pickup') ? 'active' : ''; ?>">
                    <a class="nav-link" href="delivery_personnel_pickup.php">
                        <i class="fas fa-fw fa-clock"></i>
                        <span>Waiting for Pickup</span>
                    </a>
                </li>
                <!-- Nav Item - In Transit -->
                <li class="nav-item <?php echo ($currentPage === 'delivery_personnel_transit') ? 'active' : ''; ?>">
                    <a class="nav-link" href="delivery_personnel_transit.php">
                        <i class="fas fa-fw fa-clock"></i>
                        <span>In Transit</span>
                    </a>
                </li>

                <!-- Nav Item - Delivered -->
                <li class="nav-item  <?php echo ($currentPage === 'delivery_personnel_delivered') ? 'active' : ''; ?>">
                    <a class="nav-link" href="delivery_personnel_delivered.php">
                        <i class="fas fa-fw fa-check"></i>
                        <span>Delivered</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Divider -->
            <li class="sidebar-divider d-none d-md-block">
                <hr>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <li class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle" title="Toggle Sidebar">
                    <!-- Add a visually hidden text for screen readers -->
                    <span class="sr-only">Toggle Sidebar</span>
                </button>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $user['name']; ?>
                                </span>
                                <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#settingModal">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">



                    <!-- Code depending upon user -->
                    <!-- If $currentPage is dashboard show the content of dashboard_content.php -->

                    <?php
                    if ($currentPage === 'dashboard') :
                        echo '<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>';
                        include 'dashboard_content.php';
                    endif;
                    ?>

                    <!-- If $currentPage is user_package_records show the content of user_package_records_content.php -->

                    <?php
                    if ($currentPage === 'user_package_records') :
                        include 'user_package_records_content.php';
                    endif;
                    ?>

                    <!-- If $currentPage is admin_package_records show the content of admin_package_records_content.php -->

                    <?php
                    if ($currentPage === 'admin_package_records') :
                        include 'admin_package_records_content.php';
                    endif;
                    ?>

                    <!-- If $currentPage is registered_users show the content of admin_registered_users.php -->

                    <?php
                    if ($currentPage === 'registered_users') :
                        echo '<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Registered Users</h1>
                    </div>';
                        include 'admin_registered_users.php';
                    endif;
                    ?>

                    <!-- If $currentPage is delivery_personnel show the content of admin_delivery_personnel.php -->

                    <?php
                    if ($currentPage === 'delivery_personnel') :
                        echo '<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Delivery Riders</h1>
                    </div>';
                        include 'admin_delivery_personnel.php';
                    endif;
                    ?>

                    <!-- If $currentPage is delivery_personnel_pickup show the content of delivery_personnel_pickup_content.php -->

                    <?php
                    if ($currentPage === 'delivery_personnel_pickup') :
                        echo '<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Packages To Be Picked Up</h1>
                    </div>';
                        include 'delivery_personnel_pickup_content.php';
                    endif;
                    ?>

                    <!-- If $currentPage is delivery_personnel_transit show the content of delivery_personnel_transit_content.php -->

                    <?php
                    if ($currentPage === 'delivery_personnel_transit') :
                        echo '<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Packages in Transit</h1>
                    </div>';
                        include 'delivery_personnel_transit_content.php';
                    endif;
                    ?>

                    <!-- If $currentPage is delivery_personnel_delivered show the content of delivery_personnel_delivered_content.php -->

                    <?php
                    if ($currentPage === 'delivery_personnel_delivered') :
                        echo '<!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Delivered Packages</h1>
                    </div>';
                        include 'delivery_personnel_delivered_content.php';
                    endif;
                    ?>


                    <!-- End of Content Row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="text-center my-auto">
                        <span>Copyright &copy;
                            <?php echo date('Y'); ?> SwiftStreams Pvt. Ltd - All rights reserved

                        </span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>