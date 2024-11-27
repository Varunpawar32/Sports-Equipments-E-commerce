<?php

echo $id=$_GET['id'];
include'config.php';
mysqli_query($con,"DELETE FROM `product` WHERE id=$id");
header("location:dashboard.php");
?>