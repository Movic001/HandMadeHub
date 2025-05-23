<?php
class Order
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOrder($buyer_id, $product_id)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO orders (buyer_id, product_id, order_date, order_status)
            VALUES (?, ?, NOW(), 'Pending')
        ");
        return $stmt->execute([$buyer_id, $product_id]);
    }

    public function getOrdersByBuyerId($buyer_id)
    {
        $stmt = $this->conn->prepare("
            SELECT 
                o.id AS order_id,
                o.order_status AS status,
                o.estimated_delivery,
                p.product_name
            FROM orders o
            JOIN seller_products p ON o.product_id = p.id
            WHERE o.buyer_id = ?
            ORDER BY o.id DESC
        ");
        $stmt->execute([$buyer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersBySellerId($seller_id)
    {
        $stmt = $this->conn->prepare("
        SELECT 
            o.id AS order_id,
            o.order_status AS status,
            o.estimated_delivery,
            o.buyer_id,
            u.fullName AS buyer_name,
            p.product_name,
            p.price AS amount
        FROM orders o
        JOIN seller_products p ON o.product_id = p.id
        JOIN users u ON o.buyer_id = u.id
        WHERE p.seller_id = ?
        ORDER BY o.id DESC
    ");
        $stmt->execute([$seller_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
