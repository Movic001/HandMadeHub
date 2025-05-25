<?php
session_start();
require_once '../classes/sellerProduct.php';
require_once '../classes/users.php';
require_once '../config/db.php';

$db = new Database();
$conn = $db->connect();
$sellerProduct = new SellerProduct($conn);
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'deleteProduct') {
        $productId = intval($_POST['product_id'] ?? 0);

        // You may want to check if the product belongs to the logged-in seller here

        if ($productId > 0) {
            $deleted = $sellerProduct->deleteProduct($productId);

            if ($deleted) {
                $user->showAlert("Success", "Product deleted successfully.", "success", "../../frontend/pages/seller/pages/sellerDashboard.php");
                // $_SESSION['success'] = "Product deleted successfully.";
            } else {
                $user->showAlert("Error", "Failed to delete the product.", "error", "../../frontend/pages/seller/pages/sellerDashboard.php");
                //$_SESSION['error'] = "Failed to delete the product.";
            }
        } else {
            $user->showAlert("Error", "Invalid product ID.", "error", "../../frontend/pages/seller/pages/sellerDashboard.php");
            //$_SESSION['error'] = "Invalid product ID.";
        }
        // Redirect back to seller dashboard or wherever
        //header("Location: ../../frontend/pages/buyer/pages/buyerDashboard.php"); // Redirect back to seller dashboard or wherever
        //exit();
    }
}
