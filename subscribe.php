<?php
require("phpMQTT.php");

 $host = "m10.cloudmqtt.com";
 $port = 12632;
 $username = "wpqlgzzv";
 $password = "-WdTpk0Ob_p8";

 $mqtt = new phpMQTT($host, $port, "ClientID".rand());

 if(!$mqtt->connect(true,NULL,$username,$password)){
   exit(1);
 }

 //currently subscribed topics
 $topics['topic'] = array("qos"=>0, "function"=>"procmsg");
 $mqtt->subscribe($topics,0);

 while($mqtt->proc()){
 }

 $mqtt->close();
 function procmsg($topic,$msg){
   echo "Msg Recieved: $msg";
 }
 ?>
