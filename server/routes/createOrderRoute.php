<?php
session_start();
require_once '../config/db.php';
require_once '../classes/Order.php';
require_once '../classes/users.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/pages/login.php");
    exit;
}

$database = new Database();
$db = $database->connect();
$user = new User($db);

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
        // Order created successfully
        $user->showAlert("Order created successfully!", "Your order has been placed.", "success", "../../frontend/pages/buyer/pages/buyerDashboard.php");
    } else {
        // Failed to create order
        $user->showAlert("Order creation failed.", "Please try again later.", "error", "../../frontend/pages/buyer/pages/buyerDashboard.php");
        // die("Error: Failed to create order.");
    }
} else {
    $user->showAlert("Invalid request.", "No product ID received.", "error", "../../frontend/pages/buyer/pages/buyerDashboard.php");
    //echo "Invalid request. No product ID received.";
}
