<?php
include "dbconfig.in.php";
include "header.php";

// Retrieve the order ID from the query string
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="style.css"> <!-- Make sure this path is correct -->
</head>
<body>

<div class="order-confirmation-container">
    <?php if ($orderId): ?>
        <h1>Thank you for your order!</h1>
        <p>Your order with ID <strong><?php echo htmlspecialchars($orderId); ?></strong> is being processed and will be shipped soon.</p>
        <a href="home.php"><button class="custom-button">Return to Home Page</button></a>
    <?php else: ?>
        <p>Order ID is missing. Please check your order history.</p>
        <a href="home.php"><button class="custom-button">Return to Home Page</button></a>
    <?php endif; ?>
</div>

</body>
</html>

<?php
include "footer.php";
?>
