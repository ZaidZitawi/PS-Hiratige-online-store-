<?php
include('dbconfig.in.php');

$successMessage = '';
$errorMessage = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customerID = $_POST['userId'];
    $address = $_POST['address'];
    $countryID = $_POST['country'];
    $creditCardNumber = $_POST['credit_card_number'];
    $creditCardExpiration = $_POST['credit_card_expiry'];
    $creditCardName = $_POST['cardholder_name'];
    $bankIssued = $_POST['bank_issued'];


    $sql = "INSERT INTO CustomerDetails (CustomerID, Address, CountryID, CreditCardNumber, CreditCardExpiration, CreditCardName, BankIssued) VALUES (:customerID, :address, :countryID, :creditCardNumber, :creditCardExpiration, :creditCardName, :bankIssued)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':customerID', $customerID);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':countryID', $countryID);
        $stmt->bindParam(':creditCardNumber', $creditCardNumber);
        $stmt->bindParam(':creditCardExpiration', $creditCardExpiration);
        $stmt->bindParam(':creditCardName', $creditCardName);
        $stmt->bindParam(':bankIssued', $bankIssued);
        $stmt->execute();
        $successMessage = "Customer details added successfully.";


        header("Location: log.php");
        exit;
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="signup-container">
        <h1 class="title1">Customer Additional Information</h1>

        <?php if ($successMessage): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <form class="form" action="signup2.php" method="post">
            <input type="hidden" name="userId" value="<?php echo htmlspecialchars($_GET['userId'] ?? ''); ?>">

            <section class="form-section">
                <h2 class="section-title">Address Information</h2>
                <div class="input-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="input-group">
                    <label for="country">Country ID:</label>
                    <input type="text" id="country" name="country" required>
                </div>
            </section>

            <section class="form-section">
                <h2 class="section-title">Payment Information</h2>
                <div class="input-group">
                    <label for="credit_card_number">Credit Card Number:</label>
                    <input type="text" id="credit_card_number" name="credit_card_number" required>
                </div>
                <div class="input-group">
                    <label for="credit_card_expiry">Credit Card Expiration Date:</label>
                    <input type="month" id="credit_card_expiry" name="credit_card_expiry" required>
                </div>
                <div class="input-group">
                    <label for="cardholder_name">Cardholder's Name:</label>
                    <input type="text" id="cardholder_name" name="cardholder_name" required>
                </div>
                <div class="input-group">
                    <label for="bank_issued">Bank Issued:</label>
                    <input type="text" id="bank_issued" name="bank_issued" required>
                </div>
            </section>

            <button type="submit" class="sign">Submit</button>
        </form>

        <p class="signup">Already have an account? <a href="log.php">Login</a></p>
    </div>
</body>
</html>
