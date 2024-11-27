<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION["id"])) {
    // Redirect user to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Check if cart ID and action are provided in the GET request
if (isset($_GET['id']) && isset($_GET['action'])) {
    // Database connection
    include_once 'config.php';

    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $cart_id = $_GET['id'];
    $action = $_GET['action'];

    // Check if the action is valid (increase or decrease)
    if ($action == 'increase') {
        // Update quantity by increasing it by 1
        $sql_update = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id = ?";
    } elseif ($action == 'decrease') {
        // Update quantity by decreasing it by 1 (minimum quantity should be 1)
        $sql_update = "UPDATE cart SET quantity = GREATEST(quantity - 1, 1) WHERE cart_id = ?";
    } else {
        // Invalid action, redirect to cart page or handle error
        header("Location: cart.php");
        exit();
    }

    // Prepare and execute the update query
    $stmt_update = $con->prepare($sql_update);
    $stmt_update->bind_param("i", $cart_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Redirect user back to the cart page or any desired page
    header("Location: cart.php");
    exit();
} else {
    // Handle case where cart ID or action is missing
    echo "Cart ID or action is missing.";
}
?>
