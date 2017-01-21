    <?php
session_start(); 
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}?>
<?php include "includes/header.php"?>
<?php include "functions.php"?>

<?php 
    checkLogin();
    ?>

 <div class="container">
 <div class="col-sm-6">
 
   
    <h1>AN EVENT SHARING PORTAL</h1>
<form method="post">
<table class="table table-bordered">
    <tr><td>
       <div class="form-group">
        <label for="username">Enter Username</label>
    <input type="text" name="username" required class="form-control">
    </div>
    </td></tr>
    <tr><td>
       <div class="form-group">
        <label for="password">Enter Password</label>
    <input type="password" name="password" required class="form-control">
        </div>
    </td></tr>
    <tr><td>
        <button type="submit" name="login" class="btn btn-primary">Sign In</button>
    </td></tr>
    <tr><td>
        <a href="password.php">Forgot Password?</a>
    </td></tr>
    <tr><td>
        <a href="register.php">Sign Up Here</a>
    </td></tr>
</table>
</form>
     </div>
     
</div>

<?php include "includes/footer.php"?>