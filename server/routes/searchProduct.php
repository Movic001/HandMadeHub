<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../classes/sellerProduct.php';

$search = $_GET['q'] ?? '';

if (empty($search)) {
    echo json_encode([]);
    exit;
}

// Create database connection
$database = new Database();
$pdo = $database->connect();  // get PDO object here

$sellerProduct = new SellerProduct($pdo);
$results = $sellerProduct->searchProductsByName($search);

echo json_encode($results);
