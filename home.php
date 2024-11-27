<?php
session_start();
if (!isset( $_SESSION["id"])){
    header("Location: login.php");
    
}
// Include database connection file
include_once 'config.php';

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch products from the database
$sql = "SELECT * FROM product";
$result = $con->query($sql);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HOME</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </head>
  <body>
    <!-- navigation -->
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand " href="#">Sports clothing</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Home</a>
        <a class="nav-link" href="cart.php">MyCart</a>
        <a class="nav-link" href="myorder.php">MyOrder</a>
        <a class="nav-link" href="aboutus.php">About us </a>
        <a class="nav-link" href="help.php">Help</a>
      </div>
    </div>
    <div class="d-grid d-md-flex justify-content-md-end ">
  <a class="btn btn-dark me-md-2 mb-1" href="logout.php" type="button">Logout</a>
  
</div>
  </div>
</nav>    

<!-- coursal slide running on background -->
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/img2.avif" height="400" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/mens img.avif" height="400" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/7.jpeg"  height="400" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- cards -->

<div class="container-fluid mt-5">
  <h2 class="text-center mb-4">Shop Now</h2>
  <div class="row px-4">
    <!-- Filter box -->
    <div class="col-md-3 mb-3">
      <h5>Filter by Category</h5>
      <select class="form-select mb-3" aria-label="Default select example">
        <option selected>All Categories</option>
        <option value="Jeyseys">Jeyseys</option>
        <option value="Lower">Lower</option>
        <option value="Undergarments">Undergarments</option>
        <option value="Accesories">Accesories</option>
        <option value="Footwear">Footwear</option>

      </select>
      <!-- Add more filter options as needed -->
    </div>

    <div class="row row-cols-1 row-cols-md-3">
    <?php
    // Display products in card format
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>
        <div class="col mb-4">
    <!-- Example product card -->
    <a href="productview.php?id=<?php echo $row['id']; ?>" class="card-link ">
        <div class="card h-100">
            <img src="<?php echo $row['pimg']; ?>" class="card-img-top" height="500" alt="Product Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['pname']; ?></h5>
                <p class="card-text"><?php echo $row['pdes']; ?></p>
                <p class="card-text">Rs <?php echo $row['pprice']; ?></p>
                <a href="cart.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </a>
</div>

    <?php
        }
    } else {
        echo "No products found";
    }
    $con->close();
    ?>
</div>

    
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

        <!-- Add more cards as needed -->
       
</div>

</div>
</div>
<!-- footer -->
<footer class=" container-fluid bd-footer  bg-dark">
 <div class="container py-4 py-md-5 px-4 px-md-3 text-body-secondary">
    <div class="row">
      <div class="col-lg-3 mb-3">
        <a class="d-inline-flex align-items-center mb-2 text-body-emphasis text-decoration-none text-white" href="/" aria-label="Bootstrap">
          <span class="fs-3 text-white">Sports Clothing</span>
        </a>
        <ul class="list-unstyled small text-white">
          <li class="mb-2">This Sports clothing website will help you to shop clothes for sports. You can order a clothes by clicking this <a href="#" >link.</a> <hr>
          <span class="fs-4 text-white">Contact us</span>
            </li>Email: companyemail@gmail.com<li>
            </li>Telephone no: 022-90xxxxxxx2<li>
        </ul>
      </div>
      <div class="col-6 col-lg-2 offset-lg-1 mb-3 text-white">
        <h5>Links</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" >Home</a></li>
          <li class="mb-2"><a href="#" >Mens clothing</a></li>
          <li class="mb-2"><a href="#" >Womens clothing</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2 mb-3 text-white">
        <h5>About us</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" >website</a></li>
          <li class="mb-2"><a href="#" >Starter template</a></li>
          <li class="mb-2"><a href="#" >Webpack</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>


  </body>

</html>


