<?php
include "dbconfig.in.php";
include('header.php');

//this script is for the admin and employee, they has the permission to add products, 


if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != 'Admin') {
    header("Location: home.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $remarks = $_POST['remarks'];

    // Handle the file and add it to the folder images 
    $targetDir = "images/"; //images directory
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    //file types
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            try {
                $pdo->beginTransaction();

                // Insert product 
                $stmt = $pdo->prepare("INSERT INTO Products (Name, Description, Category, Price, Size, Remarks) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $category, $price, $size, $remarks]);

                
                $productId = $pdo->lastInsertId();

                // Insert the product image path into ProductImages table
                $stmt = $pdo->prepare("INSERT INTO ProductImages (ProductID, ImagePath) VALUES (?, ?)");
                $stmt->execute([$productId, $targetFilePath]);

                $pdo->commit();

                echo "<p>Product added successfully.</p>";
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.";
    }
}
?>
<link rel="stylesheet" href="yourstylesheet.css"> 

<form action="addProduct.php" method="post" enctype="multipart/form-data" class="product-form">
    <div class="form-group">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="description" class="form-label">Description:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label for="category" class="form-label">Category:</label>
        <select id="category" name="category" class="form-control" required>
            <option value="New Arrival">New Arrival</option>
            <option value="On Sale">On Sale</option>
            <option value="Featured">Featured</option>
            <option value="High Demand">High Demand</option>
            <option value="Normal">Normal</option>
        </select>
    </div>

    <div class="form-group">
        <label for="price" class="form-label">Price:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01" required>
    </div>

    <div class="form-group">
        <label for="size" class="form-label">Size:</label>
        <input type="text" id="size" name="size" class="form-control">
    </div>

    <div class="form-group">
        <label for="remarks" class="form-label">Remarks:</label>
        <textarea id="remarks" name="remarks" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="image" class="form-label">Product Image:</label>
        <input type="file" id="image" name="image" class="form-control" required>
    </div>

    <button type="submit" class="btn">Add Product</button>
</form>

<?php include("footer.php"); ?>