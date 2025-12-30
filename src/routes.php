<?php
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$admin = $_SESSION['admin'] ?? null;
$cart = $_SESSION['cart'] ?? [];

// Routes that REQUIRE login
$protectedRoutes = [
    '/dashboard',
    '/products',
    '/buses',
    '/categories',
    '/orders',
    '/setting'
];

// Routes that ALLOW cart access
$accessCartRoutes = [
    '/view_cart',
    '/checkout'
];

// 🔐 Auth check
if (in_array($request, $protectedRoutes)) {
    if (!isset($admin) || $admin['logged_in'] !== true) {
        header("Location: /");
        exit;
    }
}

// Permmissioin check
if (in_array($request, $protectedRoutes)) {
    if ($admin['role'] !== 'admin') {
        header("Location: /permmission");
        exit;
    }
}

// 🛒 Cart check
if (in_array($request, $accessCartRoutes)) {
    if (empty($cart)) {
        header("Location: /");
        exit;
    }
}

// auto laod views based on the request
$autoRefreshRoutes = [
    '/dashboard',
];

// 📌 Router
switch ($request) {

    // Public Routes
    case '/':
    case '/home':
        require __DIR__ . '/views/pages/home.php';
        break;

    case '/dashboard':
        require __DIR__ . '/views/pages/dashboard.php';
        break;

    case '/products':
        require __DIR__ . '/views/pages/products.php';
        break;

    case '/buses':
        require __DIR__ . '/views/pages/buses.php';
        break;

    case '/categories':
        require __DIR__ . '/views/pages/categories.php';
        break;

    case '/orders':
        require __DIR__ . '/views/pages/orders.php';
        break;

    case '/order_detail':
        require __DIR__ . '/views/pages/order_detail.php';
        break;

    case '/setting':
        require __DIR__ . '/views/pages/settings.php';
        break;

    case '/permmission':
        require __DIR__ . '/views/pages/permmissioin.php';
        break;

    case '/view_cart':
        require __DIR__ . '/views/pages/view_cart.php';
        break;
    case '/checkout':
        require __DIR__ . '/views/pages/checkout.php';
        break;

    // API Routes
    case '/api/products':
        require __DIR__ . '/views/api/api_product.php';
        break;
    case '/api/categories':
        require __DIR__ . '/views/api/api_category.php';
        break;
    case '/api/buses':
        require __DIR__ . '/views/api/api_bus.php';
        break;
    case '/api/orders':
        require __DIR__ . '/views/api/api_order.php';
        break;

    // 404 Not Found
    default:
        http_response_code(404);
        require __DIR__ . '/views/pages/404.php';
        break;
}
?>
<?php if (in_array($request, $autoRefreshRoutes)): ?>
    <script>
        const REFRESH_TIME = 4000; // 4 seconds
        let refreshTimer;

        function startRefreshTimer() {
            clearTimeout(refreshTimer);
            refreshTimer = setTimeout(() => {
                location.reload();
            }, REFRESH_TIME);
        }

        // Reset timer on user activity
        ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'].forEach(event => {
            document.addEventListener(event, startRefreshTimer, {
                passive: true
            });
        });

        // Pause refresh when tab is inactive
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                clearTimeout(refreshTimer);
            } else {
                startRefreshTimer();
            }
        });

        startRefreshTimer();
    </script>
<?php endif; ?>