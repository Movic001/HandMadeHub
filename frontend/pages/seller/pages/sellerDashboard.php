<?php
session_start();
require_once __DIR__ . '/../../../../server/config/db.php';
require_once __DIR__ . '/../../../../server/classes/sellerProduct.php';
require_once __DIR__ . '/../../../../server/classes/order.php';

// ensure seller is logged in
if (empty($_SESSION['user_id'])) {
    header('Location: ../../login.html');
    exit;
}
$sellerId = $_SESSION['user_id'];

// 3) fetch products
$db = (new Database())->connect();
$model = new SellerProduct($db);
$products = $model->getProductsBySeller($sellerId);



//display orders in orders section

$orderModel = new Order($db);
if (!isset($seller_id) && isset($_SESSION['user_id'])) {
    $seller_id = $_SESSION['user_id'];
}

$sellerOrders = $orderModel->getOrdersBySellerId($seller_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>HandMadeHub Seller Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/sellerDashboard.css">
</head>

<body>
    <!-- Mobile Toggle Button -->
    <div class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </div>

    <!-- Overlay for mobile -->
    <div class="overlay" id="overlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="brand">HandMadeHub</div>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        <div class="profile-section">
            <div class="profile-pic">JD</div>
            <div class="profile-info">
                <div class="profile-name">Ibrahim</div>
            </div>
        </div>
        <nav class="sidebar-menu">
            <ul>
                <li class="menu-item">
                    <a href="#dashboard" class="menu-link active" data-section="dashboard">
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#products" class="menu-link" data-section="products">
                        <i class="fas fa-box"></i>
                        <span class="menu-text">My Products</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#add-product" class="menu-link" data-section="add-product">
                        <i class="fas fa-plus-circle"></i>
                        <span class="menu-text">Add New Product</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#orders" class="menu-link" data-section="orders">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="menu-text">Orders</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#messages" class="menu-link" data-section="messages">
                        <i class="fas fa-envelope"></i>
                        <span class="menu-text">Messages</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a href="#settings" class="menu-link" data-section="settings">
                        <i class="fas fa-cog"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                </li>
            </ul>
        </nav>
        <div class="logout">
            <button class="logout-btn" id="logoutBtn">
                <i class="fas fa-sign-out-alt"></i>
                <span class="menu-text">Logout</span>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        <!-- Dashboard Section -->
        <section id="dashboard" class="content-section active">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Dashboard Overview</h1>
                <p class="dashboard-subtitle">Welcome back, Ibrahim! Here's an overview of your store performance.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon products-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3>16</h3>
                        <p>Total Products</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon pending-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon completed-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>15</h3>
                        <p>Completed Orders</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon messages-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <h3>4</h3>
                        <p>New Messages</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="orders-section">
                <div class="section-title">
                    <span>Recent Orders</span>
                    <a href="#orders" class="view-all" data-section="orders">View All</a>
                </div>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1234</td>
                            <td>Wooden Bowl</td>
                            <td>Sarah J.</td>
                            <td>May 18</td>
                            <td><span class="status shipped">Shipped</span></td>
                        </tr>
                        <tr>
                            <td>#1235</td>
                            <td>Ceramic Set</td>
                            <td>Michael B.</td>
                            <td>May 17</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#1236</td>
                            <td>Knitted Scarf</td>
                            <td>Emma W.</td>
                            <td>May 16</td>
                            <td><span class="status processing">Processing</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Quick Actions -->
            <div class="actions-section">
                <div class="section-title">Quick Actions</div>
                <div class="actions-grid">
                    <div class="action-card" data-section="add-product">
                        <div class="action-icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <h3 class="action-title">Add New Product</h3>
                        <p class="action-description">List a new handcrafted item for sale</p>
                    </div>
                    <div class="action-card" data-section="products">
                        <div class="action-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <h3 class="action-title">View All Products</h3>
                        <p class="action-description">Manage your product inventory</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- My Products Section -->

        <section id="products" class="content-section">
            <div class="dashboard-header">
                <h1 class="dashboard-title">My Products</h1>
                <p class="dashboard-subtitle">Manage your product listings.</p>
            </div>

            <div class="products-section">
                <div class="section-title">
                    <span>All Products</span>
                    <a href="addProduct.html" class="view-all">Add New</a>
                </div>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $prod): ?>
                                <tr>
                                    <td>
                                        <?php if ($prod['image_path']): ?>
                                            <img src="../../../uploads/products/<?= htmlspecialchars($prod['image_path']); ?>" width="50" alt="">
                                        <?php elseif ($prod['image_path'] === null): ?>
                                            <!--img src="../../../uploads/products</?= htmlspecialchars($prod['image_path']); ?>" width="50" alt=""-->
                                        <?php else: ?>
                                            <div class="placeholder"><i class="fas fa-image"></i></div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($prod['product_name']); ?></td>
                                    <td><?= htmlspecialchars($prod['description']); ?></td>
                                    <td><?= htmlspecialchars($prod['category']); ?></td>
                                    <td>$<?= number_format($prod['price'], 2); ?></td>
                                    <td><?= (int)$prod['stock_quantity']; ?></td>
                                    <td>
                                        <a href="editProduct.html?id=<?= $prod['id']; ?>" class="action-btn edit-btn">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="../../../../server/routes/sellerRoute.php" style="display:inline;">
                                            <input type="hidden" name="action" value="deleteProduct">
                                            <input type="hidden" name="product_id" value="<?= $prod['id']; ?>">
                                            <button type="submit" class="action-btn delete-btn">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">You have no products yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </section>

        <!-- Add New Product Section -->
        <section id="add-product" class="content-section">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Add New Product</h1>
                <p class="dashboard-subtitle">Create a new product listing.</p>
            </div>

            <div class="orders-section">
                <form id="productForm" action="../../../../../HandMadeHub/server/routes/sellerRoute.php" method="POST" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input
                                type="text"
                                name="product_name"
                                class="form-control"
                                placeholder="Enter product name"
                                required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Price ($)</label>
                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                placeholder="0.00"
                                step="0.01"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Product Description</label>
                        <textarea
                            name="description"
                            class="form-control"
                            placeholder="Describe your product..."
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Address</label>
                        <input
                            type="address"
                            name="address"
                            class="form-control"
                            placeholder="Enter product address"
                            required>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-control" required>
                                <option value="">Select Category</option>
                                <option value="jewelry">Jewelry</option>
                                <option value="ceramics">Ceramics</option>
                                <option value="woodwork">Woodwork</option>
                                <option value="textiles">Textiles</option>
                                <option value="art">Art</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock Quantity</label>
                            <input
                                type="number"
                                name="stock_quantity"
                                class="form-control"
                                placeholder="0"
                                min="0"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Product Images</label>
                        <input
                            type="file"
                            name="images[]"
                            class="form-control"
                            multiple
                            accept="image/*">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tags (comma separated)</label>
                        <input
                            type="text"
                            name="tags"
                            class="form-control"
                            placeholder="handmade, craft, art">
                    </div>

                    <div class="form-group">
                        <input type="submit" name="addProduct" class="form-button" values="Add Products ">
                    </div>
                </form>

            </div>
        </section>

        <!-- Orders Section -->
        <section id="orders" class="content-section">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Orders</h1>
                <p class="dashboard-subtitle">Manage your customer orders.</p>
            </div>

            <div class="orders-section">
                <div class="section-title">
                    <span>All Orders</span>
                    <div>
                        <select class="form-control" style="display: inline-block; width: auto;">
                            <option value="all">All Orders</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sellerOrders)): ?>
                            <?php foreach ($sellerOrders as $order): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($order['order_id']) ?></td>

                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <!--img src="<n?= htmlspecialchars($order['product_image']) ?>" alt="Product Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"-->
                                            <?= htmlspecialchars($order['product_name']) ?>
                                        </div>
                                    </td>

                                    <td><?= htmlspecialchars($order['buyer_name']) ?></td>

                                    <td>$<?= number_format($order['amount'], 2) ?></td>

                                    <td>
                                        <span class="status <?= strtolower($order['status']) ?>">
                                            <?= htmlspecialchars($order['status']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <button class="action-btn" onclick="location.href='messageBuyer.php?buyer_id=<?= $order['buyer_id'] ?>&order_id=<?= $order['order_id'] ?>'">Message Buyer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No orders found for your products.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </section>

        <!-- Messages Section -->
        <section id="messages" class="content-section">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Messages</h1>
                <p class="dashboard-subtitle">Communication with your customers.</p>
            </div>

            <div class="orders-section">
                <div class="section-title">
                    <span>All Messages</span>
                    <div>
                        <select class="form-control" style="display: inline-block; width: auto;">
                            <option value="all">All Messages</option>
                            <option value="unread">Unread</option>
                            <option value="read">Read</option>
                        </select>
                    </div>
                </div>
                <ul class="message-list">
                    <li class="message-item">
                        <div class="message-sender-pic">SJ</div>
                        <div class="message-content">
                            <div class="message-header">
                                <div class="message-sender">Sarah Johnson</div>
                                <div class="message-date">May 18, 2025</div>
                            </div>
                            <p class="message-preview">Hi, I was wondering if the wooden bowl is made from sustainable materials? I'm very interested in purchasing it but would like to know more about the...</p>
                        </div>
                        <div class="message-status">
                            <div class="status-indicator status-new"></div>
                        </div>
                    </li>
                    <li class="message-item">
                        <div class="message-sender-pic">MB</div>
                        <div class="message-content">
                            <div class="message-header">
                                <div class="message-sender">Michael Brown</div>
                                <div class="message-date">May 17, 2025</div>
                            </div>
                            <p class="message-preview">Thank you for the quick response! I'd like to order the ceramic vase set in blue if it's available. Let me know if that's possible and I'll place...</p>
                        </div>
                        <div class="message-status">
                            <div class="status-indicator status-new"></div>
                        </div>
                    </li>
                    <li class="message-item">
                        <div class="message-sender-pic">EW</div>
                        <div class="message-content">
                            <div class="message-header">
                                <div class="message-sender">Emma White</div>
                                <div class="message-date">May 16, 2025</div>
                            </div>
                            <p class="message-preview">I received my knitted scarf today and I absolutely love it! The quality is amazing and the colors are even more beautiful in person. Thank you...</p>
                        </div>
                        <div class="message-status">
                            <div class="status-indicator status-new"></div>
                        </div>
                    </li>
                    <li class="message-item">
                        <div class="message-sender-pic">DL</div>
                        <div class="message-content">
                            <div class="message-header">
                                <div class="message-sender">David Lee</div>
                                <div class="message-date">May 15, 2025</div>
                            </div>
                            <p class="message-preview">I have a question about customizing the macrame wall hanging. Is it possible to get it in a different size? I'm looking for something a bit larger...</p>
                        </div>
                        <div class="message-status">
                            <div class="status-indicator status-new"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Settings Section -->
        <section id="settings" class="content-section">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Settings</h1>
                <p class="dashboard-subtitle">Manage your account and store preferences.</p>
            </div>

            <div class="settings-card">
                <div class="settings-header">
                    <h2>Profile Information</h2>
                </div>
                <div class="upload-area">
                    <div class="large-profile-pic">JD</div>
                    <div>
                        <button class="upload-btn">
                            <i class="fas fa-camera"></i> Change Profile Picture
                        </button>
                        <p style="margin-top: 5px; font-size: 0.8rem; color: #666;">Maximum file size: 5MB</p>
                    </div>
                </div>
                <!-- profile form-->
                <form>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" value="John">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" value="Doe">
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="john.doe@example.com">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" value="+1 (555) 123-4567">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-button">Save Profile</button>
                    </div>
                </form>
            </div>

            <div class="settings-card">
                <div class="settings-header">
                    <h2>Store Information</h2>
                </div>
                <form>
                    <div class="form-group">
                        <label class="form-label">Store Name</label>
                        <input type="text" class="form-control" value="John's Handcrafted Goods">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Store Description</label>
                        <textarea class="form-control">Handcrafted items made with love and attention to detail. Specializing in wooden crafts, ceramic pieces, and textile art.</textarea>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Store Logo</label>
                            <input type="file" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Store Banner</label>
                            <input type="file" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-button">Save Store Information</button>
                    </div>
                </form>
            </div>

            <div class="settings-card">
                <div class="settings-header">
                    <h2>Change Password</h2>
                </div>
                <form>
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control">
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">New Password</label>
                            <input type="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-button">Change Password</button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script src="../scripts/sellerDashboard.js"></script>
</body>

</html>