<?php
include "dbconfig.in.php";
include "header.php";

// Handling the addition from productdetails.php
if (isset($_GET['id']) && isset($_GET['quantity'])) {
    $productIdToAdd = $_GET['id'];
    $quantityToAdd = $_GET['quantity'];


    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];//array of product ids
    }

    // Update or add the product quantity in the cart
    if (isset($_SESSION['cart'][$productIdToAdd])) {
        $_SESSION['cart'][$productIdToAdd] += $quantityToAdd;
    } else {
        $_SESSION['cart'][$productIdToAdd] = $quantityToAdd;
    }

    // to dont resubmission
    header("Location: cart.php");
    exit();
}

// Check if the "remove" button is pressed
if (isset($_GET['action']) && $_GET['action'] == "remove") {
    $productIdToRemove = $_GET['product_id'];
    if (isset($_SESSION['cart'][$productIdToRemove])) {
        unset($_SESSION['cart'][$productIdToRemove]);
    }
    header("Location: cart.php");
    exit();
}
$totalPrice = 0;


if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    $productIds = array_keys($_SESSION['cart']);
    $placeholders = implode(',', array_fill(0, count($productIds), '?'));


    $query = "SELECT p.*, pi.ImagePath FROM Products p LEFT JOIN ProductImages pi ON p.ProductID = pi.ProductID WHERE p.ProductID IN ($placeholders)";
    $stmt = $pdo->prepare($query);
    $stmt->execute($productIds);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<div id="cart-container">';
    echo '<table id="cart-table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Product</th>';
    echo '<th>Price</th>';
    echo '<th>Quantity</th>';
    echo '<th>Total</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($cartItems as $item) {
        $itemTotal = $_SESSION['cart'][$item['ProductID']] * $item['Price'];
        $totalPrice += $itemTotal;
        echo "<tr class='cart-item'>";
        echo "<td class='product-cell'><img class='product-image' src='" . htmlspecialchars($item['ImagePath']) . "' alt='Product Image' width='50' height='50'>" . htmlspecialchars($item['Name']) . "</td>";
        echo "<td class='price-cell'>$" . htmlspecialchars($item['Price']) . "</td>";
        echo "<td class='quantity-cell'>" . $_SESSION['cart'][$item['ProductID']] . "</td>";
        echo "<td class='total-cell'>$" . number_format($itemTotal, 2) . "</td>";
        echo "<td class='action-cell'><a class='remove-link' href='cart.php?action=remove&product_id=" . $item['ProductID'] . "'>Remove</a></td>";
        echo "</tr>";
    }
    echo "<tr class='total-row'>";
    echo "<td colspan='3'>Total</td>";
    echo "<td colspan='2'>$" . number_format($totalPrice, 2) . "</td>";
    echo "</tr>";
    echo '</tbody>';
    echo '</table>';

    echo "<div id='cart-actions'>";
    echo "<a href='checkout.php' class='custom-button'>Checkout</a>";
    echo "<a href='home.php' class='custom-button'>Return to Home Page</a>";
    echo "</div>"; // cart-actions div
    echo '</div>'; // cart-container div
} else {
    echo "<p>Your cart is empty.</p>";
}


function addOrUpdateCartItem($userId, $productId, $quantity, $pdo)
{
    $stmt = $pdo->prepare("SELECT Quantity FROM CartItems WHERE UserID = ? AND ProductID = ?");
    $stmt->execute([$userId, $productId]);
    if ($row = $stmt->fetch()) {
        $newQuantity = $row['Quantity'] + $quantity;
        $updateStmt = $pdo->prepare("UPDATE CartItems SET Quantity = ? WHERE UserID = ? AND ProductID = ?");
        $updateStmt->execute([$newQuantity, $userId, $productId]);
    } else {
        $insertStmt = $pdo->prepare("INSERT INTO CartItems (UserID, ProductID, Quantity) VALUES (?, ?, ?)");
        $insertStmt->execute([$userId, $productId, $quantity]);
    }
}

function removeCartItem($userId, $productId, $pdo)
{
    $stmt = $pdo->prepare("DELETE FROM CartItems WHERE UserID = ? AND ProductID = ?");
    $stmt->execute([$userId, $productId]);
}

function fetchCartItems($userId, $pdo)
{
    $stmt = $pdo->prepare("SELECT p.ProductID, p.Name, p.Price, ci.Quantity, pi.ImagePath 
                        FROM CartItems ci 
                        JOIN Products p ON ci.ProductID = p.ProductID 
                        LEFT JOIN ProductImages pi ON p.ProductID = pi.ProductID 
                        WHERE ci.UserID = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
include "footer.php";
