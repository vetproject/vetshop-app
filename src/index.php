<?php
session_start();

// Optional: include config/db first
require __DIR__ . '/config/db.php';

// Include the router
require __DIR__ . '/routes.php';
