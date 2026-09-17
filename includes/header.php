
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/db.php";

/* Check login status */
$is_logged_in = isset($_SESSION["user_id"]);
$user_name = $_SESSION["user_name"] ?? "";

/* Get cart count */
$cart_count = 0;

if (isset($_SESSION["cart"]) && is_array($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $item) {
        $cart_count += (int)($item["quantity"] ?? 0);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EduMart Student Stationery</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <!-- Existing CSS -->
    <link rel="stylesheet" href="/stationary/css/style.css">

    <style>

        /* Container */

        .container {
            width: 94%;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */

        .header-content {
            min-height: 85px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        /* Logo */

        .logo {
            font-size: 20px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .logo a {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .logo-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #d71920;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .logo strong {
            color: #d71920;
        }

        /* Search */

        .search-box {
            display: flex;
            width: 420px;
            height: 42px;
            border: 1px solid #ddd;
            flex-shrink: 1;
        }

        .search-box input {
            flex: 1;
            min-width: 0;
            border: none;
            outline: none;
            padding: 0 15px;
        }

        .search-box button {
            width: 50px;
            flex-shrink: 0;
            border: none;
            background: #d71920;
            color: white;
            cursor: pointer;
        }

        /* Actions */

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-shrink: 0;
        }

        .cart-link {
            position: relative;
        }

        #cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #d71920;
            color: white;
            font-size: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Navigation */

        .nav-content {
            min-height: 48px;
            display: flex;
            align-items: center;
            gap: 35px;
        }

        /* Responsive */

        @media (max-width: 900px) {

            .header-content {
                flex-wrap: wrap;
                padding: 20px 0;
            }

            .logo {
                order: 1;
            }

            .header-actions {
                order: 2;
            }

            .search-box {
                order: 3;
                width: 100%;
            }

        }

        @media (max-width: 650px) {

            .container {
                width: 92%;
            }

            .logo a {
                white-space: normal;
            }

            .logo {
                font-size: 18px;
            }

            .header-actions {
                gap: 15px;
            }

            .nav-content {
                gap: 20px;
                flex-wrap: wrap;
                padding: 8px 0;
            }

            .nav-content a {
                padding: 8px 0;
            }

        }

    </style>

</head>

<body>

<!-- Main Header -->

<header class="main-header">

    <div class="container header-content">

        <!-- Logo -->

        <div class="logo">

            <a href="/stationary/index.php">

                <span class="logo-icon">
                    <i class="fa-solid fa-book"></i>
                </span>

                <span>
                    Edu<strong>Mart</strong>
                </span>

            </a>

        </div>

        <!-- Search -->

        <form
            class="search-box"
            action="/stationary/products.php"
            method="GET"
        >

            <input
                type="text"
                name="search"
                placeholder="Search products..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
            >

            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

        </form>

        <!-- Header Actions -->

        <div class="header-actions">

            <!-- Account -->

            <a
                href="<?= $is_logged_in ? '/stationary/auth/profile.php' : '/stationary/auth/login.php' ?>"
                class="cart-link"
                title="<?= $is_logged_in ? 'Account' : 'Login' ?>"
            >

                <i class="fa-solid fa-user"></i>

                <?php if ($is_logged_in): ?>

                    <span>
                        <?= htmlspecialchars($user_name) ?>
                    </span>

                <?php endif; ?>

            </a>

            <!-- Cart -->

            <a
                href="/stationary/cart.php"
                class="cart-link"
                title="Shopping Cart"
            >

                <i class="fa-solid fa-cart-shopping"></i>

                <span id="cart-count">
                    <?= $cart_count ?>
                </span>

            </a>

            <?php if ($is_logged_in): ?>


              

<!-- Order History -->
<?php if ($is_logged_in): ?>
    <a
        href="/stationary/order_history.php"
        class="order-history-link"
        title="Order History"
        style="color: red !important;"
    >
        <i
            class="fa-solid fa-clock-rotate-left"
            style="color: red !important;"
        ></i>
    </a>
<?php endif; ?>



                <!-- Logout -->

                <a
                    href="/stationary/auth/logout.php"
                    class="cart-link"
                    title="Logout"
                >

                    <i class="fa-solid fa-right-from-bracket"></i>

                </a>

            <?php endif; ?>

        </div>

    </div>

</header>

<!-- Navigation -->

<nav class="navigation">

    <div class="container nav-content">

        <a href="/stationary/index.php">
            Home
        </a>

        <a href="/stationary/primary.php">
            Primary School
        </a>

        <a href="/stationary/highsch.php">
            High School
        </a>

        <a href="/stationary/uni.php">
            University
        </a>

        <a href="/stationary/products.php">
            All Products
        </a>

    </div>

</nav>

