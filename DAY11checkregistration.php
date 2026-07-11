<?php
include("DAY11db_connect.php");
$error="";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);
   
    if ($name == "" || $email == "" || $password ==""|| $confirm_password==""){

     $error = "All fields are required.";
        echo $error;
    }else if (strlen($password)<5|| !preg_match('/[0-9]/',$password)||!preg_match('/[^A-Z a-z 0-9]/',$password))
    {
       $error = "<div class='alert alert-danger mt-2'> Password must be at least 5 characters long, contain at least one number, and one special character.</div>";
       echo $error;
    }
    else if ($password !== $confirm_password){
        $error="Passwords do not match.";
        echo $error;
    }
     else {
        $insertQuery = "insert into user (name,email,password) values('$name','$email','$password')";
        $result= mysqli_query($conn,$insertQuery);
        if($result){
            header("Location:DAY11success.php");
            exit();
        } else{
            echo"Error occured while register" . mysqli_error($conn);
        }
       
    }
}
?>