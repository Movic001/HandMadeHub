<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HandMadeHub Seller Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #5c6bc0;
            --secondary-color: #7986cb;
            --accent-color: #3949ab;
            --text-color: #333;
            --text-light: #fff;
            --bg-light: #f9f9f9;
            --bg-dark: #212121;
            --success-color: #4caf50;
            --warning-color: #ff9800;
            --danger-color: #f44336;
            --border-radius: 8px;
            --shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: var(--bg-dark);
            color: var(--text-light);
            width: 250px;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            z-index: 100;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .brand {
            font-size: 1.4rem;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 1.2rem;
        }

        .profile-section {
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .profile-info {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
        }

        .profile-name {
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-menu {
            padding: 20px 0;
            flex: 1;
        }

        .menu-item {
            list-style: none;
        }

        .menu-link {
            text-decoration: none;
            color: var(--text-light);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: var(--transition);
        }

        .menu-link:hover,
        .menu-link.active {
            background-color: var(--accent-color);
        }

        .menu-link i {
            width: 20px;
            text-align: center;
        }

        .menu-text {
            white-space: nowrap;
            overflow: hidden;
        }

        .logout {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: var(--danger-color);
            color: var(--text-light);
            border-radius: var(--border-radius);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background-color: #d32f2f;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            transition: var(--transition);
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .dashboard-subtitle {
            color: #666;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 15px;
        }

        .products-icon {
            background-color: rgba(92, 107, 192, 0.2);
            color: var(--primary-color);
        }

        .pending-icon {
            background-color: rgba(255, 152, 0, 0.2);
            color: var(--warning-color);
        }

        .completed-icon {
            background-color: rgba(76, 175, 80, 0.2);
            color: var(--success-color);
        }

        .messages-icon {
            background-color: rgba(244, 67, 54, 0.2);
            color: var(--danger-color);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #666;
            font-size: 0.9rem;
        }

        .orders-section,
        .actions-section {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-all {
            font-size: 0.9rem;
            color: var(--primary-color);
            text-decoration: none;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th,
        .orders-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .orders-table th {
            background-color: #f5f5f5;
            font-weight: 600;
        }

        .orders-table tr:last-child td {
            border-bottom: none;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .shipped {
            background-color: rgba(76, 175, 80, 0.2);
            color: var(--success-color);
        }

        .pending {
            background-color: rgba(255, 152, 0, 0.2);
            color: var(--warning-color);
        }

        .processing {
            background-color: rgba(33, 150, 243, 0.2);
            color: #2196f3;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .action-card {
            background-color: #f5f5f5;
            border-radius: var(--border-radius);
            padding: 20px;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .action-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            color: var(--primary-color);
        }

        .action-title {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .action-description {
            font-size: 0.9rem;
            color: #666;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }

            .sidebar.expanded {
                width: 250px;
            }

            .main-content {
                margin-left: 70px;
            }

            .main-content.pushed {
                margin-left: 250px;
            }

            .profile-info,
            .menu-text,
            .brand {
                opacity: 0;
                display: none;
            }

            .sidebar.expanded .profile-info,
            .sidebar.expanded .menu-text,
            .sidebar.expanded .brand {
                opacity: 1;
                display: block;
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.mobile-visible {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 101;
                background-color: var(--primary-color);
                color: white;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: var(--shadow);
                cursor: pointer;
            }

            .profile-info,
            .menu-text,
            .brand {
                opacity: 1;
                display: block;
            }
        }

        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .orders-table {
                font-size: 0.9rem;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-title {
                font-size: 1.5rem;
            }
        }

        /* Product pages styles (initially hidden) */
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }

        /* Add New Product Form */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            transition: var(--transition);
        }

        .form-button:hover {
            background-color: var(--accent-color);
        }

        /* Products Table */
        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table th,
        .products-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .products-table th {
            background-color: #f5f5f5;
            font-weight: 600;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: var(--border-radius);
            object-fit: cover;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            background-color: #f5f5f5;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .edit-btn {
            color: var(--primary-color);
        }

        .delete-btn {
            color: var(--danger-color);
        }

        .action-btn:hover {
            background-color: #e0e0e0;
        }

        /* Settings Page */
        .settings-card {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-bottom: 20px;
        }

        .settings-header {
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .upload-area {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .large-profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: bold;
            color: white;
        }

        .upload-btn {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
        }

        .upload-btn:hover {
            background-color: #e0e0e0;
        }

        /* Messages Page */
        .message-list {
            list-style: none;
        }

        .message-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .message-item:hover {
            background-color: #f5f5f5;
        }

        .message-sender-pic {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .message-content {
            flex: 1;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .message-sender {
            font-weight: 600;
        }

        .message-date {
            font-size: 0.8rem;
            color: #666;
        }

        .message-preview {
            color: #666;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .message-status {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-new {
            background-color: var(--primary-color);
        }

        /* Loading Spinner */
        .loader {
            display: none;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Mobile Toggle Button */
        .mobile-toggle {
            display: none;
        }

        /* Overlay for mobile */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
            display: none;
        }

        .overlay.active {
            display: block;
        }
    </style>
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
                <div class="profile-name">John Doe</div>
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
                <p class="dashboard-subtitle">Welcome back, John! Here's an overview of your store performance.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon products-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3>25</h3>
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
                            <td>Handcrafted Wooden Bowl</td>
                            <td>Sarah Johnson</td>
                            <td>May 18, 2025</td>
                            <td><span class="status shipped">Shipped</span></td>
                        </tr>
                        <tr>
                            <td>#1235</td>
                            <td>Ceramic Vase Set</td>
                            <td>Michael Brown</td>
                            <td>May 17, 2025</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#1236</td>
                            <td>Knitted Scarf</td>
                            <td>Emma White</td>
                            <td>May 16, 2025</td>
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

            <div class="orders-section">
                <div class="section-title">
                    <span>All Products</span>
                    <a href="#add-product" class="view-all" data-section="add-product">Add New</a>
                </div>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="product-image" style="background-color: #e0e0e0;"><i class="fas fa-image"></i></div>
                            </td>
                            <td>Handcrafted Wooden Bowl</td>
                            <td>$45.00</td>
                            <td>12</td>
                            <td><span class="status shipped">Active</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-image" style="background-color: #e0e0e0;"><i class="fas fa-image"></i></div>
                            </td>
                            <td>Ceramic Vase Set</td>
                            <td>$65.00</td>
                            <td>8</td>
                            <td><span class="status shipped">Active</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-image" style="background-color: #e0e0e0;"><i class="fas fa-image"></i></div>
                            </td>
                            <td>Knitted Scarf</td>
                            <td>$35.00</td>
                            <td>5</td>
                            <td><span class="status shipped">Active</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="product-image" style="background-color: #e0e0e0;"><i class="fas fa-image"></i></div>
                            </td>
                            <td>Macrame Wall Hanging</td>
                            <td>$55.00</td>
                            <td>3</td>
                            <td><span class="status shipped">Active</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-edit"></i></button>
                                    <button class="action-btn delete-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
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
                <form id="productForm">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" placeholder="Enter product name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Price ($)</label>
                            <input type="number" class="form-control" placeholder="0.00" step="0.01">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Description</label>
                        <textarea class="form-control" placeholder="Describe your product..."></textarea>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select class="form-control">
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
                            <input type="number" class="form-control" placeholder="0" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Product Images</label>
                        <input type="file" class="form-control" multiple>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tags (comma separated)</label>
                        <input type="text" class="form-control" placeholder="handmade, craft, art">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-button">Add Product</button>
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
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#1234</td>
                            <td>Handcrafted Wooden Bowl</td>
                            <td>Sarah Johnson</td>
                            <td>May 18, 2025</td>
                            <td>$45.00</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#1235</td>
                            <td>Ceramic Vase Set</td>
                            <td>Michael Brown</td>
                            <td>May 17, 2025</td>
                            <td>$65.00</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#1236</td>
                            <td>Knitted Scarf</td>
                            <td>Emma White</td>
                            <td>May 16, 2025</td>
                            <td>$35.00</td>
                            <td><span class="status processing">Processing</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#1237</td>
                            <td>Macrame Wall Hanging</td>
                            <td>David Lee</td>
                            <td>May 15, 2025</td>
                            <td>$55.00</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>#1238</td>
                            <td>Hand-painted Mug</td>
                            <td>Lisa Chen</td>
                            <td>May 14, 2025</td>
                            <td>$28.00</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn edit-btn"><i class="fas fa-eye"></i></button>
                                </div>
                            </td>
                        </tr>
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

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleSidebar = document.getElementById('toggleSidebar');
            const mobileToggle = document.getElementById('mobileToggle');
            const overlay = document.getElementById('overlay');
            const menuLinks = document.querySelectorAll('.menu-link');
            const logoutBtn = document.getElementById('logoutBtn');
            const actionCards = document.querySelectorAll('.action-card');

            // Toggle sidebar (desktop)
            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

                // Change icon
                const icon = toggleSidebar.querySelector('i');
                if (sidebar.classList.contains('collapsed')) {
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                } else {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                }
            });

            // Toggle sidebar (mobile)
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-visible');
                overlay.classList.toggle('active');
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-visible');
                overlay.classList.remove('active');
            });

            // Navigation
            menuLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active class from all links
                    menuLinks.forEach(item => item.classList.remove('active'));

                    // Add active class to clicked link
                    this.classList.add('active');

                    // Get section to show
                    const sectionId = this.getAttribute('data-section');

                    // Hide all sections
                    document.querySelectorAll('.content-section').forEach(section => {
                        section.classList.remove('active');
                    });

                    // Show selected section
                    document.getElementById(sectionId).classList.add('active');

                    // Close mobile sidebar
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('mobile-visible');
                        overlay.classList.remove('active');
                    }
                });
            });

            // Quick action cards
            actionCards.forEach(card => {
                card.addEventListener('click', function() {
                    const sectionId = this.getAttribute('data-section');

                    // Trigger click on corresponding menu link
                    document.querySelector(`.menu-link[data-section="${sectionId}"]`).click();
                });
            });

            // Logout button
            logoutBtn.addEventListener('click', function() {
                // Simulate logout (in a real app, this would redirect to logout endpoint)
                alert('Logging out...');
                window.location.href = 'login.html';
            });

            // Responsive adjustments
            function handleResize() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('collapsed');
                    sidebar.classList.remove('expanded');
                    mainContent.classList.remove('expanded');
                    mainContent.classList.remove('pushed');
                    mobileToggle.style.display = 'flex';
                } else {
                    mobileToggle.style.display = 'none';
                    sidebar.classList.remove('mobile-visible');
                    overlay.classList.remove('active');
                }
            }

            // Initial call and event listener for resize
            handleResize();
            window.addEventListener('resize', handleResize);
        });
    </script>
</body>

</html>