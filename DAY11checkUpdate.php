<?php
include("DAY11db_connect.php");
$error="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newPassword = mysqli_real_escape_string($conn, $_POST["newPassword"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirmPassword"]);
    $oldPassword = mysqli_real_escape_string($conn, $_POST["oldPassword"]);

    if ($newPassword == "" || $oldPassword == "" || $confirmPassword == "") {
        $error = "All fields are required.";
        echo $error;
    } elseif ($newPassword != $confirmPassword) {
        $error = "Password does not match";
        echo $error;
    } else {
        //insert
        $selectQuery = "Select * from user where email='$email' and password = '$password'";

        $result = mysqli_query($conn, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            
            session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            header("Location: DAY11dashboard.php");
    exit();
}elseif ($user){

}
else{
    echo "Invalid Credentials";