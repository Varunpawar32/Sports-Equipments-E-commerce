<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "sportsdb";

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if( $con==false) {
    die("connection failed". mysqli_connect_error());
}
?>