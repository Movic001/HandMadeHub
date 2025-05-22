<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/sellerController.php';

$database = new Database();
$db = $database->connect();
$controller = new SellerController($db);

// Display products to buyer
$controller->listAllProducts();
