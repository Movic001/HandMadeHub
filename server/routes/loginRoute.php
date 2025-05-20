<?php
session_start();

require_once __DIR__ . '/../config/db.php'; // Your DB connection class
require_once __DIR__ . '/../controllers/loginController.php';

// Instantiate Database and get the connection
$database = new Database();
$db = $database->connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $controller = new LoginController($db);  // Pass the actual PDO connection
    $controller->login($email, $password);
} else {
    header("Location: ../../frontend/pages/login.html");
    exit;
}
