<?php
include "dbconfig.in.php";
include "header.php";


if (!isset($_SESSION['userid']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p>Your cart is empty or you are not logged in.</p>";
    include "footer.php";
    exit();
}

$userId = $_SESSION['userid']; 
$stmt = $pdo->prepare("SELECT COUNT(*) FROM CustomerDetails WHERE CustomerID = ?");
$stmt->execute([$userId]);
if ($stmt->fetchColumn() == 0) {
    echo "<p>Please complete your customer profile before checking out.</p>";
    include "footer.php";
    exit();
}

try {
    $pdo->beginTransaction();
    $totalAmount = 0;
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $productPrice = $pdo->query("SELECT Price FROM Products WHERE ProductID = " . $pdo->quote($productId))->fetchColumn();
        $totalAmount += $productPrice * $quantity;
    }

    
    // Insert into Orders table
    $insertOrderSql = "INSERT INTO Orders (CustomerID, OrderDate, Status, TotalAmount) VALUES (?, NOW(), 'Shipped', ?)";
    $stmt = $pdo->prepare($insertOrderSql);
    $stmt->execute([$userId, $totalAmount]);
    
    $orderId = $pdo->lastInsertId();
    
    
    // Insert into OrderDetails table for each product in the cart
    $insertDetailSql = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)";
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        $productPrice = $pdo->query("SELECT Price FROM Products WHERE ProductID = " . $pdo->quote($productId))->fetchColumn();
        $stmt = $pdo->prepare($insertDetailSql);
        $stmt->execute([$orderId, $productId, $quantity, $productPrice]);
    }
    
    $pdo->commit();
    
    $_SESSION['cart'] = [];

    header('Location: orderConfirmation.php?orderId=' . $orderId);
    exit();

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
    include "footer.php";
}

?>
