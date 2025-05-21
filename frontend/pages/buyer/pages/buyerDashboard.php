<?php
// start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandmadeHub Buyer Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles/buyerDashboard.css">
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
                        <tr>
                            <td>56789</td>
                            <td>Knitted Scarf</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>May 24, 2025</td>
                            <td>
                                <button class="action-btn">Track</button>
                                <button class="action-btn secondary">Details</button>
                            </td>
                        </tr>
                        <tr>
                            <td>56790</td>
                            <td>Wooden Spoon</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>May 18, 2025</td>
                            <td>
                                <button class="action-btn">Review</button>
                                <button class="action-btn secondary">Details</button>
                            </td>
                        </tr>
                        <tr>
                            <td>56791</td>
                            <td>Ceramic Mug</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>-</td>
                            <td>
                                <button class="action-btn">Contact Seller</button>
                                <button class="action-btn secondary">Cancel</button>
                            </td>
                        </tr>
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
                <div class="product-card">
                    <div class="product-image">
                        <div style="font-size: 3rem; color: #ddd;"><i class="fas fa-image"></i></div>
                    </div>
                    <div class="product-details">
                        <div class="product-name">Clay Pot Set</div>
                        <div class="product-price">$30.00</div>
                        <div class="product-seller">by Seller A</div>
                        <div class="product-actions">
                            <button class="action-btn">View</button>
                            <button class="action-btn">Order</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <div style="font-size: 3rem; color: #ddd;"><i class="fas fa-image"></i></div>
                    </div>
                    <div class="product-details">
                        <div class="product-name">Beaded Necklace</div>
                        <div class="product-price">$15.00</div>
                        <div class="product-seller">by Seller B</div>
                        <div class="product-actions">
                            <button class="action-btn">View</button>
                            <button class="action-btn">Order</button>
                        </div>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image">
                        <div style="font-size: 3rem; color: #ddd;"><i class="fas fa-image"></i></div>
                    </div>
                    <div class="product-details">
                        <div class="product-name">Crochet Blanket</div>
                        <div class="product-price">$45.00</div>
                        <div class="product-seller">by Seller C</div>
                        <div class="product-actions">
                            <button class="action-btn">View</button>
                            <button class="action-btn">Order</button>
                        </div>
                    </div>
                </div>
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

    <script src="../script/buyerDashboard.js"></script>
</body>

</html>