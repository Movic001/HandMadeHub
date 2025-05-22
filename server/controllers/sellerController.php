<?php
require_once __DIR__ . '/../classes/sellerProduct.php';

class SellerController
{
    private $db;
    private $model;

    public function __construct(PDO $dbConn)
    {
        $this->db = $dbConn;
        $this->model = new SellerProduct($this->db);
        session_start();
    }

    public function addProduct(): void
    {
        // ensure seller is logged in
        $sellerId = $_SESSION['user_id'] ?? null;
        if (!$sellerId) {
            header('Location: ../../frontend/pages/login.html');
            exit;
        }

        // pre-check image sizes (max 5000 KB)
        if (!empty($_FILES['images']['size'])) {
            foreach ($_FILES['images']['size'] as $size) {
                $fileSizeKb = $size / 1024;
                if ($fileSizeKb > 5000) {
                    header('Location: ../../frontend/pages/addProduct.html?error=file_too_large');
                    exit;
                }
            }
        }

        // collect POST data
        $data = [
            'seller_id'      => $sellerId,
            'product_name'   => $_POST['product_name'] ?? '',
            'price'          => $_POST['price'] ?? 0,
            'description'    => $_POST['description'] ?? '',
            'address'        => $_POST['address'] ?? '',
            'category'       => $_POST['category'] ?? '',
            'stock_quantity' => $_POST['stock_quantity'] ?? 0,
            'tags'           => $_POST['tags'] ?? ''
        ];

        // insert product
        $productId = $this->model->addProduct($data);

        // handle file uploads
        $imagePaths = [];
        if (!empty($_FILES['images']['tmp_name']) && is_array($_FILES['images']['tmp_name'])) {
            $uploadDir = __DIR__ . '/../../frontend/uploads/products/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
                if (is_uploaded_file($tmpName)) {
                    $filename = uniqid() . '_' . basename($_FILES['images']['name'][$index]);
                    $target = $uploadDir . $filename;
                    if (move_uploaded_file($tmpName, $target)) {
                        $imagePaths[] = 'uploads/products/' . $filename;
                    }
                }
            }
        }

        // save image records
        if (!empty($imagePaths)) {
            $this->model->addImages($productId, $imagePaths);
        }

        // redirect back to seller dashboard or products list
        header('Location: ../../frontend/pages/seller/pages/sellerDashboard.php?status=product_added');
        exit;
    }

    /**
     * Display seller's products in the My Products view
     */
    public function listProducts(): void
    {
        // ensure seller is logged in
        $sellerId = $_SESSION['user_id'] ?? null;
        if (!$sellerId) {
            header('Location: ../../frontend/pages/login.html');
            exit;
        }

        $products = $this->model->getProductsBySeller($sellerId);
        // include view file that loops through $products
        include __DIR__ . '/../../frontend/pages/myProducts.php';
    }

    //list all the product function
    public function listAllProducts(): void
    {
        $products = $this->model->getAllProducts();
        include __DIR__ . '/../../frontend/pages/buyer/pages/browseProducts.php';
    }
}
