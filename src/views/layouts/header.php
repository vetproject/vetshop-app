<?php
$admin = $_SESSION['admin'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Home' ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="/assets/css/public.css">
</head>

<body>

    <!-- Header -->
    <header class="header d-flex justify-content-between align-items-center p-3 border-bottom bg-light fixed-top">
        <a href="/">
            <div class="header-left">
                <img src="/assets/images/logo.png" alt="Logo" class="logo" style="height:45px;">
            </div>
        </a>

        <div class="header-center flex-grow-1 px-5">
            <form action="" method="get" class="input-group">
                <input type="text" id="product-search" class="form-control" placeholder="Search product...">
                <button class="btn btn-primary">
                    <i class="fa fa-search"></i>
                </button>
            </form>
        </div>

        <div class="header-right d-flex align-items-center gap-4">

            <?php
            $isLoggedIn = isset($admin['logged_in']) && $admin['logged_in'] === true;
            $role = $admin['role'] ?? null;
            $busname = $admin['busname'] ?? '';
            ?>

            <?php if ($isLoggedIn && $role !== 'admin'): ?>

                <!-- Logged-in user (not admin) -->
                <span class="me-2">
                    Hello, <strong><?= htmlspecialchars($busname) ?></strong> (Customer)
                </span>

            <?php elseif ($isLoggedIn && $role === 'admin'): ?>

                <!-- Admin -->
                <a href="/dashboard" class="btn btn-link text-dark text-decoration-none">
                    <i class="fa fa-cog"></i>
                    <span>Dashboard</span>
                </a>

            <?php else: ?>

                <!-- Not logged in -->
                <button class="btn btn-link text-dark text-decoration-none"
                    data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    <i class="fa fa-user"></i>
                    <span>Login</span>
                </button>

            <?php endif; ?>


        </div>

        <!-- CART BUTTON (Open Bootstrap Offcanvas) -->
        <button class="btn btn-link text-dark text-decoration-none"
            data-bs-toggle="offcanvas"
            data-bs-target="#cartDrawer">

            <i class="fa fa-shopping-cart"></i>
            <?php
            $qty = 0;
            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $c) {
                    $qty += $c['quantity'];
                }
            }
            ?>
            <span>Cart (<?= $qty ?>)</span>
        </button>

        </div>
    </header>

    <!-- ============================================================
                            MAIN CONTENT
    ============================================================ -->
    <main class="page-content">
        <?php include $contentFile; ?>
    </main>

    <!-- ============================================================
                            LOGIN MODAL
    ============================================================ -->
    <?php include __DIR__ . '/../components/admin_account.php'; ?>

    <!-- ============================================================
                        BOOTSTRAP CART DRAWER
    ============================================================ -->
    <?php include __DIR__ . '/../components/shop_cart.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>