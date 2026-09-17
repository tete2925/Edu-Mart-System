```php
<?php

require_once "admin_auth.php";

require_permission("stock_in");

$products = $conn->query("
    SELECT id, name, stock
    FROM products
    ORDER BY name
");

$suppliers = $conn->query("
    SELECT id, name
    FROM suppliers
    ORDER BY name
");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $product_id = intval($_POST['product_id'] ?? 0);
    $quantity = intval($_POST['quantity'] ?? 0);
    $supplier_id = intval($_POST['supplier_id'] ?? 0);

    if ($product_id <= 0 || $quantity <= 0 || $supplier_id <= 0) {

        $error = "Please select a product, enter a quantity, and select a supplier.";

    } else {

        $supplier_name = "";

        $supplier_stmt = $conn->prepare("
            SELECT name
            FROM suppliers
            WHERE id = ?
        ");

        if (!$supplier_stmt) {

            $error = "Could not prepare supplier query.";

        } else {

            $supplier_stmt->bind_param(
                "i",
                $supplier_id
            );

            $supplier_stmt->execute();

            $supplier_stmt->bind_result($supplier_name);

            if (!$supplier_stmt->fetch()) {
                $error = "Selected supplier was not found.";
            }

            $supplier_stmt->close();
        }

        if ($error === "") {

            $conn->begin_transaction();

            try {

                // add stock-in record
                $stmt = $conn->prepare("
                    INSERT INTO stock_in
                    (product_id, quantity, note)
                    VALUES (?, ?, ?)
                ");

                if (!$stmt) {
                    throw new Exception(
                        "Could not prepare stock-in query: " . $conn->error
                    );
                }

                $stmt->bind_param(
                    "iis",
                    $product_id,
                    $quantity,
                    $supplier_name
                );

                if (!$stmt->execute()) {
                    throw new Exception(
                        "Could not add stock-in record: " . $stmt->error
                    );
                }

                $stmt->close();

                // update product stock
                $stmt = $conn->prepare("
                    UPDATE products
                    SET stock = stock + ?
                    WHERE id = ?
                ");

                if (!$stmt) {
                    throw new Exception(
                        "Could not prepare stock update query: " . $conn->error
                    );
                }

                $stmt->bind_param(
                    "ii",
                    $quantity,
                    $product_id
                );

                if (!$stmt->execute()) {
                    throw new Exception(
                        "Could not update product stock: " . $stmt->error
                    );
                }

                $stmt->close();

                $conn->commit();

                header("Location: stock_in.php");
                exit();

            } catch (Exception $e) {

                $conn->rollback();

                $error = $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Stock In</title>

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
INVENTORY
</p>

<h1>Stock In</h1>

</div>

</div>


<div class="dashboard-panel">

<div class="admin-form">

<?php if ($error !== ""): ?>

<div class="form-error">
<?= htmlspecialchars($error) ?>
</div>

<?php endif; ?>


<form method="POST">

<div class="form-group">

<label>Product</label>

<select name="product_id" required>

<option value="">
Select Product
</option>

<?php if ($products): ?>

<?php while ($product = $products->fetch_assoc()): ?>

<option value="<?= $product['id'] ?>">

<?= htmlspecialchars($product['name']) ?>

</option>

<?php endwhile; ?>

<?php endif; ?>

</select>

</div>


<div class="form-group">

<label>Quantity Received</label>

<input
    type="number"
    name="quantity"
    min="1"
    required
>

</div>


<div class="form-group">

<label>Supplier</label>

<select name="supplier_id" required>

<option value="">
Select Supplier
</option>

<?php if ($suppliers): ?>

<?php while ($supplier = $suppliers->fetch_assoc()): ?>

<option value="<?= $supplier['id'] ?>">

<?= htmlspecialchars($supplier['name']) ?>

</option>

<?php endwhile; ?>

<?php endif; ?>

</select>

</div>


<div class="form-actions">

<button
    type="submit"
    class="admin-button"
>
Save Stock In
</button>

<a
    href="stock_in.php"
    class="cancel-button"
>
Cancel
</a>

</div>

</form>

</div>

</div>

</main>

</div>

</body>

</html>
```
