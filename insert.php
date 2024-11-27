<?php
// Include database connection file
include_once 'config.php';

if (isset($_POST['upload'])) {
    // Get form data
    $productName = $_POST['productname'];
    $productDescription = $_POST['productdescription'];
    $productPrice = $_POST['productprice'];
    $productCategory = $_POST['productcategory'];
    $productSubCategory = $_POST['psubcat'];

    // Upload image
    $targetDir = "";
    $targetFile = $targetDir . basename($_FILES["productimage"]["name"]);
    move_uploaded_file($_FILES["productimage"]["tmp_name"], $targetFile);

    // Insert product into the database
    $sql = "INSERT INTO product (pname, pdes, pprice, pimg, pcat, subcat) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdsss", $productName, $productDescription, $productPrice, $targetFile, $productCategory, $productSubCategory);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('product added successfully')</script>";
            header("Location:  dashboard.php");

        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
