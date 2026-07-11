<?php
include("DAY11headerdashboard.php");

session_start();

 

if (!isset($_SESSION['user_email'])) {
    
    header("Location: DAY11login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <!-- Link your bootstrap CSS here if you want -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5 text-center">
        <div class="card p-5 shadow-sm">
            <h1>Welcome to your Dashboard!</h1>
            <p class="text-muted">Logged in as: <?php echo $_SESSION['user_email']; ?></p>
            <br>
            <a href="DAY11updatePassword.php" class="btn btn-warning w-25 mx-auto d-block mb-3">Update Password</a>
            <a href="DAY11logout.php" class="btn btn-danger w-25 mx-auto">Logout</a>
        </div>
    </div>

</body>
</html>