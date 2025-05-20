<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/sellerController.php';

$database = new Database();
$db = $database->connect();
$controller = new SellerController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'addProduct';

    switch ($action) {
        case 'addProduct':
            $controller->addProduct();
            break;
        default:
            header('HTTP/1.1 400 Bad Request');
            echo 'Unknown action';
            break;
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo 'Method not allowed';
}
