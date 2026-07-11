<?php
session_start();
include("DAY11db_connect.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if ($email == "" || $password == "") {
        $error = "Please fill in all fields.";
    } else {
        
        $query = "SELECT * FROM user WHERE email='$email' AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            
            $_SESSION['user_email'] = $email;
            
           
            header("Location: DAY11dashboard.php");
            exit();
        } else {
           
            $error = "Invalid Email or Password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include("DAY11header.php"); ?>

    <div class="container mt-5" style="max-width: 400px;">
        <h2 class="text-center mb-4">Login</h2>

        <?php if($error != ""): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <!-- Make sure action is empty or points to DAY11login.php, and names match POST variables -->
        <form action="DAY11login.php" method="POST">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</body>
</html>