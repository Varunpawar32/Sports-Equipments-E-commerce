<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: login.php");
    exit(); // Add exit() after header redirect to stop further execution
}

// Include database connection file
require_once 'config.php';

// Retrieve user ID
$user_id = $_SESSION["id"];

// Fetch orders for the logged-in user
$sql_orders = "SELECT `order`.*, payment.mode AS payment_mode, payment.amount FROM `order` 
                JOIN payment ON `order`.o_id = payment.o_id WHERE FIND_IN_SET(?, `order`.c_id)";
$stmt_orders = $con->prepare($sql_orders);
if ($stmt_orders) {
    $stmt_orders->bind_param("s", $user_id);
    $stmt_orders->execute();
    $result_orders = $stmt_orders->get_result();

    // Initialize an array to store orders
    $orders = array();

    // Fetch orders and store them in the array
    while ($row_order = $result_orders->fetch_assoc()) {
        // Explode c_id to array format
        $row_order['c_id'] = explode(',', $row_order['c_id']);
        $orders[] = $row_order;
    }

    // Close statement
    $stmt_orders->close();
} else {
    echo "Error preparing statement: " . $con->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
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
            margin-top: 50px;
        }

        h1 {
            color: #343a40;
            margin-bottom: 30px;
        }

        .order {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-details {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Orders</h1>
        <?php if (!empty($orders)) : ?>
            <?php foreach ($orders as $order) : ?>
                <div class="order">
                    <h3>Order ID: <?php echo $order['o_id']; ?></h3>
                    <p><strong>Address:</strong> <?php echo $order['address']; ?></p>
                    <p><strong>Full Name:</strong> <?php echo $order['full_name']; ?></p>
                    <p><strong>Payment Mode:</strong> <?php echo $order['payment_mode']; ?></p>
                    <p><strong>Total Amount:</strong> <?php echo $order['amount']; ?></p>
                    <div class="order-details">
                        <h4>Order Details:</h4>
                        <!-- Fetch and display cart items for this order -->
                        <?php
                        foreach ($order['c_id'] as $cart_id) {
                            // Fetch cart item details
                            $sql_cart_item = "SELECT product.pname, product.pprice, cart.quantity FROM cart 
                                              JOIN product ON cart.p_id = product.id WHERE cart.cart_id = ? AND cart.status = 'buyed'";
                            $stmt_cart_item = $con->prepare($sql_cart_item);
                            if ($stmt_cart_item) {
                                $stmt_cart_item->bind_param("i", $cart_id);
                                $stmt_cart_item->execute();
                                $result_cart_item = $stmt_cart_item->get_result();
                                if ($result_cart_item->num_rows > 0) {
                                    $cart_item = $result_cart_item->fetch_assoc();
                                    ?>
                                    <p><?php echo $cart_item['pname']; ?> - Price: <?php echo $cart_item['pprice']; ?>, Quantity: <?php echo $cart_item['quantity']; ?></p>
                                <?php } else {
                                    echo "No cart items found for cart ID: " . $cart_id;
                                }
                            } else {
                                echo "Error preparing statement: " . $con->error;
                            }
                        } ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
