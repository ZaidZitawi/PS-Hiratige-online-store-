<?php
// Include your database configuration file
include('dbconfig.in.php');

$successMessage = '';
$errorMessage = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpass'];
    $dob = $_POST['dob'];
    $telephone = $_POST['telephone'];
    $name = $_POST['name'];


    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (Username, Password, UserType, DateOfBirth, Email, Telephone, fullname) VALUES (:username, :password, 'Customer', :dob, :email, :telephone, :name)";

        try {

            $stmt = $pdo->prepare($sql);


            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':dob', $dob);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telephone', $telephone);


            $stmt->execute();
            $successMessage = "New user registered successfully.";
            $lastUserId = $pdo->lastInsertId();

            header("Location: signup2.php?userId=$lastUserId");
            exit;
        } catch (PDOException $e) {
            $errorMessage = "Registration failed: " . $e->getMessage();
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <div class="signup-container">
        <h1 class="title1">Customer Registration</h1>

        <form class="form" action="signup.php" method="post">
            <section class="form-section">
                <h2 class="section-title">Contact Information</h2>
                <div class="input-group">
                    <label for="username">User Name:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="email">E-mail Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required pattern="^(?=.*\d).{8,}$" title="Password must be at least 8 digits long and contain at least one character">
                    <span class="error"><?php echo isset($errors["password"]) ? $errors["password"] : ""; ?></span>
                </div>
                <div class="input-group">
                    <label for="confirmpass">Confirm Password</label>
                    <input type="password" name="confirmpass" id="confirmpass" required>
                    <span class="error"><?php echo isset($errors["confirmPassword"]) ? $errors["confirmPassword"] : ""; ?></span><br>
                </div>
            </section>

            <section class="form-section">
                <h2 class="section-title">Personal Information</h2>
                <div class="input-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="input-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="input-group">
                    <label for="telephone">Telephone:</label>
                    <input type="tel" id="telephone" name="telephone" required>
                </div>
            </section>

            <button type="submit" class="sign">Submit</button>
            <?php if (!empty($successMessage)) : ?>
                <div class="success"><?php echo htmlspecialchars($successMessage); ?></div>
            <?php endif; ?>

            <?php if (!empty($errorMessage)) : ?>
                <div class="errormassage"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php endif; ?>

        </form>

        <p class="signup">Already have an account? <a href="log.php">Login</a></p>
    </div>
</body>

</html>