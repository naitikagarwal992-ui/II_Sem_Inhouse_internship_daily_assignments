<?php
include("DAY11header.php");

?>
  <div class="container mt-5" style="max-width:400px;">
        
     <form action="DAY11checkRegistration.php" method="post">
            <h3 class="mb-3">Register</h3>

            <input type="text" name="name" class="form-control mb-3" placeholder="Name"  >
            <input type="email" name="email" class="form-control mb-3" placeholder="Email"  >
            <small class ="text  muted d-block mb-2" style="font size:0.85rem; text-align: left;">
                *Password must be at least 5 characters long and contain at least one number
                and one special character (e.g,@,#,$,%).</small>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" >
            <input type="password" name="confirm_password" class="form-control mb-3" placeholder="Confirm Password"  >
           
            <button class = "btn btn-primary w-100">Register</button>
     </form>
  </div>


<?php
include("DAY11footer.php");
?>