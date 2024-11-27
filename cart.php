<?php
session_start();
if (!isset($_SESSION["id"])){
    header("Location: login.php");
    exit();
}

// Include database connection file
include_once 'config.php';

// Retrieve user ID
$user_id = $_SESSION["id"];

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Check if product ID is provided in the GET request
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    
    // Get user ID from session
    $user_id = $_SESSION["id"];

    // Insert new data into the cart
    $sql_insert = "INSERT INTO cart (u_id, p_id, quantity) VALUES (?, ?, 1)";
    $stmt_insert = $con->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $product_id);
    $stmt_insert->execute();
    $stmt_insert->close();

    // Redirect user back to the previous page or any desired page
    header("Location:cart.php");
    exit();
}

// Fetch cart items for the logged-in user where status is 'not-buyed'
$sql_cart = "SELECT cart.cart_id, product.pimg, product.pname, product.pdes, product.pprice, cart.quantity FROM cart JOIN product ON cart.p_id = product.id WHERE cart.u_id = ? AND cart.status = 'not-buyed'";
$stmt_cart = $con->prepare($sql_cart);
$stmt_cart->bind_param("i", $user_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

// Close statement
$stmt_cart->close();
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand " href="#">Sports clothing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
        <a class="nav-link" href="cart.php">MyCart</a>
        <a class="nav-link" href="#">MyOrder</a>
        <a class="nav-link" href="aboutus.php">About us </a>
        <a class="nav-link" href="help.php">Help</a>
      </div>
    </div>
    <div class="d-grid d-md-flex justify-content-md-end ">
  <a class="btn btn-dark me-md-2 mb-1" href="logout.php" type="button">Logout</a>
  
</div>
  </div>
</nav>  
<?php
// Initialize total quantity and total amount variables
$total_quantity = 0;
$total_amount = 0;

if ($result_cart->num_rows > 0) {
    $sr_no = 1;
    while($row = $result_cart->fetch_assoc()) {
        // Increment total quantity
        $total_quantity += $row['quantity'];
        
        // Calculate total amount for this product and add it to the total amount
        $product_total = $row['pprice'] * $row['quantity'];
        $total_amount += $product_total;
        $_SESSION['amount'] = $total_amount;
        ?>
        <!-- Individual product card -->
<div class="container my-3">
 <div class="row"> 
          <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?php echo $row['pimg']; ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['pname']; ?></h5>
                        <p class="card-text"><?php echo $row['pdes']; ?></p>
                        <p class="card-text">Quantity: <?php echo $row['quantity']; ?></p>
                        <p class="card-text">Price: Rs<?php echo $row['pprice']; ?></p>
                        <p class="card-text">Total Amount: Rs<?php echo $product_total; ?></p>

            <!-- Increase Quantity Button -->
                        <a href="update_quantity.php?id=<?php echo $row['cart_id']; ?>&action=increase" class="btn btn-success mr-2">
                        <i class="fas fa-plus">+</i>
                        </a>
            <!-- Decrease Quantity Button -->
                        <a href="update_quantity.php?id=<?php echo $row['cart_id']; ?>&action=decrease" class="btn btn-warning <?php echo ($row['quantity'] <= 1) ? 'disabled' : ''; ?>">
                            <i class="fas fa-minus">-</i>
                        </a>
            <!-- Remove from Cart Button -->
                        <a href="removecart.php?id=<?php echo $row['cart_id']; ?>" class="btn btn-danger ml-2">Remove from Cart</a>
                 </div>
            <!-- </div> -->
        </div>
    </div>
</div>
        <?php
        // Increment SR number for the next row in the grand total table
        $sr_no++;
    }
} else {
    // Handle case where cart is empty
    echo "<p>Your cart is empty.</p>";
}

// After looping through all products, display the grand total table
?>
<!-- Grand total table -->
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Grand Total</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>SR No.</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price Per Quantity</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Reset SR number for the grand total table
                        $sr_no = 1;
                        // Loop through each product in the cart again to display them in the grand total table
                        $result_cart->data_seek(0); // Reset the result set pointer
                        while($row = $result_cart->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $sr_no++; ?></td>
                                <td><?php echo $row['pname']; ?></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td>Rs<?php echo $row['pprice']; ?></td>
                                <td>Rs<?php echo $row['pprice'] * $row['quantity']; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><b>Total:</b></td>
                            <td><?php echo $total_quantity; ?></td>
                            <td>-</td>
                            <td><b>Rs<?php echo $total_amount; ?><b></td>
                        </tr>
                    </tfoot>
                </table>
            </div> 
        </div>
            <a class="btn btn-success me-md-2 mb-1" href="proceed.php" type="button">Proceed to buy</a>
       
    </div>
</div>

</body>
</html>
