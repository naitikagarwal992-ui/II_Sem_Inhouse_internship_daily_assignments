<?php
include("DAY11db_connect.php");
$error="";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    
    $email = mysqli_real_escape_string($conn, $_POST['email']); 
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    if ( $email == "" || $password =="" ){

     $error = "All fields are required.";
        echo $error;
    }
     else {
        $selectQuery = "Select * from user where email='$email' and password='$password'";
        $result= mysqli_query($conn,$selectQuery);


        if ($result && mysqli_num_rows($result) == 1) {
            
            $user = mysqli_fetch_assoc($result);

           
            session_start();

            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name']; // This completely fixes the warning!
            $_SESSION['user_email'] = $user['email'];

            header("Location: DAY11dashboard.php");
            exit();
        } else {
            echo "Invalid Credentials";
        }
    }
        
}
?>