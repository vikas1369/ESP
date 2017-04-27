<?php
session_start();
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
?>
<?php include "includes/header.php";?>
<?php include "functions.php";?>
<?php include "includes /Topbar.php"?>
<?php include 'class.apriori.php';?>
 <?php
    $username=$_SESSION['user'];
		//$_SESSION['mqtt']='disconnected';
		//sessionStorage.mqtt="disconnected";
    echo "<center><h3>Hi ".$username.". Welcome to the Event Sharing Portal</h3></center>";?>
    <br>
    <center><?php
?><a href="newstudent.php"><button class="btn btn-primary" type="submit">Add New Student</button></a></center>

<?php include "includes/footer.php";?>
