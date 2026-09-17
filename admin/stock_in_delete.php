<?php

require_once "admin_auth.php";

require_permission("stock_in");


$id = intval($_GET['id'] ?? 0);


if ($id > 0) {

    $stmt = $conn->prepare("
    SELECT product_id, quantity
    FROM stock_in
    WHERE id = ?
    LIMIT 1
");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $row = $stmt->get_result()->fetch_assoc();


    if ($row) {

        $conn->begin_transaction();

        try {

            /*
             * Remove the stock that this IN movement added.
             */

            $stmt = $conn->prepare("
                UPDATE products
                SET stock = stock - ?
                WHERE id = ?
                AND stock >= ?
            ");

            $stmt->bind_param(
                "iii",
                $row['quantity'],
                $row['product_id'],
                $row['quantity']
            );

            $stmt->execute();


            if ($stmt->affected_rows === 0) {
                throw new Exception(
                    "Cannot delete this stock-in record because the current stock is too low."
                );
            }


            /*
             * Delete movement.
             */

            $stmt = $conn->prepare("
    DELETE FROM stock_in
    WHERE id = ?
");

            $stmt->bind_param("i", $id);
            $stmt->execute();


            $conn->commit();

        } catch (Exception $e) {

            $conn->rollback();
        }
    }
}


header("Location: stock_in.php");
exit();