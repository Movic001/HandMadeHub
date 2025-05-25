<?php
class SellerProduct
{
    private $db;

    public function __construct(PDO $dbConn)
    {
        $this->db = $dbConn;
    }

    /**
     * Add a new product and return the inserted product ID
     */
    public function addProduct(array $data): int
    {
        $sql = "INSERT INTO seller_products 
            (seller_id, product_name, price, description, address, category, stock_quantity, tags)
            VALUES
            (:seller_id, :product_name, :price, :description, :address, :category, :stock_quantity, :tags)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':seller_id'    => $data['seller_id'],
            ':product_name' => filter_var($data['product_name'], FILTER_SANITIZE_STRING),
            ':price'        => $data['price'],
            ':description'  => filter_var($data['description'], FILTER_SANITIZE_STRING),
            ':address'      => filter_var($data['address'], FILTER_SANITIZE_STRING),
            ':category'     => filter_var($data['category'], FILTER_SANITIZE_STRING),
            ':stock_quantity' => (int)$data['stock_quantity'],
            ':tags'         => filter_var($data['tags'], FILTER_SANITIZE_STRING)
        ]);

        return (int)$this->db->lastInsertId();
    }

    /**
     * Save product images paths linked to a product
     */
    public function addImages(int $productId, array $imagePaths): void
    {
        $sql = "INSERT INTO product_images (product_id, image_path) VALUES (:product_id, :image_path)";
        $stmt = $this->db->prepare($sql);

        foreach ($imagePaths as $path) {
            $stmt->execute([
                ':product_id' => $productId,
                ':image_path' => $path
            ]);
        }
    }
    /**
     * Fetch all products for a specific seller
     */
    public function getProductsBySeller(int $sellerId): array
    {
        $sql = "SELECT p.*, pi.image_path
                  FROM seller_products p
             LEFT JOIN (
                SELECT product_id, MIN(image_path) AS image_path
                FROM product_images
                GROUP BY product_id
             ) pi ON p.id = pi.product_id
                 WHERE p.seller_id = :seller_id
              ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':seller_id' => $sellerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //get all product function
    public function getAllProducts(): array
    {
        $sql = "SELECT p.*, pi.image_path
              FROM seller_products p
         LEFT JOIN users u ON p.seller_id = u.id
         LEFT JOIN (
            SELECT product_id, MIN(image_path) AS image_path
            FROM product_images
            GROUP BY product_id
         ) pi ON p.id = pi.product_id
         ORDER BY p.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProductsByName(string $search): array
    {
        $sql = "SELECT DISTINCT product_name 
            FROM seller_products 
            WHERE product_name LIKE :search
            ORDER BY product_name
            LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':search' => '%' . $search . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProduct(int $productId): bool
    {
        // Optional: Delete related product images first to maintain data integrity
        $sqlImages = "DELETE FROM product_images WHERE product_id = :product_id";
        $stmtImages = $this->db->prepare($sqlImages);
        $stmtImages->execute([':product_id' => $productId]);

        // Delete the product itself
        $sql = "DELETE FROM seller_products WHERE id = :product_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':product_id' => $productId]);
    }
}
