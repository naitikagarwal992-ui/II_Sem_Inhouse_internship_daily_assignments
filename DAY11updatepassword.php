<?php
include("DAY11header.php");
?>

<div class="container mt-5" style="max-width:400px;">
    <form action="" method="post">
        <h3 class="mb-3">Update Password</h3>
        
        <input type="password" name="oldpassword" class="form-control mb-3" placeholder="old Password">
        <input type="password" name="newpassword" class="form-control mb-3" placeholder="new Password">
        <input type="password" name="confirmPassword" class="form-control mb-3" placeholder="Confirm Password" >
        <button class="btn btn-primary w-100">Update</button>
</form>
</div>