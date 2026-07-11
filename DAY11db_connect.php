<?php
$host="localhost";
$user="root";
$password="12345";
$database="industrial_training";

$conn = mysqli_connect($host,$user,$password,$database);

if(!$conn){
    die("connection Failed:" .
    mysqli_connect_error());
}

echo "<p class='text-success m-0'>Connection Successful</p>";

?>