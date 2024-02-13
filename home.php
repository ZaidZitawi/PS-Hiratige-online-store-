<?php
include('dbconfig.in.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="headerandfooter.css">
</head>

<body>
    <div id="pageWrapper">
        <nav class="sidebarNavigation">
            <div class="logoStatementContainer">
                <div class="navLogo">
                    <img src="images\palestine (1).png" alt="Logo" width="50" height="50" />
                </div>
                <div class="logoStatementText">
                    <p>Palestinian Handmade</p>
                </div>
            </div>
            <hr class="navSeparator" /><br><br>
            <ul class="menuItems">
                <?php
                if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'Admin') {
                    echo "<li><a href='addEmployee.php' class='navItem'>Add Employee</a></li><br>";
                    echo "<li><a href='addProduct.php' class='navItem'>Add Product</a></li><br>";
                }
                ?>
                <?php if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'Employee') : ?>
                    <li><a href='addProduct.php' class='navItem'>Add Product</a></li><br>
                <?php endif; ?>
                <li><a href="search_product.php" class="navItem">Search Product</a></li><br>
                <li><a href="fetchOrders.php" class="navItem">View Order</a></li><br>
                <li><a href="log.php" class="navItem">Login</a></li><br>
                <li><a href="signup.php" class="navItem">Sign UP</a></li><br>
                <li><a href="log.php?destroy=true" class="navItem">Log out</a></li>
            </ul>
        </nav>

        <section class="contentArea">
            <?php
            $query = "SELECT Products.ProductID, Products.Name, Products.Description, Products.Price, ProductImages.ImagePath 
            FROM Products 
            LEFT JOIN ProductImages ON Products.ProductID = ProductImages.ProductID";

            $result = $pdo->query($query);

            if ($result->rowCount() > 0) {
                while ($product = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<a href="productdetails.php?id=' . htmlspecialchars($product['ProductID']) . '" class="product-link">';
                    // Cards for each product
                    echo '<div class="card">';
                    // Product image
                    echo '<div class="card-img">';
                    echo '<img src="' . htmlspecialchars($product['ImagePath']) . '" alt="' . htmlspecialchars($product['Name']) . '" style="width:100%;">'; // Make sure the image covers the card-img div
                    echo '</div>';
                    // Product info
                    echo '<div class="card-info">';
                    echo '<p class="text-title">' . htmlspecialchars($product['Name']) . '</p>';
                    echo '</div>';
                    // Card footer
                    echo '<div class="card-footer">';
                    echo '<span class="text-title">$' . htmlspecialchars($product['Price']) . '</span>';
                    echo '<svg class="svg-icon" viewBox="0 0 20 20">';
                    echo '</svg>';
                    echo '</div>'; // Close card-footer
                    echo '</div>'; // Close card
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </section>


    </div>
</body>

</html>

<?php
include("footer.php"); 
?>