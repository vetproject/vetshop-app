<?php
session_start();

require __DIR__ . '/../config/db.php';
require __DIR__ . '/../models/admin/account.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $admin_username = trim($_GET['username'] ?? '');
    $admin_password = trim($_GET['password'] ?? '');

    if (empty($admin_username) || empty($admin_password)) {
        die("Username and password are required.");
    }

    try {
        // loginBus returns admin data as array
        $admin = loginBus($admin_username, $admin_password);

        // ✅ Store everything inside ONE session array
        $_SESSION['admin'] = [
            'logged_in' => true,
            'id'        => $admin['id'],
            'busname'   => $admin['busname'],
            'role'      => $admin['role'] ?? 'admin',
            'login_at'  => date('Y-m-d H:i:s')
        ];

        // Security
        session_regenerate_id(true);

        header("Location: /dashboard");
        exit;
    } catch (Exception $e) {
        die("LOGIN FAILED: " . $e->getMessage());
    }
}
