<?php
session_start();
include("dbconfig.in.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE Email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['Password'])) {
        $_SESSION["userid"] = $result['UserID'];
        $_SESSION["username"] = $result['Username'];
        $_SESSION["email"] = $result['Email'];
        $_SESSION["usertype"] = $result['UserType'];

        // Redirect admin to the home page with admin privileges
        if ($_SESSION['usertype'] == 'Admin') {
            header("Location: home.php");
            exit();
        } else {
            // Redirect non-admin users to a different page or home page without admin featers
            header("Location: home.php");
            exit();
        }
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <div class="login-container">
        <p class="title1">Welcome to PS Heritage</p>
        <p class="title2">Login</p>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <form class="form" action="log.php" method="post">
            <div class="input-group">
                <label for="username">Email</label>
                <input type="email" name="username" id="username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
                <br><br>
            </div>
            <button class="sign">Login</button>
        </form>
        <p class="signup">Don't have an account?
            <a rel="Sign-up-page" href="signup.php" class="">Sign up</a>
        </p>
    </div>
</body>

</html>

<?php
if (isset($_GET['destroy']) && $_GET['destroy'] === 'true') {
    session_destroy();
}
?>