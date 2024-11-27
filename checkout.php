<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: login.php");
    exit(); // Add exit() after header redirect to stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve shipping information
    $fullname = $_POST["fullname"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];

    // Retrieve payment information
    $paymentMethod = $_POST["payment_method"];

    // Check if the payment method is not "Cash on Delivery"
    if ($paymentMethod !== "cod") {
        // Retrieve entered password
        $Password = $_POST["password"];

        // Check if the entered password is correct (replace this with your actual password validation logic)
        if ($Password !== $_SESSION["password"]) {
            // Password is incorrect, display alert and redirect back
            echo "<script>alert('Payment unsuccessful. Incorrect password.');</script>";
            echo "<script>window.history.back();</script>";
            exit();
        }
    }

    // Include database connection file
    require_once 'config.php';

    // Retrieve user ID
    $user_id = $_SESSION["id"];

    // Fetch cart IDs for the logged-in user with status 'not-buyed'
    $sql_cart_ids = "SELECT cart_id FROM cart WHERE u_id = ? AND status = 'not-buyed'";
    $stmt_cart_ids = $con->prepare($sql_cart_ids);
    if ($stmt_cart_ids) {
        $stmt_cart_ids->bind_param("i", $user_id);
        $stmt_cart_ids->execute();
        $result_cart_ids = $stmt_cart_ids->get_result();

        // Initialize an array to store cart IDs
        $cart_ids = array();

        // Fetch cart IDs and store them in the array
        while ($row_cart_id = $result_cart_ids->fetch_assoc()) {
            $cart_ids[] = $row_cart_id['cart_id'];
        }

        // Close statement
        $stmt_cart_ids->close();
    } else {
        echo "Error preparing statement: " . $con->error;
        exit(); // Stop further execution if statement preparation fails
    }

    // Insert data into order table
    $order_query = "INSERT INTO `order` (c_id, address, fullname) VALUES (?, ?, ?)";
    $order_stmt = mysqli_prepare($con, $order_query);

    if ($order_stmt) {
        // Convert array of cart IDs to comma-separated string
        $cart_ids_str = implode(',', $cart_ids);

        mysqli_stmt_bind_param($order_stmt, "sss", $cart_ids_str, $address, $fullname);

        if (mysqli_stmt_execute($order_stmt)) {
            // Get the last inserted order ID
            $order_id = mysqli_insert_id($con);

            // Store order ID in session for use in payment table insertion
            $_SESSION['order_id'] = $order_id;
            echo "Order placed successfully!";
        } else {
            echo "Error inserting data into order table: " . mysqli_error($con);
            exit(); // Stop further execution if order insertion fails
        }

        mysqli_stmt_close($order_stmt);
    } else {
        echo "Error preparing order statement: " . mysqli_error($con);
        exit(); // Stop further execution if order preparation fails
    }

    // Insert data into payment table
    $payment_query = "INSERT INTO payment (mode, o_id, amount) VALUES (?, ?, ?)";
    $payment_stmt = mysqli_prepare($con, $payment_query);

    if ($payment_stmt) {
        // Calculate total amount (replace this with your actual calculation)
        $total_amount = $_SESSION['amount']; // Example amount

        // Retrieve order ID from session
        $order_id = $_SESSION['order_id'];

        mysqli_stmt_bind_param($payment_stmt, "sii", $paymentMethod, $order_id, $total_amount);

        if (mysqli_stmt_execute($payment_stmt)) {
            echo "Payment details inserted successfully!";

            // Convert the array of cart IDs to a comma-separated string
            $cart_ids_str = implode(',', $cart_ids);

            // Update status in cart table
            $update_status_query = "UPDATE cart SET status = 'buyed' WHERE cart_id IN ($cart_ids_str)";
            if (mysqli_query($con, $update_status_query)) {
                echo "Cart status updated successfully!";
                header("Location: myorder.php");
            } else {
                echo "Error updating cart status: " . mysqli_error($con);
            }
        } else {
            echo "Error inserting data into payment table: " . mysqli_error($con);
        }

        mysqli_stmt_close($payment_stmt);
    } else {
        echo "Error preparing payment statement: " . mysqli_error($con);
    }

    // Close database connection
    mysqli_close($con);
}
?>
