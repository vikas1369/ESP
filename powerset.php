
<?php
$in = array("A","B","C");
$powerset = powerSet($in);
foreach($powerset as $set){
    print_r($set);
    echo array_values($set)[0]; 
    foreach($set as $values){
        echo $values;
    }
    echo "<br>";
}
echo count($powerset);
$temp="vikas";
$value=explode(',',$temp);
echo $value[0];
$temp="vikas,yadav";
$value=explode(',',$temp);
echo $value[0];
echo $value[0];
//Check for duplicate entry in array
$stack=array();
$eventname='ev1';
array_push($stack,$eventname);
$eventname='ev1';
array_push($stack,$eventname);
print_r($stack);
$result = array_unique($stack);
print_r($result);
//print_r($powerset);
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
