<?php
// if session is not start start it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../../server/config/db.php';
require_once __DIR__ . '/../../../../server/classes/sellerProduct.php';
require_once __DIR__ . '/../../../../server/classes/order.php';

// ensure seller is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: ../../login.html');
    exit;
}
$sellerId = $_SESSION['user_id'];

// Check if buyer is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// 3) fetch products
$db = (new Database())->connect();
$model = new SellerProduct($db);
$products = $model->getAllProducts($sellerId);

$orderModel = new Order($db);
$buyer_id = $_SESSION['user_id'];
$orders = $orderModel->getOrdersByBuyerId($buyer_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandmadeHub Buyer Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/HandmadeHub/frontend/pages/buyer/styles/buyerDashboard.css">
</head>

<body>
    <!-- Header -->
    <header>
        <button class="mobile-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="logo">
            <i class="fas fa-paint-brush"></i>
            <span>HandmadeHub</span>
        </div>
        <div class="header-actions">
            <button class="logout-btn">
                <i class="fas fa-lock"></i>
                Logout
            </button>
        </div>
    </header>

    <!-- Sidebar Navigation -->
    <nav class="sidebar" id="sidebar">
        <div class="nav-item active" data-tab="dashboard">
            <i class="fas fa-home"></i>
            <span class="nav-text">Dashboard</span>
        </div>
        <div class="nav-item" data-tab="orders">
            <i class="fas fa-box"></i>
            <span class="nav-text">Orders</span>
        </div>
        <div class="nav-item" data-tab="messages">
            <i class="fas fa-comment"></i>
            <span class="nav-text">Messages</span>
        </div>
        <div class="nav-item" data-tab="browse">
            <i class="fas fa-shopping-bag"></i>
            <span class="nav-text">Browse Products</span>
        </div>
        <div class="nav-item" data-tab="account">
            <i class="fas fa-user"></i>
            <span class="nav-text">Account</span>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="tab-container">
            <div class="tabs">
                <div class="tab active" data-tab="dashboard">
                    <i class="fas fa-home"></i> Dashboard
                </div>
                <div class="tab" data-tab="orders">
                    <i class="fas fa-box"></i> Orders
                </div>
                <div class="tab" data-tab="messages">
                    <i class="fas fa-comment"></i> Messages
                </div>
                <div class="tab" data-tab="browse">
                    <i class="fas fa-shopping-bag"></i> Browse Products
                </div>
                <div class="tab" data-tab="account">
                    <i class="fas fa-user"></i> Account
                </div>
            </div>
        </div>

        <!-- Dashboard Tab Content -->
        <div class="tab-content active" id="dashboard-content">
            <div class="welcome-banner">
                <h2>Welcome Back, Sarah!</h2>
                <p>Here's what's happening with your HandmadeHub account today.</p>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <h3>TOTAL ORDERS</h3>
                    <div class="value">5</div>
                    <div class="detail">2 orders pending</div>
                </div>
                <div class="stat-card">
                    <h3>UNREAD MESSAGES</h3>
                    <div class="value">2</div>
                    <div class="detail">Last message 2 hours ago</div>
                </div>
                <div class="stat-card">
                    <h3>RECENTLY VIEWED</h3>
                    <div class="value">3 products</div>
                    <div class="detail">Handmade Soap, Pot Set</div>
                </div>
            </div>
        </div>

        <!-- Orders Tab Content -->
        <div class="tab-content" id="orders-content">
            <h2>Your Orders</h2>
            <p>Track and manage all your purchases from HandmadeHub sellers.</p>

            <div style="margin-top: 2rem; overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Status</th>
                            <th>Estimated Delivery</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?= htmlspecialchars($order['order_id']) ?></td>
                                    <td><?= htmlspecialchars($order['product_name']) ?></td>
                                    <td><span class="status <?= strtolower($order['status']) ?>"><?= htmlspecialchars($order['status']) ?></span></td>
                                    <td><?= $order['estimated_delivery'] ? htmlspecialchars($order['estimated_delivery']) : '-' ?></td>
                                    <td>
                                        <?php if ($order['status'] == 'Shipped'): ?>
                                            <button class="action-btn">Track</button>
                                        <?php elseif ($order['status'] == 'Delivered'): ?>
                                            <button class="action-btn">Review</button>
                                        <?php elseif ($order['status'] == 'Pending'): ?>
                                            <?php
                                            $sellerPhone = preg_replace('/[^0-9]/', '', $order['seller_phone']);
                                            $whatsAppMessage = urlencode("Hello " . $order['seller_name'] . ", I have a question about my order #" . $order['order_id'] . " for \"" . $order['product_name'] . "\" on HandmadeHub.");
                                            $whatsAppLink = "https://wa.me/$sellerPhone?text=$whatsAppMessage";
                                            ?>
                                            <a href="tel:<?= $sellerPhone ?>" class="action-btn" style="text-decoration:none">Call Seller</a>
                                            <a href="<?= $whatsAppLink ?>" class="action-btn" target="_blank" style="text-decoration:none">Message on WhatsApp</a>
                                            <button class="action-btn secondary">Cancel</button>
                                        <?php endif; ?>

                                        <button class="action-btn secondary">Details</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <a href="#" class="view-more">View More Orders</a>
            </div>
        </div>





        <!-- Messages Tab Content -->
        <div class="tab-content" id="messages-content">
            <h2>Your Messages</h2>
            <p>Stay in touch with HandmadeHub sellers and support.</p>

            <div style="margin-top: 2rem;">
                <div class="message-item">
                    <div class="message-info">
                        <div class="message-sender">Seller A</div>
                        <div class="message-subject">Shipping Update</div>
                        <div class="message-time">2h ago</div>
                    </div>
                    <div class="message-action">
                        <button class="action-btn">Read</button>
                    </div>
                </div>

                <div class="message-item">
                    <div class="message-info">
                        <div class="message-sender">Seller B</div>
                        <div class="message-subject">Custom Request Reply</div>
                        <div class="message-time">Yesterday</div>
                    </div>
                    <div class="message-action">
                        <button class="action-btn">Read</button>
                    </div>
                </div>

                <div class="message-item">
                    <div class="message-info">
                        <div class="message-sender">HandmadeHub</div>
                        <div class="message-subject">Welcome to HandmadeHub</div>
                        <div class="message-time">2 days ago</div>
                    </div>
                    <div class="message-action">
                        <button class="action-btn">Read</button>
                    </div>
                </div>

                <a href="#" class="view-more">Go to Inbox</a>
            </div>
        </div>

        <!-- Browse Products Tab Content -->
        <div class="tab-content" id="browse-content">
            <h2>Browse Products</h2>
            <p>Discover unique handmade items from talented artisans.</p>

            <div class="product-filters">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search products...">
                </div>
                <div class="filter-dropdown">
                    <select>
                        <option>All Categories</option>
                        <option>Home Decor</option>
                        <option>Jewelry</option>
                        <option>Art</option>
                        <option>Clothing</option>
                    </select>
                </div>
                <div class="filter-dropdown">
                    <select>
                        <option>Sort by: Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                    </select>
                </div>
            </div>

            <div class="products-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?php if (!empty($product['image_path'])): ?>
                                <img src="../../../<?= htmlspecialchars($product['image_path']) ?>" alt="Product Image" style="width:100%; height: 150px; object-fit:cover;">
                            <?php else: ?>
                                <div style="font-size: 3rem; color: #ddd;"><i class="fas fa-image"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="product-details">
                            <div class="product-name"><?= htmlspecialchars($product['product_name']) ?></div>
                            <div class="product-price" style="color:green"># <?= number_format($product['price'], 2) ?></div>
                            <div class="product-seller">Address: <?= htmlspecialchars($product['address']) ?></div>
                            <div class="product-seller">Description: <?= htmlspecialchars($product['description']) ?></div>
                            <div class="product-actions">
                                <button class="action-btn">View</button>

                                <form action="../../../../server/routes/createOrderRoute.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <button type="submit" class="btn-btn-primary">Order Now</button>
                                </form>



                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- Account Tab Content -->
        <div class="tab-content" id="account-content">
            <h2>Account Settings</h2>
            <p>Manage your HandmadeHub buyer account details.</p>

            <div class="account-section">
                <h3>Account Details</h3>
                <ul class="settings-list">
                    <li class="settings-item">
                        <i class="fas fa-user-circle"></i>
                        <a href="#">Profile Information</a>
                    </li>
                    <li class="settings-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <a href="#">Shipping Address</a>
                    </li>
                    <li class="settings-item">
                        <i class="fas fa-credit-card"></i>
                        <a href="#">Payment Methods</a>
                    </li>
                    <li class="settings-item">
                        <i class="fas fa-history"></i>
                        <a href="#">Order History</a>
                    </li>
                    <li class="settings-item">
                        <i class="fas fa-bell"></i>
                        <a href="#">Notification Settings</a>
                    </li>
                    <li class="settings-item">
                        <i class="fas fa-lock"></i>
                        <a href="#">Change Password</a>
                    </li>
                </ul>
            </div>

            <div class="account-section">
                <h3>Help & Support</h3>
                <ul class="settings-list">
                    <li class="settings-item">
                        <i class="fas fa-question-circle"></i>
                        <a href="#">FAQ</a>
                    </li>
                    <li class="settings-item">
                        <i class="fas fa-headset"></i>
                        <a href="#">Contact Support</a>
                    </li>
                </ul>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer id="footer">
        <div class="footer-links">
            <a href="#">About</a>
            <a href="#">Help</a>
            <a href="#">Contact</a>
            <a href="#">Terms & Privacy</a>
        </div>
    </footer>

    <script src="/HandmadeHub/frontend/pages/buyer/script/buyerDashboard.js" defer></script>
</body>

</html>