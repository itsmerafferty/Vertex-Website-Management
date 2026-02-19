<?php
// Entry point for the application
session_start();
require_once __DIR__ . '/../routes/web.php';

// Default route — redirect to dashboard if logged in, otherwise to login
if (!empty($_SESSION['logged_in'])) {
    header('Location: ?admin');
} else {
    header('Location: ?login');
}
exit;
