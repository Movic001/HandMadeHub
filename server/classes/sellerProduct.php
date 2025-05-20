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
}