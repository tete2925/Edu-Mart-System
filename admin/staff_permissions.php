<?php

require_once "admin_auth.php";

    if (($user['role'] ?? '') !== 'owner') {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit();
}

$staff_id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT id, name, email, role
    FROM users
    WHERE id = ?
    LIMIT 1
");

$stmt->bind_param("i", $staff_id);
$stmt->execute();

$result = $stmt->get_result();
$staff = $result->fetch_assoc();

$stmt->close();

if (!$staff || $staff['role'] !== 'staff') {
    header("Location: users.php");
    exit();
}

$permissions = [
    'categories' => 'Categories',
    'products' => 'Products',
    'inventory' => 'Inventory',
    'stock_in' => 'Stock In',
    'stock_out' => 'Stock Out',
    'suppliers' => 'Suppliers',
    'orders' => 'Orders'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $conn->begin_transaction();

    try {

        $delete = $conn->prepare("
            DELETE FROM staff_permissions
            WHERE user_id = ?
        ");

        $delete->bind_param("i", $staff_id);
        $delete->execute();
        $delete->close();

        if (isset($_POST['permissions']) && is_array($_POST['permissions'])) {

            $insert = $conn->prepare("
                INSERT INTO staff_permissions
                (user_id, permission)
                VALUES (?, ?)
            ");

            foreach ($_POST['permissions'] as $permission) {

                if (array_key_exists($permission, $permissions)) {

                    $insert->bind_param(
                        "is",
                        $staff_id,
                        $permission
                    );

                    $insert->execute();
                }
            }

            $insert->close();
        }

        $conn->commit();

        header("Location: staff_permissions.php?id=" . $staff_id . "&saved=1");
        exit();

    } catch (Exception $e) {

        $conn->rollback();

        $error = "Failed to save permissions.";
    }
}

$current_permissions = [];

$stmt = $conn->prepare("
    SELECT permission
    FROM staff_permissions
    WHERE user_id = ?
");

$stmt->bind_param("i", $staff_id);
$stmt->execute();

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $current_permissions[] = $row['permission'];
}

$stmt->close();

?>
<!DOCTYPE html>
<html>
<head>

    <title>Staff Permissions</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

    <link rel="stylesheet" href="adm.css">

</head>

<body>

<div class="admin-layout">

    <?php include "sidebar.php"; ?>

    <main class="admin-main">

        <div class="admin-topbar">

            <div>

                <p class="dashboard-label">
                    ACCOUNT MANAGEMENT
                </p>

                <h1>Staff Permissions</h1>

            </div>

            <a href="users.php" class="admin-button">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Users
            </a>

        </div>


        <div class="dashboard-panel">

            <h2>
                <?= htmlspecialchars($staff['name']) ?>
            </h2>

            <p>
                <?= htmlspecialchars($staff['email']) ?>
            </p>


            <?php if (isset($_GET['saved'])): ?>

                <p>
                    Permissions saved successfully.
                </p>

            <?php endif; ?>


            <?php if (isset($error)): ?>

                <p>
                    <?= htmlspecialchars($error) ?>
                </p>

            <?php endif; ?>


            <form method="POST">

                <div class="admin-table-wrapper">

                    <table class="admin-table">

                        <thead>

                            <tr>
                                <th>Permission</th>
                                <th>Allow</th>
                            </tr>

                        </thead>

                        <tbody>

                        <?php foreach ($permissions as $key => $label): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($label) ?>
                                </td>

                                <td>

                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="<?= htmlspecialchars($key) ?>"
                                        <?= in_array($key, $current_permissions, true) ? 'checked' : '' ?>
                                    >

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


                <br>

                <button type="submit" class="admin-button">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Save Permissions
                </button>

            </form>

        </div>

    </main>

</div>

</body>
</html>