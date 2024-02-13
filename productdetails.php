<?php
include "dbconfig.in.php";
include "header.php";

$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;


if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $query = "SELECT * FROM Products WHERE ProductID = :productid";

    if ($stmt = $pdo->prepare($query)) {
        $stmt->bindParam(':productid', $param_id);


        $param_id = trim($_GET['id']);


        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $product = $stmt->fetch(PDO::FETCH_ASSOC);


                $imagesQuery = "SELECT ImagePath FROM ProductImages WHERE ProductID = :productid";
                if ($imagesStmt = $pdo->prepare($imagesQuery)) {
                    $imagesStmt->bindParam(':productid', $param_id);
                    if ($imagesStmt->execute()) {
                        $images = $imagesStmt->fetchAll(PDO::FETCH_ASSOC);
                    } else {
                        $images = [];
                    }
                }
            } else {
                echo "Error: No product found with that ID.";
                $product = null;
            }
        } else {
            echo "Error: Could not execute the query.";
            $product = null;
        }
    } else {
        echo "Error: Could not prepare the query.";
        $product = null;
    }
} else {
    //there is no product in the url
    echo "Error: Product ID is not specified.";
    $product = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="headerandfooter.css">
</head>

<body>

    <div class="product-container">
        <?php if (isset($product) && $product != null) : ?>
            <div class="center-wrapper">
                <div class="pcard">
                    <div class="image">
                        <?php foreach ($images as $image) : ?>
                            <img src="<?php echo htmlspecialchars($image['ImagePath']); ?>" alt="Product Image" width="150" height="150">
                        <?php endforeach; ?>
                        <span class="text"><?php echo htmlspecialchars($product['Name']); ?></span>
                    </div>
                </div>
                <div class="product-details">
                    <h1 class="product-title"><?php echo htmlspecialchars($product['Name']); ?></h1>
                    <ul class="details-list">
                        <li><strong>Description:</strong> <?php echo htmlspecialchars($product['Description']); ?></li>
                        <li><strong>Category:</strong> <?php echo htmlspecialchars($product['Category']); ?></li>
                        <li><strong>Price:</strong> $<?php echo htmlspecialchars($product['Price']); ?></li>
                        <li><strong>Size:</strong> <?php echo htmlspecialchars($product['Size']); ?></li>
                        <li><strong>Remarks:</strong> <?php echo htmlspecialchars($product['Remarks']); ?></li>
                    </ul>
                    <?php if ($userId) : // Check if user is logged in 
                    ?>
                        <form action="cart.php" method="GET">
                            <input type="hidden" name="id" value="<?php echo $product['ProductID']; ?>">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" required>
                            <br>
                            <button type="submit" class="custom-button">Add To Cart</button>
                        </form>
                        <form action="orderProduct.php" method="GET">
                            <input type="hidden" name="id" value="<?php echo $product['ProductID']; ?>">
                            <input type="hidden" id="quantity" name="quantity" value="1">
                            <button type="submit" class="custom-button">Order Directly</button>
                        </form>
                    <?php else : ?>
                        <p class="error">Please <a href="log.php">log in</a> first to start the buying process.</p>
                    <?php endif; ?>
                    <a href="home.php"><button class="custom-button">Return to Home Page</button></a>
                </div>
            <?php else : ?>
                <p>Product details not found.</p>
            <?php endif; ?>
            </div>
    </div>

</body>

</html>



<?php
include "footer.php";
?>