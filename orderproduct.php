<?php
session_start();
include "dbconfig.in.php";


if (isset($_SESSION['userid']) && isset($_GET['id'])) {
    $userId = $_SESSION['userid'];
    $productId = $_GET['id'];
    $quantity = 1;

    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Insert into Orders table
        $orderStmt = $pdo->prepare("INSERT INTO Orders (CustomerID, OrderDate, Status, TotalAmount) VALUES (?, NOW(), 'Shipped', (SELECT Price FROM Products WHERE ProductID = ?))");
        $orderStmt->execute([$userId, $productId]);

        // Get the last inserted order ID
        $orderId = $pdo->lastInsertId();

        // Insert into OrderDetails table
        $detailsStmt = $pdo->prepare("INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, (SELECT Price FROM Products WHERE ProductID = ?))");
        $detailsStmt->execute([$orderId, $productId, $quantity, $productId]);

        // Commit transaction
        $pdo->commit();

        // Redirect to a confirmation page or back to the cart
        header("Location: successPage.php?order=$orderId");
        exit();
    } catch (Exception $e) {
        // An error occurred, rollback transaction
        $pdo->rollback();
        // Handle the exception
        die("Error: " . $e->getMessage());
    }
} else {
    // Redirect the user to login page if not logged in
    header("Location: log.php");
    exit();
}
