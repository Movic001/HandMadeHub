<?php
session_start();
require_once '../config/db.php';
require_once '../classes/order.php';
require_once '../classes/users.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/pages/login.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $database = new Database();
    $db = $database->connect();
    $orderModel = new Order($db);
    $user = new User($db);

    // Perform deletion
    $stmt = $db->prepare("DELETE FROM orders WHERE id = ? AND buyer_id = ?");
    if ($stmt->execute([$order_id, $_SESSION['user_id']])) {
        $user->showAlert("Order Cancelled", "Your order has been successfully cancelled.", "success", "../../frontend/pages/buyer/pages/buyerDashboard.php");
    } else {
        $user->showAlert("Cancellation Failed", "Something went wrong. Try again.", "error", "../../frontend/pages/buyer/pages/buyerDashboard.php");
    }
} else {
    header("Location: ../../frontend/pages/buyer/pages/buyerDashboard.php");
    exit;
}
