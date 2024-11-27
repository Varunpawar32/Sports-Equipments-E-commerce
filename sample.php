<?php
session_start();
if($_SERVER["REQUEST_METHOD"]=="POST"){
  $username = $_POST["username"];
  $password = $_POST["password"]; 

  require_once("config.php");
  // validate login 

  $query = "SELECT * FROM user WHERE username='$username' AND password ='$password' ";
  $result = mysqli_query($con, $query);
  if ($result-> num_rows == 1){
    // login success 
    $_SESSION["username"] = $username;
    $_SESSION["loggedin"] = true;
    header("Location: welcome.php");
    exit();
}
else{
  // login failed 
  $error_message = "Username or password is incorrect. Please try again.";
  
}

}


?> 


<?php

require_once "config.php";
$username = $password = $confirm_password = $email ="";
$username_err = $password_err = $confirm_password_err = $email_err= "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty(trim($_POST['username']))) {
        $username_err = "Username cannot be blank";

    } else {
        $sql = " SELECT id from user WHERE username = ?";
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 's', $param_username);
            // set the value of param username 
            $param_username = trim($_POST['username']);

        }
        if (mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) ==1) {
                $username_err = "this username is already taken ";

            }
            else {
                $username = trim($_POST['username']);
            }
        }
    }

mysqli_stmt_close($stmt);


// check for password 
if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
    if (empty($_POST['password'])) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 8) {
        $password_err = "Password cannot be less than 8 characters";
    } elseif (!preg_match("/[a-z]/", $_POST['password']) || !preg_match("/[A-Z]/", $_POST['password']) || !preg_match("/[0-9]/", $_POST['password']) || !preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $_POST['password'])) {
        $password_err = "Password must include at least one lowercase letter, one uppercase letter, one digit, and one special character";
    } elseif ($_POST['password'] != $_POST['confirm_password']) {
        $confirm_password_err = 'Passwords should match';
    } else {
        $password = trim($_POST['password']); // Store password as plain text
    }
}

// check for confirm password 
if ($_POST['password'] != $_POST['confirm_password']) {
    $confirm_password_err = 'passwords should match ';
}
}
 // Validate email
 if (isset($_POST['email'])) {
    if (empty(trim($_POST['email']))) {
        $email_err = "Email cannot be blank";
    } else {
        $email = trim($_POST['email']);
    }
} 

// if no errors insert values into the database 
if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
    $sql = 'INSERT into user (username, email, password) VALUES (?, ?, ?)';
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sss', $param_username, $param_email, $param_password);
        $param_username = $username;
        $param_email = $email;  
        $param_password = $password; // Store password as plain text

        // execute the query 
        if (mysqli_stmt_execute($stmt)) {
            header("location: login.php");
        } else {
            // Handle the case when execution fails
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle the case when preparation fails
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>



<?php
session_start();
if (!isset( $_SESSION["id"])){
    header("Location: login.php");
    
}
// Include database connection file
include_once 'config.php';

// Retrieve user ID
$user_id = $_SESSION["id"];

// Fetch cart items for the logged-in user
$sql_cart = "SELECT cart.cart_id, product.pimg, product.pname, product.pdes, product.pprice, cart.quantity FROM cart JOIN product ON cart.p_id = product.id WHERE cart.u_id = ?";
$stmt_cart = $con->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_car t->get_result();

// Close statement
$stmt_cart->close();
?>


now we have to create a page for myorders where user can able to see all the tickets which user has booked it should show all the data from myorder,cart,product,payment table we have columns in myorder(id,)




$result_cart1 = $result_cart;

while ($row_cart = $result_cart1 ->fetch_assoc()) {
    $_SESSION['cart_ids'][] = $row_cart['cart_id'];
    $cart_ids[] = $row_cart['cart_id'];
}