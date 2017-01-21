<?php include "includes/header.php"?>
<?php
if(isset($_GET['submit'])){
    echo "done";
}
echo "<button class='btn btn-warning' onclick='history.go(-1);'>Go Back </button>
";
?>
<?php include "includes/footer.php"?>