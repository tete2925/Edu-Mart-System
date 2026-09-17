<?php

require_once "admin_auth.php";

/* dashboard counts */

$category_count = 0;
$product_count = 0;
$stock_count = 0;
$order_count = 0;
$supplier_count = 0;


/* categories */

$category_result = $conn->query("
    SELECT COUNT(*) AS total
    FROM categories
");

if ($category_result) {
    $row = $category_result->fetch_assoc();

    if ($row) {
        $category_count = (int)$row['total'];
    }
}


/* products */

$product_result = $conn->query("
    SELECT COUNT(*) AS total
    FROM products
");

if ($product_result) {
    $row = $product_result->fetch_assoc();

    if ($row) {
        $product_count = (int)$row['total'];
    }
}


/* total stock */

$stock_result = $conn->query("
    SELECT COALESCE(SUM(stock), 0) AS total
    FROM products
");

if ($stock_result) {
    $row = $stock_result->fetch_assoc();

    if ($row) {
        $stock_count = (int)$row['total'];
    }
}


/* orders */

$order_result = $conn->query("
    SELECT COUNT(*) AS total
    FROM orders
");

if ($order_result) {
    $row = $order_result->fetch_assoc();

    if ($row) {
        $order_count = (int)$row['total'];
    }
}


/* suppliers */

$supplier_result = $conn->query("
    SELECT COUNT(*) AS total
    FROM suppliers
");

if ($supplier_result) {
    $row = $supplier_result->fetch_assoc();

    if ($row) {
        $supplier_count = (int)$row['total'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet"
          href="adm.css">

</head>

<body>

<div class="admin-layout">

    <?php include "sidebar.php"; ?>

    <main class="admin-main">

        <div class="admin-topbar">

            <div>

                <p class="dashboard-label">
                    STORE MANAGEMENT
                </p>

                <h1>Dashboard</h1>

            </div>

            <div class="admin-user">

                <i class="fa-solid fa-circle-user"></i>

                <div>

                    <strong>
                        <?= htmlspecialchars($user['name'] ?? 'User') ?>
                    </strong>

                    <span>
                        <?= htmlspecialchars(
                            ucfirst($user['role'] ?? 'staff')
                        ) ?>
                    </span>

                </div>

            </div>

        </div>


        <div class="welcome-panel">

            <div>

                <p class="dashboard-label">
                    WELCOME BACK
                </p>

                <h2>
                    Hello, <?= htmlspecialchars($user['name'] ?? 'User') ?>
                </h2>

                <p>
                    Manage your stationery store from the admin dashboard.
                </p>

            </div>

        </div>


        <div class="dashboard-grid">

            <?php if (has_permission("categories")): ?>

                <!-- categories -->

                <div class="dashboard-card">

                    <div class="dashboard-card-icon">

                        <i class="fa-solid fa-layer-group"></i>

                    </div>

                    <div>

                        <span>
                            Categories
                        </span>

                        <strong>
                            <?= $category_count ?>
                        </strong>

                    </div>

                </div>

            <?php endif; ?>


            <?php if (has_permission("products")): ?>

                <!-- products -->

                <div class="dashboard-card">

                    <div class="dashboard-card-icon">

                        <i class="fa-solid fa-box"></i>

                    </div>

                    <div>

                        <span>
                            Products
                        </span>

                        <strong>
                            <?= $product_count ?>
                        </strong>

                    </div>

                </div>

            <?php endif; ?>


            <?php if (has_permission("inventory")): ?>

                <!-- total stock -->

                <div class="dashboard-card">

                    <div class="dashboard-card-icon">

                        <i class="fa-solid fa-warehouse"></i>

                    </div>

                    <div>

                        <span>
                            Total Stock
                        </span>

                        <strong>
                            <?= $stock_count ?>
                        </strong>

                    </div>

                </div>

            <?php endif; ?>


            <?php if (has_permission("orders")): ?>

                <!-- orders -->

                <div class="dashboard-card">

                    <div class="dashboard-card-icon">

                        <i class="fa-solid fa-cart-shopping"></i>

                    </div>

                    <div>

                        <span>
                            Orders
                        </span>

                        <strong>
                            <?= $order_count ?>
                        </strong>

                    </div>

                </div>

            <?php endif; ?>


            <?php if (has_permission("suppliers")): ?>

                <!-- suppliers -->

                <div class="dashboard-card">

                    <div class="dashboard-card-icon">

                        <i class="fa-solid fa-truck-field"></i>

                    </div>

                    <div>

                        <span>
                            Suppliers
                        </span>

                        <strong>
                            <?= $supplier_count ?>
                        </strong>

                    </div>

                </div>

            <?php endif; ?>

        </div>


        <div class="dashboard-panel">

            <div class="panel-heading">

                <div>

                    <p class="dashboard-label">
                        QUICK ACCESS
                    </p>

                    <h2>Store Management</h2>

                </div>

            </div>


            <div class="quick-actions">

                <?php if (has_permission("categories")): ?>

                    <!-- categories -->

                    <a href="category.php"
                       class="quick-action">

                        <i class="fa-solid fa-layer-group"></i>

                        <span>
                            Categories
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("products")): ?>

                    <!-- products -->

                    <a href="product.php"
                       class="quick-action">

                        <i class="fa-solid fa-box"></i>

                        <span>
                            Products
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("inventory")): ?>

                    

                    <!-- stock in -->

                    <a href="stock_in.php"
                       class="quick-action">

                        <i class="fa-solid fa-arrow-right-to-bracket"></i>

                        <span>
                            Stock In
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("stock_out")): ?>

                    <!-- stock out -->

                    <a href="stock_out.php"
                       class="quick-action">

                        <i class="fa-solid fa-arrow-right-from-bracket"></i>

                        <span>
                            Stock Out
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("suppliers")): ?>

                    <!-- suppliers -->

                    <a href="suppliers.php"
                       class="quick-action">

                        <i class="fa-solid fa-truck-field"></i>

                        <span>
                            Suppliers
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("orders")): ?>

                    <!-- order items -->

                    <a href="order_items.php"
                       class="quick-action">

                        <i class="fa-solid fa-cart-shopping"></i>

                        <span>
                            Order Items
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("delivery_info")): ?>

                    <!-- delivery info -->

                    <a href="delinfo.php"
                       class="quick-action">

                        <i class="fa-solid fa-truck"></i>

                        <span>
                            Delivery Info
                        </span>

                    </a>

                <?php endif; ?>


                <?php if (has_permission("users")): ?>

                    <!-- user management -->

                    <a href="users.php"
                       class="quick-action">

                        <i class="fa-solid fa-users"></i>

                        <span>
                            User Management
                        </span>

                    </a>

                <?php endif; ?>

            </div>

        </div>

    </main>

</div>

</body>

</html>
```
