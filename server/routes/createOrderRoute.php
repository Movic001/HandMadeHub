<?php
session_start();
require_once '../config/db.php';
require_once '../classes/Order.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/pages/login.php");
    exit;
}

$database = new Database();
$db = $database->connect();

$buyer_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && !empty($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Validate product ID exists
    $check = $db->prepare("SELECT id FROM seller_products WHERE id = ?");
    $check->execute([$product_id]);

    if ($check->rowCount() === 0) {
        die("Error: Product not found.");
    }

    $orderModel = new Order($db);
    if ($orderModel->createOrder($buyer_id, $product_id)) {
        echo "<script>
            alert('Order successfully placed! Click on “Orders” to see your orders.');
            window.location.href = '../../frontend/pages/buyer/pages/buyerDashboard.php';
        </script>";
    } else {
        die("Error: Failed to create order.");
    }
} else {
    echo "Invalid request. No product ID received.";
}
