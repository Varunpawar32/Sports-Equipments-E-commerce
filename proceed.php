<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: login.php");
    exit(); // Add exit() after header redirect to stop further execution
}

// Include database connection file
include_once 'config.php';

// Retrieve user ID
$user_id = $_SESSION["id"];

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


// Fetch cart items for the logged-in user
$sql_cart = "SELECT cart_id FROM cart WHERE u_id = ?";
$stmt_cart = $con->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

// Initialize an array to store cart IDs
$cart_ids = array();

// Store cart_id values in the session and add them to the array
while ($row_cart = $result_cart->fetch_assoc()) {
    $cart_ids[] = $row_cart['cart_id'];
}

// Store cart_ids array in the session
$_SESSION['cart_ids'] = $cart_ids;

// Close statement
$stmt_cart->close();


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #343a40;
        }

        label {
            color: #343a40;
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
   <div class="container mt-5">
    <h1 class="mb-4">Checkout</h1>
    <form action="checkout.php" method="POST">
        <div class="row">
            <div class="col-md-6">
                <h2>Shipping Information</h2>
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" class="form-control" name="fullname" required>
                </div>
                <div class="form-group">
                    <label>Phone Number:</label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
            </div>
            <div class="form-group">
                    <label>Address:</label>
                    <textarea class="form-control" name="address" required></textarea>
                </div>
            <div class="col-md-6">
                <h2>Payment Information</h2>
                
                <div class="form-group">
                    <h3>Choose Payment Method</h3>
                    <select class="form-control" name="payment_method" id="payment_method">
                        <option value="">Select Mode</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="debit_card">Debit Card</option>
                        <option value="upi">UPI</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>
                </div>
                <div id="payment_form">
                    <!-- Payment method forms will be displayed here -->
                </div>
                
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
    </form>
</div>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        var paymentMethod = this.value;
        var paymentFormDiv = document.getElementById('payment_form');
        paymentFormDiv.innerHTML = ''; // Clear previous form content

        // Generate and append payment method form based on selection
        if (paymentMethod === 'credit_card') {
            paymentFormDiv.innerHTML = `
                <h3>Credit Card Details</h3>
                <div class="form-group">
                    <label>Card Number:</label>
                    <input type="text" class="form-control" name="card_number">
                </div>
                <div class="form-group">
                    <label>Expiry Date:</label>
                    <input type="text" class="form-control" name="expiry_date">
                </div>
                <div class="form-group">
                    <label>CVV:</label>
                    <input type="text" class="form-control" name="cvv">
                </div>
                <div class="form-group">
                    <label for="password">Enter Your Password:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            `;
        } else if (paymentMethod === 'debit_card') {
            paymentFormDiv.innerHTML = `
                <h3>Debit Card Details</h3>
                <div class="form-group">
                    <label>Card Number:</label>
                    <input type="text" class="form-control" name="card_number">
                </div>
                <div class="form-group">
                    <label>Expiry Date:</label>
                    <input type="text" class="form-control" name="expiry_date">
                </div>
                <div class="form-group">
                    <label>CVV:</label>
                    <input type="text" class="form-control" name="cvv">
                </div>
                <div class="form-group">
                    <label for="password">Enter Your Password:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            `;
        } else if (paymentMethod === 'upi') {
            paymentFormDiv.innerHTML = `
                <h3>UPI Details</h3>
                <div class="form-group">
                    <label>UPI ID:</label>
                    <input type="text" class="form-control" name="upi_id">
                </div>
                <div class="form-group">
                    <label for="password">Enter Your Password:</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
            `;
        }
        // No additional form fields needed for Cash on Delivery
    });
</script>




    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
