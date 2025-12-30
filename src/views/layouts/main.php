<?php
$bus = $_SESSION['admin'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Dashboard' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>

<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div>
                <div class="logo">
                    <img src="/assets/images/logo.png" alt="Logo">
                    <p class="welcome">Welcome, <strong><?php echo $bus['busname'] ?></strong></p>
                </div>

                <nav class="nav">
                    <a href="/dashboard" class="<?= ($_SERVER['REQUEST_URI'] == '/dashboard' ? 'active' : '') ?>">
                        <i class="fa fa-chart-line"></i> Dashboard
                    </a>
                    <a href="/buses" class="<?= ($_SERVER['REQUEST_URI'] == '/buses' ? 'active' : '') ?>">
                        <i class="fa fa-bus"></i> Buses
                    </a>
                    <a href="/products" class="<?= ($_SERVER['REQUEST_URI'] == '/products' ? 'active' : '') ?>">
                        <i class="fa fa-box"></i> Products
                    </a>
                    <a href="/categories" class="<?= ($_SERVER['REQUEST_URI'] == '/categories' ? 'active' : '') ?>">
                        <i class="fa fa-tags"></i> Categories
                    </a>
                    <a href="/orders" class="<?= ($_SERVER['REQUEST_URI'] == '/orders' ? 'active' : '') ?>">
                        <i class="fa fa-shopping-cart"></i> Orders
                    </a>
                    <a href="/setting" class="<?= ($_SERVER['REQUEST_URI'] == '/setting' ? 'active' : '') ?>">
                        <i class="fa fa-cog"></i> Setting
                    </a>
                    <a href="/" class="<?= ($_SERVER['REQUEST_URI'] == '/' ? 'active' : '') ?>">
                        <i class="fa fa-home"></i> Home
                    </a>
                </nav>
            </div>

            <div class="logout">
                <a href="../../controllers/logout_account.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>

        <!-- Main Section -->
        <div class="main-section">
            <!-- Topbar -->
            <header class="topbar mt-3 d-flex justify-content-between align-items-center">
                <h2><?= $pageTitle ?? 'Dashboard' ?></h2>

                <div class="d-flex align-items-center gap-4 me-3">

                    <!-- Notification Bell -->
                    <div class="position-relative" style="cursor:pointer;">
                        <a href="/orders" class="text-dark text-decoration-none">
                            <i class="fa fa-bell fs-3"></i>
                        </a>

                        <?php
                        require_once __DIR__ . '/../../models/orderModel.php';
                        $notificationCount = getNotificationsCount();
                        if (($notificationCount ?? 0) > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle
                             badge rounded-pill bg-danger">
                                <?= $notificationCount ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- User Icon -->
                    <div style="cursor:pointer;">
                        <i class="fa fa-user-circle fs-3"></i>
                    </div>

                </div>
            </header>


            <!-- Page Content -->
            <main class="content">
                <?php include $contentFile; ?>
            </main>
        </div>
    </div>

</body>

</html>