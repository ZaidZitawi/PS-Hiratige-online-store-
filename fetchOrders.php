<?php
include "header.php";
include 'dbconfig.in.php';

// Check if user is logged 
if (isset($_SESSION["userid"])) {
    $userId = $_SESSION["userid"];

    // Prepared SQL to bring
    $sql = "SELECT o.OrderID, o.OrderDate, o.Status, o.TotalAmount, od.Quantity, od.Price, p.Name
            FROM Orders o
            JOIN OrderDetails od ON o.OrderID = od.OrderID
            JOIN Products p ON od.ProductID = p.ProductID
            WHERE o.CustomerID = :userId";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo '<div id="cart-container">';
        if ($stmt->rowCount() > 0) {
            //  table
            echo "<table id='cart-table'>";
            echo "<thead><tr><th>Order ID</th><th>Product Name</th><th>Quantity</th><th>Order Date</th><th>Price</th><th>Status</th></tr></thead>";
            echo "<tbody>";
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["OrderID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Quantity"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["OrderDate"]) . "</td>";
                echo "<td>$" . htmlspecialchars($row["Price"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["Status"]) . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo '</div>'; //this is cart-container div end
        } else {
            echo "No orders found.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {
    echo "User not logged in.";
}

include "footer.php";
