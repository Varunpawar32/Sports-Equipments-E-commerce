<?php 
session_start();
if (isset( $_SESSION["id"])){
    header("Location: home.php");
    
}?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require_once("config.php");
    // validate login 

    $query = "SELECT * FROM user WHERE username='$username' AND password ='$password' ";
    $result = mysqli_query($con, $query);
    if ($result->num_rows == 1) {
        // Fetch user ID
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

        // Store user ID in session
        $_SESSION['id'] = $user_id;
        $_SESSION['password'] = $password;


        // login success 
        header("Location: home.php");
        exit();
    } else {
        // login failed 
        $error_message = "Username or password is incorrect. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Login and Signup Forms</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <!-- Login Form -->
<div class="col-md-6 form-container" style="max-width: 400px; margin: auto; margin-top: 50px;">
    <h2 style="text-align: center;">Login</h2>
    <form action="login.php" method="POST">
        <?php if (isset($error_message)) {
            echo '<p style="color: red; text-align: center;">' . $error_message . '</p>';
        } ?>

        <div class="form-group" style="margin-bottom: 15px;">
            <label style="font-weight: bold;">Username</label>
            <input type="text" name="username" placeholder="Enter your username" style="width: 100%; padding: 8px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="loginPassword" style="font-weight: bold;">Password</label>
            <input type="password" name="password" placeholder="Enter your password" style="width: 100%; padding: 8px;">
        </div>
        <div class="form-group" style="margin-bottom: 15px; text-align: center;">
            <h5 style="margin-bottom: 10px;">Not a user? <a href="signup.php" style="color: #007bff; text-decoration: none;">Signup here</a></h5>
            <h5>Admin <a href="adminlogin.php" style="color: #007bff; text-decoration: none;">click here</a></h5>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
    </form>
</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
