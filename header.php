<?php
session_start();
include("dbconfig.in.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Header</title>
    <link rel="stylesheet" href="headerandfooter.css">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <img src="images\palestine.png" alt="Logo">
                <h1 class="company-name">PS Heritage</h1>
            </div>
            <nav class="navigation">
                <ul class="menu">
                    <li><a href="home.php">Home </a></li>
                    <li><a href="account.php">Account</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <?php if (isset($_SESSION['userid'])) : ?>
                        <li class="username">Welcom <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
</body>

</html>