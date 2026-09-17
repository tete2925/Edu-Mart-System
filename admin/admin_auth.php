<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../includes/db.php";

if (
    !isset($_SESSION['user_id']) &&
    !isset($_SESSION['user_email'])
) {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($conn) || !$conn) {
    die("Database connection failed. Please check includes/db.php.");
}

$user = null;

if (isset($_SESSION['user_id'])) {
    $user_id = intval($_SESSION['user_id']);

    $stmt = $conn->prepare("
        SELECT id, name, email, role
        FROM users
        WHERE id = ?
        LIMIT 1
    ");

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
        }

        $stmt->close();
    }
}

if (!$user && isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];

    $stmt = $conn->prepare("
        SELECT id, name, email, role
        FROM users
        WHERE email = ?
        LIMIT 1
    ");

    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result) {
            $user = $result->fetch_assoc();
        }

        $stmt->close();
    }
}

if (!$user || !is_array($user)) {
    session_unset();
    session_destroy();

    header("Location: ../auth/login.php");
    exit();
}

if (
    $user['role'] !== 'owner' &&
    $user['role'] !== 'staff'
) {
    header("Location: ../index.php");
    exit();
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];
$_SESSION['user_role'] = $user['role'];


function has_permission(string $permission): bool
{
    global $user, $conn;

    if (
        !isset($user) ||
        !is_array($user) ||
        !isset($user['role'])
    ) {
        return false;
    }

    if ($user['role'] === 'owner') {
        return true;
    }

    if ($user['role'] !== 'staff') {
        return false;
    }

    $user_id = intval($user['id']);

    $stmt = $conn->prepare("
        SELECT id
        FROM staff_permissions
        WHERE user_id = ?
        AND permission = ?
        LIMIT 1
    ");

    if (!$stmt) {
        return false;
    }

    $stmt->bind_param(
        "is",
        $user_id,
        $permission
    );

    $stmt->execute();

    $result = $stmt->get_result();

    $has_permission = $result && $result->num_rows > 0;

    $stmt->close();

    return $has_permission;
}


function require_permission(string $permission): void
{
    if (!has_permission($permission)) {
        header("Location: index.php");
        exit();
    }
}
?>