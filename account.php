<?php
include("dbconfig.in.php");
include("header.php");

// Check user is loged
if (!isset($_SESSION['userid'])) {
    echo "User not logged in.";
    include("footer.php");
    exit();
}

// take the userid from the session
$userId = $_SESSION['userid'];

$sql = "SELECT u.UserID, u.Username, u.Email, u.fullname, u.DateOfBirth, u.Telephone, 
            cd.Country, cd.City, cd.Address, cd.CountryID, cd.CreditCardNumber, 
            cd.CreditCardExpiration, cd.CreditCardName, cd.BankIssued 
        FROM users u
        LEFT JOIN customerdetails cd ON u.UserID = cd.CustomerID
        WHERE u.UserID = :userId";//left join for handling that the user doesn't have customer details, it print them and give them null value

$result = []; 

try {
    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    include("footer.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="headerandfooter.css">
    <title>Account Information</title>
    <style>
        .contentArea ul {
            list-style: none;
            padding: 0;
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .contentArea ul li {
            padding: 10px 15px;
            border-bottom: 1px solid #eee;
        }

        .contentArea ul li:last-child {
            border: none;
        }

        .contentArea ul li strong {
            font-weight: bold;
            margin-right: 5px;
            color: #333;
        }

        .contentArea {
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
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
                <li><a href="search_product.php" class="navItem">Search Product</a></li><br>
                <li><a href="view_order.php" class="navItem">View Order</a></li>
                <li><a href="signup.php" class="navItem">Login</a></li><br>
                <li><a href="signup.php" class="navItem">Sign UP</a></li><br>
                <li><a href="log.php?destroy=true" class="navItem">Log out</a></li>
            </ul>
        </nav>
        <section class="contentArea">
            <?php if ($result) : ?>
                <ul>
                    <li><strong>User ID:</strong> <?= htmlspecialchars($result['UserID']); ?></li>
                    <li><strong>Username:</strong> <?= htmlspecialchars($result['Username']); ?></li>
                    <li><strong>Email:</strong> <?= htmlspecialchars($result['Email']); ?></li>
                    <li><strong>Date of Birth:</strong> <?= htmlspecialchars($result['DateOfBirth']); ?></li>
                    <li><strong>Telephone:</strong> <?= htmlspecialchars($result['Telephone']); ?></li>
                    <li><strong>Address:</strong> <?= htmlspecialchars($result['Address']); ?></li>
                    <li><strong>Country ID:</strong> <?= htmlspecialchars($result['CountryID']); ?></li>
                    <li><strong>Credit Card Number:</strong> <?= htmlspecialchars($result['CreditCardNumber']); ?></li>
                    <li><strong>Credit Card Expiration:</strong> <?= htmlspecialchars($result['CreditCardExpiration']); ?></li>
                    <li><strong>Credit Card Name:</strong> <?= htmlspecialchars($result['CreditCardName']); ?></li>
                    <li><strong>Bank Issued:</strong> <?= htmlspecialchars($result['BankIssued']); ?></li>
                </ul>
            <?php else : ?>
                <p>User details not found.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>

<?php
include("footer.php");
?>