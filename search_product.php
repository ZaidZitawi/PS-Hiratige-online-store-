<?php
include('dbconfig.in.php');
include('header.php');

// Check for sort order from query parameters or cookies
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : (isset($_COOKIE['sortOrder']) ? $_COOKIE['sortOrder'] : 'ProductID');
setcookie('sortOrder', $sortOrder, time() + 86400); // rem sortOrder for 1 day

$productName = isset($_GET['productName']) ? "%" . $_GET['productName'] . "%" : "%";
$minPrice = isset($_GET['minPrice']) ? (float)$_GET['minPrice'] : 0;
$maxPrice = isset($_GET['maxPrice']) ? (float)$_GET['maxPrice'] : PHP_INT_MAX;

// Prepare the SQL query with dynamic ordering
$query = $pdo->prepare("SELECT ProductID, Name, Price, Category FROM Products WHERE Name LIKE :productName AND Price BETWEEN :minPrice AND :maxPrice ORDER BY $sortOrder");
$query->bindParam(':productName', $productName);
$query->bindParam(':minPrice', $minPrice);
$query->bindParam(':maxPrice', $maxPrice);
$query->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
    <link rel="stylesheet" href="headerandfooter.css">
</head>

<body>
    <div id="cart-container">
        <form action="search_product.php" method="get">
            <div class="form-group">
                <label for="productName" class="input-label">Product Name:</label>
                <input type="text" class="input1" name="productName" class="input-field">
            </div>

            <div class="form-group">
                <label for="minPrice" class="input-label">Minimum Price:</label>
                <input type="number" class="input1" name="minPrice" min="0" step="0.01" >
            </div>

            <div class="form-group">
                <label for="maxPrice" class="input-label">Maximum Price:</label>
                <input type="number" class="input1" name="maxPrice" min="0" step="0.01" ">
            </div>


            <button type="submit">Search</button>
        </form>

        <?php if ($query->rowCount() > 0) : ?>
            <table id="cart-table">
                <thead>
                    <tr>
                        <th>Shortlist</th>
                        <th><a href="?sort=ProductID">product ID.</a></th>
                        <th><a href="?sort=Name">Name</a></th>
                        <th><a href="?sort=Price">Price</a></th>
                        <th><a href="?sort=Category">Category</a></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $query->fetch(PDO::FETCH_ASSOC)) : ?>
                        <tr class="<?php echo htmlspecialchars(strtolower($row['Category'])); ?>">
                            <td><input type='checkbox' name='shortlist[]' value='<?php echo htmlspecialchars($row['ProductID']); ?>'></td>
                            <td><a href='productdetails.php?id=<?php echo htmlspecialchars($row['ProductID']); ?>'><?php echo htmlspecialchars($row['ProductID']); ?></a></td>
                            <td><?php echo htmlspecialchars($row['Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Price']); ?></td>
                            <td><?php echo htmlspecialchars($row['Category']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</body>

</html>

<?php include("footer.php"); ?>