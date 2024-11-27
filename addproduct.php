<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
<?php include('adminnav.php') ?>
    <div class="container-fluid">
        <h1 class="mt-4 mb-4">Add Product</h1>

        <!-- Product Form -->
        <div class="card">
            <div class="card-header" style=" background-color: #007bff;
            color: #ffffff;">
                <h2>Product Details</h2>
            </div>
            <div class="card-body">
                <form action="insert.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" name="productname" required>
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Product Description</label>
                        <textarea class="form-control" name="productdescription" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Product Price (Rs)</label>
                        <input type="number" class="form-control" name="productprice" required>
                    </div>
                    <div class="form-group">
                        <label for="productImage">Product Image</label>
                        <input type="file" class="form-control-file" name="productimage" accept="" required>
                    </div>
                    <div class="form-group">
                        <label >Product  Category</label>
                        <select  name="productcategory" >
                         <option value="Jerseys">Jerseys</option>
                        <option value="Lower"> Lower</option>
                        <option value="Undergarments">Undergarments</option>
                        <option value="Accesories">Accesories</option>
                        <option value="Footwear">Footwear</option>
                         </select>
                    </div>
                    <div class="form-group">
                        <label>Product sub Category</label>
                        <select  name="psubcat" >
                         <option value="Men">Men</option>
                        <option value="Women"> Women</option>
                    
                         </select>
                    </div>
                    <button type="submit" name="upload" class="btn btn-primary">Add Product</button>
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
