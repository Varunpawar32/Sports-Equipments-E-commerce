<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    // Redirect user to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

include_once 'config.php';
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if cart_id is provided in the GET request
if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    
    // Delete item from the cart
    $sql_delete = "DELETE FROM cart WHERE cart_id = ?";
    $stmt_delete = $con->prepare($sql_delete);
    $stmt_delete->bind_param("i", $cart_id);
    $stmt_delete->execute();
    $stmt_delete->close();

    // Redirect user back to the cart page or any desired page
    header("Location: cart.php");
    exit();
} else {
    // Handle case where cart_id is not provided in the GET request
    echo "Cart ID is missing.";
}
?>
