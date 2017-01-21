<!DOCTYPE HTML>
<html>
<head> 
    <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
	<title>Apriori Alghoritm</title>
</head>
<body style="font-family: monospace;">
<?php   
include 'class.apriori.php';

$Apriori = new Apriori();

$Apriori->setMaxScan(20);       //Scan 2, 3, ...
$Apriori->setMinSup(2);         //Minimum support 1, 2, 3, ...
$Apriori->setMinConf(75);       //Minimum confidence - Percent 1, 2, ..., 100
$Apriori->setDelimiter(',');    //Delimiter 
/*Use Array:
$dataset   = array();
$dataset[] = array('m','t'); 
$dataset[] = array('m','t','r');  
$dataset[] = array('t', 'r','a');   
*/
    $connection=mysqli_connect('localhost','root','','esp');
    if(!$connection)
        die("Database Error");
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
echo '<br>Recommendatin starts here<br>';
     $stack=array();//storing interest of individual
$username='vikas1369';
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
    echo 'My events '.$myevent.'<br>';
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
                       echo "Suggest Event for you is ".$b."<br>";
                   }
                }
}
}
    $result = array_unique($final_suggest);
    foreach($stack as $element){
        if (($key = array_search($element, $result)) !== false) {
    unset($result[$key]);
}
        
    }
print_r($result);
echo '<h1>Association Rules</h1>';
$Apriori->printAssociationRules();
echo '<h1>Frequent Itemsets</h1>';
$Apriori->printFreqItemsets();

echo '<h3>Frequent Itemsets Array</h3>';
print_r($Apriori->getFreqItemsets()); 
    
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
</body>
</html>
