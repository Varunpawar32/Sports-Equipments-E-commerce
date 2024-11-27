<?php
include_once 'config.php';

// Initialize product variable
$product = null;

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details based on the provided ID
    $sql = "SELECT * FROM product WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Error fetching product details: " . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Handle form submission to update product details
if ($_SERVER["REQUEST_METHOD"] == "POST" && $product) {
    // Retrieve form data
    $new_product_name = $_POST['productname'];
    $new_product_description = $_POST['productdescription'];
    $new_product_price = $_POST['productprice'];
    $new_product_category = $_POST['productcategory'];
    $new_product_subcategory = $_POST['psubcat'];

    // Update product details in the database
    $update_sql = "UPDATE product SET pname=?, pdes=?, pprice=?, pcat=?, subcat=? WHERE id=?";
    $update_stmt = mysqli_prepare($con, $update_sql);
    mysqli_stmt_bind_param($update_stmt, "ssdssi", $new_product_name, $new_product_description, $new_product_price, $new_product_category, $new_product_subcategory, $product_id);

    // Process the updated image if a new image is selected
    if ($_FILES["productimage"]["error"] == 0) {
        // Delete the existing image file
        unlink($product_details['pimg']);

        // Upload the new image file
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["productimage"]["name"]);
        move_uploaded_file($_FILES["productimage"]["tmp_name"], $target_file);

        // Update the image path in the database
        $sql_update_image = "UPDATE product SET pimg = ? WHERE id = ?";
        $stmt_update_image = mysqli_prepare($con, $sql_update_image);
        mysqli_stmt_bind_param($stmt_update_image, "si", $target_file, $product_id);
        mysqli_stmt_execute($stmt_update_image);
    }
    
    if (mysqli_stmt_execute($update_stmt)) {
        // Redirect to the product management page after successful update
        header("Location: dashboard.php");
    } else {
        echo "Error updating product details: " . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($update_stmt);
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }

        .container-fluid {
            max-width: 800px;
        }

        h1 {
            color: #343a40;
        }

        .card {
            margin-top: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #ffffff;
        }

        .card-body {
            padding: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            color: #343a40;
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
    <div class="container-fluid">
        <h1 class="mt-4 mb-4">Edit Product</h1>

        <!-- Product Form -->
        <div class="card">
            <div class="card-header">
                <h2>Edit Product Details</h2>
            </div>
            <div class="card-body">
                <!-- Add Product Update Form -->
<form action="edit_product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="productName">Product Name</label>
        <input type="text" class="form-control" name="productname" value="<?php echo $product['pname']; ?>" required>
    </div>
    <div class="form-group">
        <label for="productDescription">Product Description</label>
        <textarea class="form-control" name="productdescription" rows="3" required><?php echo $product['pdes']; ?></textarea>
    </div>
    <div class="form-group">
        <label for="productPrice">Product Price (Rs)</label>
        <input type="number" class="form-control" name="productprice" value="<?php echo $product['pprice']; ?>" required>
    </div>
    <div class="form-group">
        <label for="productImage">Product Image</label>
        <input type="file" class="form-control-file" name="productimage" accept="image/*">
    </div>
    <div class="form-group">
        <label for="productCategory">Product Category</label>
        <input type="text" class="form-control" name="productcategory" value="<?php echo $product['pcat']; ?>" required>
    </div>
    <div class="form-group">
        <label for="productSubcategory">Product Subcategory</label>
        <input type="text" class="form-control" name="psubcat" value="<?php echo $product['subcat']; ?>" required>
    </div>
    <button type="submit" name="update" class="btn btn-primary">Update Product</button>
</form>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
