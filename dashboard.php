<?php
session_start();
if (!isset( $_SESSION["username"])){
    header("Location: adminlogin.php");
    
}
include_once 'config.php';

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = mysqli_query($con, $sql);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 70px;
            padding-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include('adminnav.php') ?>

    <div class="container">
        <h1 class="mt-4 mb-4">Product Management</h1>
        
        <!-- Product Table -->
        <div class="card mb-4">
            <div class="card-header">
                <h2 >Products</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Sub-category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td><?php echo $product['pname']; ?></td>
                                <td><?php echo $product['pdes']; ?></td>
                                <td><?php echo '$' . $product['pprice']; ?></td>
                                <td><img src="<?php echo $product['pimg']; ?>" alt="<?php echo $product['pname']; ?>" style="max-width: 100px;"></td>
                                <td><?php echo $product['pcat']; ?></td>
                                <td><?php echo $product['subcat']; ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <a href="delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>