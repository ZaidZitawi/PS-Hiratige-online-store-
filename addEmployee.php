<?php
include "dbconfig.in.php";
include('header.php');

//this script is for the admin only, he has the permission to add employees, 
//the admin account is made by the developer


// Check if the user is logged as admin
if ($_SESSION['usertype'] != 'Admin') {
    header("Location: home.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $dateOfBirth = $_POST['dateOfBirth'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $fullname = $_POST['fullname'];
    $userType = 'Employee'; // Set user type to emp 

    // Prepared SQL query
    $stmt = $pdo->prepare("INSERT INTO Users (Username, Password, UserType, DateOfBirth, Email, Telephone, fullname) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Execute 
    $stmt->execute([$username, $password, $userType, $fullname, $dateOfBirth, $email, $telephone]);

    echo "<p>Employee added successfully.</p>";
}

?>

<link rel="stylesheet" href="headerandfooter.css">
<form action="addEmployee.php" method="post">
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="input1" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="input1" name="password" required>
    </div>
    <div class="form-group">
        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" class="input1" name="dateOfBirth" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="input1" name="email" required>
    </div>
    <div class="form-group">
        <label for="telephone">Telephone:</label>
        <input type="text" class="input1" name="telephone" required>
    </div>
    <div class="form-group">
        <label for="fullname">Full Name:</label>
        <input type="text" class="input1" name="fullname" required>
    </div>
    <button type="submit">Add Employee</button>
</form>

<?php include("footer.php"); ?>