<?php
include "dbconfig.in.php";

// check if  theres a cart in the session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    $quantity = 1;  // pass quantity as a parameter or make the user to choose it

    
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    header("Location: cart.php");
    exit();
} else {
    header("Location: home.php");
    exit();
}
?>
