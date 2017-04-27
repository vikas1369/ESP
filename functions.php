<?php include "db.php"?>
<style>
#results
{
font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
width:50%;
border-collapse:collapse;
}
#results td, #results th
{
font-size:1em;
border:1px solid #293d3d;
padding:3px 7px 2px 7px;
    width:35%;
}
#results th
{
font-size:1.1em;
text-align:left;
padding-top:5px;
padding-bottom:4px;
background-color:#669999;
color:#ffffff;
    width: 15%;
}
</style>
<?php
function doRegistration(){
    global $connection;
    if(isset($_POST['submit'])){
                $fname=$_POST['fname'];
                $lname=$_POST['lname'];
                $emailid=$_POST['emailid'];
                $mobileno=$_POST['mobileno'];
                $username=$_POST['username'];
                $password=$_POST['password'];
                $code=md5(uniqid(rand()));
                $query2="SELECT * FROM members WHERE username='$username'";
                $result2=mysqli_query($connection,$query2);
                $count=mysqli_num_rows($result2);
                if($count==1){
                    echo "Username Already Taken";
                }
                else{
                     mysqli_free_result($result2);
                     $query1="INSERT INTO register(fname,lname,emailid,mobileno,username,password,code) ";
                     $query1 .="VALUES('$fname','$lname','$emailid','$mobileno','$username','$password','$code')";
                     $result1=mysqli_query($connection,$query1);
                    if(!$result1){
                        echo "Database Error Occured. Please try again";
                    }
                    else{
                         echo "Your Registration Completed Successfully";
                         sendMail($code);
                    }

                }
    }
}
function sendMail($code){
    $to=$_POST['emailid'];
    $subject="Thank yor for registering on VHOAM";
    $message="Your Comfirmation link \r\n";
    $message.="Click on this link to activate your account \r\n";
    $message.="http://example/confirmation.php?passkey=$code";
    $sentmail=mail($to,$subject,$message,'From: do.vikas1369@gmail.com');
    if($sentmail){
        echo "<br>Please activate your account before accessing this website<br>A Confirmation link aas been sent to your email address.";
    }
    else {
        echo "<br>Cannot send Confirmation link to your e-mail address";
    }
}
function confirmUser(){
    global $connection;
    $passkey=$_GET['passkey'];
    $query="SELECT * FROM register where code='$passkey'";
    $result=mysqli_query($connection,$query);
    $count=mysqli_num_rows($result);
    if($count==1){
        $row=mysqli_fetch_assoc($result);
        $fname=$row['fname'];
        $lname=$row['lname'];
        $emailid=$row['emailid'];
        $mobileno=$row['mobileno'];
        $username=$row['username'];
        $password=$row['password'];
        $query="INSERT INTO members(fname,lname,emailid,mobileno,username,password) ";
        $query .="VALUES('$fname','$lname','$emailid','$mobileno','$username','$password')";
        $result=mysqli_query($connection,$query);
        if(!$result){
        die("Query Failed".mysqli_error($connection));
        }
        else{
            echo "Your account has been activated<br>You will be redirected to Home Page";
            $sql="DELETE FROM register WHERE code = '$passkey'";
            $result=mysqli_query($connection,$sql);
            header('Refresh: 5; URL=home.php');
        }
    }
     else
        {
            echo "Wrong Confirmation Code";
        }
}
function checkLogin(){
    //session_start();
    //session_destroy();
    global $connection;
    if(isset($_POST['login'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    $query= "SELECT * FROM admin WHERE username='$username' and password='$password'";
    $result=mysqli_query($connection,$query );
    $count = mysqli_num_rows($result);
    if($count==1){
        $_SESSION['user'] = $username;
        header("Location:/FPSWEB/home.php");
        //die("Query Failed".mysqli_error($connection));
    }
    else{
        echo "Invalid Login Credentials.";
    }
}
}

function addNewStudent(){
    global $connection;
if(isset($_POST['add'])){
    $fpsid=$_POST['fpsid'];
    $studentid=$_POST['studentid'];
    $name=$_POST['name'];
    $emailid=$_POST['emailid'];
    $class=$_POST['class'];
    $mobileno=$_POST['mobileno'];
    $pmobileno=$_POST['pmobileno'];
    $query="INSERT INTO Students(Studentid,Name, Emailid,FPSid, Class, Mobileno, PMobileno) ";
    $query .="VALUES('$studentid','$name','$emailid','$fpsid','$class','$mobileno','$pmobileno')";
    $result=mysqli_query($connection,$query);
    if(!$result){
        echo "Error";
        die("Query Failed".mysqli_error($connection));

    }
    else{
        echo "Record for Student Id: ".$studentid." added successfully";
    }
}
}

function searchEvents(){
    global $connection;
if(isset($_POST['submit'])){
    echo "<br><b><u>Search Results</u></b><br>";
    $search=$_POST['address'];
        $query="SELECT * FROM address WHERE locality LIKE '%$search%' or address LIKE '%$search%' or city LIKE '%$search%'";
    $result=mysqli_query($connection,$query);
    $rowcount=mysqli_num_rows($result);
    if(!$result){
        die("Query Failed".mysqli_error($connection));
    }
    else{
        if($rowcount==0){
            echo "<br>No Result Found";
        }
        else{
            echo "<br>Total Events found for this query are :".$rowcount."<br><br>";
        }

        while($row=mysqli_fetch_assoc($result)){
            $address=$row['address'];
            $eventname=$row['eventname'];
            $locality=$row['locality'];
            $city=$row['city'];
            $mn=$row['mobile'];
            $date=$row['date'];
            $username=$row['username'];
            ?>
            <table border="1" id="results">
               <tr>
                    <th>Event Name</th>
                    <td width="25%"><?php echo $eventname?></td>
                </tr>
                <tr>
                    <th>Event Timing</th>
                    <td width="25%"><?php echo $date?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td width="25%"><?php echo $address?></td>
                </tr>
                <tr>
                    <th>Locality</th>
                    <td><?php echo $locality?></td>
                </tr>
                <tr>
                    <th>City</th>
                    <td><?php echo $city?></td>
                </tr>
                <tr>
                    <th>Mobile No</th>
                    <td><?php if($mn==NULL) echo "Not Available"; else echo $mn;?></td>
                </tr>
                <tr>
                    <th>Posted by User</th>
                    <td><?php echo $username?></td>
                </tr>
                <tr>
                    <td><form method="POST">
                    <input type="hidden" name="event" value="<?php echo $eventname;?>"/>
                    <button type="submit" class="btn btn-default" name="register">Register for this event</button></form></td>
                </tr>
                <tr></tr>
            </table>
            <?php
                echo "<br><br><br>";
        }
    }
}
}
function sendPassword(){
    global $connection;
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $query="SELECT emailid,password FROM members WHERE username='$username'";
        $result=mysqli_query($connection,$query);
        if($result){
            $count=mysqli_num_rows($result);
            if($count==1){
                $row=mysqli_fetch_assoc($result);
            $password=$row['password'];
            $to=$row['emailid'];
            $subject="Password Mail";
            $message="Your Password is: ".$password;
            $sentmail=mail($to,$subject,$message,'From: do.vikas1369@gmail.com');
        if($sentmail){
            echo "<br>Your password has been sent to your email address.";
        }
        else {
            echo "<br>Cannot send password to your e-mail address";
        }
            }

            else{
            echo "Username doesn't exist";
        }
        }
    }
}
function registerForEvent(){
    global $connection;
    if(isset($_POST['register'])){
        $username=$_SESSION['user'];
        $eventname=$_POST['event'];
        $query="INSERT INTO transaction(username,event) ";
        $query .="VALUES('$username','$eventname')";
        $result=mysqli_query($connection,$query);
        if($result){
            echo "You have been successfully registered for the event<br>";
        }
        else{
            echo "Some Problem in registreation. Please try again";
        }
    }
}
function runapriori(){
$Apriori = new Apriori();
$Apriori->setMaxScan(20);       //Scan 2, 3, ...
$Apriori->setMinSup(2);         //Minimum support 1, 2, 3, ...
$Apriori->setMinConf(75);       //Minimum confidence - Percent 1, 2, ..., 100
$Apriori->setDelimiter(',');    //Delimiter
     global $connection;
    $dataset   = array();
    $query='SELECT username FROM members';
    $result=mysqli_query($connection,$query);
    if(!$result){
        echo "Database Error Occuered";
    }
    while($row=mysqli_fetch_array($result)){
        $username=$row['username'];
        $query1="SELECT event FROM transaction WHERE username='$username'";
        $result1=mysqli_query($connection,$query1);
        if(mysqli_num_rows($result1)==0){
        }
        else{
            $temporary=array();
            while($row=mysqli_fetch_array($result1)){
                array_push($temporary,$row['event']);
            //$a=$row;
            }
        $dataset[]=$temporary;
        }
    }
$Apriori->process($dataset);

//Recommendation Here
$username=$_SESSION['user'];
     $stack=array();
                $query1="SELECT event FROM transaction WHERE username='$username'";
        $result1=mysqli_query($connection,$query1);
        if(mysqli_num_rows($result1)==0){
        }
        else{
            $myevent='';
            $count=1;

            while($row=mysqli_fetch_array($result1)){
                $eventname=$row['event'];
                array_push($stack,$eventname);
                //$a=$row;
            }
        }

    $powerset = powerSet($stack);
    $final_suggest=array();

 foreach($powerset as $set){
     $myevent='';
     $numberinsert=count($set);
     if($numberinsert==1){
          $myevent=array_values($set)[0];
     }
     else{
         $count=1;
         foreach($set as $value){
             if($count==1){
                     $myevent=$value;
                }
                else{
                     $myevent=$myevent.','.$value;
                }
                $count++;

         }
     }
    //echo 'My events '.$myevent.'<br>';
     $rules=$Apriori->getAssociationRules();
     foreach($rules as $a => $arr)
          {
             foreach($arr as $b => $conf)
                {
                   if($a==$myevent){
                       $value=explode(',',$b);
                       foreach($value as $val){
                           array_push($final_suggest,$val);
                       }
                       //echo "Suggest Event for you is ".$b."<br>";
                   }
                }
     }
}
    $result = array_unique($final_suggest);
    foreach($stack as $element){
        if (($key = array_search($element, $result)) !== false) {
    unset($result[$key]);
            //echo "Deleted ".$element;
}

    }
    echo "Suggested event/events for you<br>";
    if( empty( $result ) )
{
     echo "No Events<br><br>";
}
    else{
        foreach($result as $indi_events){
    echo $indi_events." ";
}
    echo "<br><br>";
}
    }
function powerSet($in,$minLength = 1) {
   $count = count($in);
   $members = pow(2,$count);
   $return = array();
   for ($i = 0; $i < $members; $i++) {
      $b = sprintf("%0".$count."b",$i);
      $out = array();
      for ($j = 0; $j < $count; $j++) {
         if ($b{$j} == '1') $out[] = $in[$j];
      }
      if (count($out) >= $minLength) {
         $return[] = $out;
      }
   }
   return $return;
}
?>
