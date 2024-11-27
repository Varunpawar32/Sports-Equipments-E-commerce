<?php
session_start();

if (isset( $_SESSION["username"])){
    header("Location: dashboard.php");
    
}
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $username = $_POST["username"];
  $password = $_POST["password"]; 

 require_once("config.php");
  // validate login 

  $query = "SELECT * FROM admins WHERE username='$username' AND password ='$password' ";
  $result = mysqli_query($con, $query);
  if ($result-> num_rows == 1){
    // login success 
    $_SESSION["username"] = $username;
    $_SESSION["loggedin"] = true;
    header("Location:dashboard.php");
    exit();
}
else{
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

<!-- Admin Login Form -->
<div class="col-md-6 form-container">
    <h2>Admin Login</h2>
    <form action="adminlogin.php" method="POST">
        <?php if (isset($error_message)) {
            echo '<p style="color: red;">' . $error_message . '</p>';
        }?>

        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" class="form-control">
        </div>
        <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" name="password"  placeholder="Enter your password" class="form-control">
        </div>
        <div class="form-group">
            <!-- Additional form elements can be added here if needed -->
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
