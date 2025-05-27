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

        if ($productId > 0) {
            $deleted = $sellerProduct->deleteProduct($productId);

            if ($deleted) {
                $user->showAlert(
                    "Success",
                    "Product deleted successfully.",
                    "success",
                    "../../frontend/pages/seller/pages/sellerDashboard.php"
                );
            } else {
                // Check if the product couldn't be deleted due to orders
                $checkSql = "SELECT COUNT(*) FROM orders WHERE product_id = :product_id";
                $stmt = $conn->prepare($checkSql);
                $stmt->execute([':product_id' => $productId]);
                $orderCount = $stmt->fetchColumn();

                if ($orderCount > 0) {
                    $user->showAlert(
                        "Cannot Delete Product",
                        "This product has existing orders and cannot be deleted.",
                        "warning",
                        "../../frontend/pages/seller/pages/sellerDashboard.php"
                    );
                } else {
                    $user->showAlert(
                        "Error",
                        "Failed to delete the product. Please try again.",
                        "error",
                        "../../frontend/pages/seller/pages/sellerDashboard.php"
                    );
                }
            }
        } else {
            $user->showAlert(
                "Error",
                "Invalid product ID.",
                "error",
                "../../frontend/pages/seller/pages/sellerDashboard.php"
            );
        }
    }
}
