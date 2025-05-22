<?php
require_once __DIR__ . '/../classes/Order.php';

if (!isset($orderModel)) {
    $orderModel = new Order($db);
}
if (!isset($buyer_id) && isset($_SESSION['user_id'])) {
    $buyer_id = $_SESSION['user_id'];
}
// Assumes $db and $buyer_id are already set before including this file
$orderModel = new Order($db);
$orders = $orderModel->getOrdersByBuyerId($buyer_id);
//$orders = $orderModel->getOrdersByBuyerId($buyer_id);
