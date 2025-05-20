<?php
require_once(__DIR__ . '/../controllers/registerController.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new RegisterController();
    $controller->register();
} else {
    echo "<script>alert('Invalid Route'); window.location.href='../../frontend/pages/register.html';</script>";
}
