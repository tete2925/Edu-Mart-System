<?php
include "includes/header.php";


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "
    SELECT
        o.id,
        o.total_amount,
        o.status AS order_status,
        o.fulfillment_type,
        o.payment_method,
        o.created_at,
        d.status AS delivery_status,
        d.shipping_method,
        d.delivery_fee
    FROM orders o
    LEFT JOIN delivery d ON o.id = d.order_id
    WHERE o.user_id = ?
    ORDER BY o.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - EduMart</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff7fb;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        

        h1 {
            margin-bottom: 25px;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .order-id {
            font-size: 20px;
            font-weight: bold;
        }

        .status {
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .pending {
            background: #fbbaa8;
            color: #bb250a;
        }

        .confirmed {
            background: #d4edda;
            color: #155724;
        }

        .done {
            background: #d4edda;
            color: #155724;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }

        .info-box {
            background: #fafafa;
            padding: 12px;
            border-radius: 8px;
        }

        .items {
            margin-top: 15px;
        }

        .items h3 {
            margin-bottom: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
        }

        .message {
            margin-top: 15px;
            padding: 12px;
            border-radius: 8px;
            background: #eaf7ee;
            color: #176b35;
        }

        .empty {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 12px;
        }

        @media (max-width: 700px) {
            body {
                padding: 15px;
            }

            .order-info {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>


<div class="container" style="margin-top: 40px; margin-bottom: 80px;">


    <h1>Order History</h1>

    <?php if ($orders->num_rows === 0): ?>

        <div class="empty">
            <h3>No orders yet</h3>
            <p>Your previous orders will appear here.</p>
        </div>

    <?php else: ?>

        <?php while ($order = $orders->fetch_assoc()): ?>

            <div class="order-card">

                <div class="order-header">

                    <div class="order-id">
                        Order #<?= htmlspecialchars($order['id']) ?>
                    </div>

                    <?php
                    $order_status = strtolower($order['order_status']);
                    ?>

                    <span class="status <?= $order_status === 'confirmed' ? 'confirmed' : 'pending' ?>">
                        <?= htmlspecialchars($order['order_status']) ?>
                    </span>

                </div>

                <div class="order-info">

                    <div class="info-box">
                        <strong>Date:</strong><br>
                        <?= htmlspecialchars($order['created_at']) ?>
                    </div>

                    <div class="info-box">
                        <strong>Fulfillment:</strong><br>
                        <?= htmlspecialchars($order['fulfillment_type']) ?>
                    </div>

                    <div class="info-box">
                        <strong>Payment:</strong><br>
                        <?= htmlspecialchars($order['payment_method']) ?>
                    </div>

                    <?php if ($order['fulfillment_type'] === 'Delivery'): ?>
    <div class="info-box">
        <strong>Delivery Status:</strong><br>

        <?php
        $delivery_status = $order['delivery_status'] ?? 'Pending';
        ?>

        <span
            class="status <?= strtolower($delivery_status) === 'done' ? 'done' : 'pending' ?>"
            style="display: inline-block; margin-top: 8px;"
        >
            <?= htmlspecialchars($delivery_status) ?>
        </span>
    </div>
<?php endif; ?>

                </div>

                <div class="items">

                    <h3>Items</h3>

                    <?php
                    $order_id = $order['id'];

                    $item_sql = "
                        SELECT
                            oi.quantity,
                            oi.price,
                            p.name
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        WHERE oi.order_id = ?
                    ";

                    $item_stmt = $conn->prepare($item_sql);
                    $item_stmt->bind_param("i", $order_id);
                    $item_stmt->execute();

                    $items = $item_stmt->get_result();
                    ?>

                    <?php while ($item = $items->fetch_assoc()): ?>

                        <div class="item">
                            <span>
                                <?= htmlspecialchars($item['name']) ?>
                                × <?= htmlspecialchars($item['quantity']) ?>
                            </span>

                            <span>
                                <?= number_format($item['price'] * $item['quantity']) ?> Ks
                            </span>
                        </div>

                    <?php endwhile; ?>

                </div>

                <div class="total">
                    Total:
                    <?= number_format($order['total_amount']) ?> Ks
                </div>

                <?php if (strtolower($order['order_status']) === 'confirmed'): ?>

                    <div class="message">
                        ✓ Your order has been confirmed by EduMart.
                    </div>

                <?php else: ?>

                    <div class="message" style="background:#ffe5e5; color:#d00000;">
                        Your order is waiting for confirmation.
                    </div>

                <?php endif; ?>

            </div>

        <?php endwhile; ?>

    <?php endif; ?>

</div>

</body>
</html>


<?php

include "includes/footer.php";

?>