<?php
$admin = $_SESSION['admin'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            height: 100vh;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #fff;
            padding: 40px;
            width: 420px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .2);
            animation: fadeUp .6s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            margin: 0 0 10px;
            font-size: 26px;
            color: #111827;
        }

        p {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .badge {
            display: inline-block;
            background: #e0e7ff;
            color: #1e40af;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all .2s ease;
            display: inline-block;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-primary:hover {
            background: #1e40af;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #dc2626;
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="card">

        <?php if ($admin && $admin['logged_in'] === true): ?>

            <div class="icon">👋</div>
            <h1>Welcome, <?= htmlspecialchars($admin['busname']) ?></h1>
            <div class="badge"><?= htmlspecialchars($admin['role']) ?></div>

            <p>You are successfully logged into the Bus Management System.</p>

            <div class="actions">
                <a href="/" class="btn btn-primary">🏠 Home</a>
                <a href="../../controllers/logout_account.php" class="btn btn-danger">🚪 Logout</a>
            </div>

        <?php else: ?>

            <div class="icon">🚍</div>
            <h1>Bus System</h1>
            <p>Please login to manage buses, routes, and schedules.</p>

            <div class="actions">
                <a href="/login.php" class="btn btn-primary">🔐 Login</a>
            </div>

        <?php endif; ?>

    </div>

</body>

</html>