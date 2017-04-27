<?php
session_start();
if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
?>
    <?php include "includes/header.php"?>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
		<script src="http://www.hivemq.com/demos/websocket-client/js/mqttws31.js" type="text/javascript"></script>

     <?php include "functions.php"?>
		 <script type="text/javascript">
		 //Start of MQTT Code
		 var attempt=0;
		 var mqtt='disconnected';
		 var flags=false;
		 var client = new Messaging.Client("broker.mqttdashboard.com", 8000, "myclientid_" + parseInt(Math.random() * 100, 10));

		 //Gets  called if the websocket/mqtt connection gets disconnected for any reason
		 client.onConnectionLost = function (responseObject) {
		     //Depending on your scenario you could implement a reconnect logic here
		     alert("connection lost: " + responseObject.errorMessage);
		 };
		 //Gets called whenever you receive a message for your subscriptions
		 client.onMessageArrived = function (message) {
		     //Do something with the push message you received
		     //$('#messages').append('<span>Topic: ' + message.destinationName + '  | ' + message.payloadString + '</span><br/>');
				 if(message.payloadString=='false'){
					 $('#messages').append('<span>Attempt: ' + attempt + '| Unsuccessful</span><br/>');
					 //location.reload();
					 alert("Try again");
				 }
				 else{
					 $('#messages').append('<span>Attempt: ' + attempt + ' | Successful | FPS ID: '+message.payloadString+'</span><br/>');
					 flags=true;
					 console.log("Successful");
					 document.getElementById('btnReg').innerHTML="Submit Registration Data";
					 document.getElementById('fpsid').value=message.payloadString;
					 $('form#myForm').submit(function(){
						 return true;
					 });
					 //document.getElementById("myForm").submit();
				 }

		 };
		 //Connect Options
		 var options = {
		     timeout: 10,
		     //Gets Called if the connection has sucessfully been established
		     onSuccess: function () {
		         //alert("Connected");
						 //$_SESSION['mqtt']='connected'
						 mqtt='connected';
						 alert(mqtt);
		         console.log("Connected");
		         client.subscribe('student/register', {qos: 2});
		         var message = new Messaging.Message("Start Registering");
		         message.destinationName = "student/init";
		         message.qos =2;
		         client.send(message);
		         alert('Subscribed');
		         console.log("subscribed");
		         console.log("Published");
		     },
		     //Gets Called if the connection could not be established
		     onFailure: function (message) {
		         alert("Connection failed: " + message.errorMessage);
		     }
		 };
		 var publish = function (payload, topic, qos) {
		     //Send your message (also possible to serialize it as JSON or protobuf or just use a string, no limitations)
		     var message = new Messaging.Message(payload);
		     message.destinationName = topic;
		     message.qos = qos;
		     client.send(message);
				 console.log("Published");
		 }
		 //End of MQTT Code

				 var flag=0;
				 function checkstudentid(){
				 		var id = /^[0-9]{9}$/;
				 if(document.stuform.studentid.value == ""){
				 		 document.getElementById('helpBlock2').innerHTML = 'Please Enter the Student Id.';
				 		flag=1;
				  }
				  else if(!document.stuform.studentid.value.match(id)){
				 		 document.getElementById('helpBlock2').innerHTML = 'Please Enter 9 digit Student Id';
				 		flag=1;
				  }
				 }

				 function checkname(){
					var letters = /^[A-Za-z]+$/;
					if(document.stuform.name.value == ""){
							document.getElementById('helpBlock3').innerHTML = 'Please Enter the First Name';
							flag=1;
					}
						 else if(document.stuform.name.value.length>30){
								 document.getElementById('helpBlock3').innerHTML = 'Name should be of Maximun 30 characters';
								 flag=1;
						 }
						 else if(!document.stuform.name.value.match(letters)){
								 document.getElementById('helpBlock3').innerHTML = 'Name should only contain alphabet characters';
								 flag=1;
						 }

				 }

				 function checkemailid(){
						 var email = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
						 if(document.stuform.emailid.value == ""){
							document.getElementById('helpBlock4').innerHTML = 'Please Enter the Email Id';
						 flag=1;
							}
						 else if(!document.stuform.emailid.value.match(email)){
							document.getElementById('helpBlock4').innerHTML = 'Please Enter the Email Id in proper format';
						 flag=1;
							}

				 }

				 function checkclass(){
				 var letters = /^[A-Za-z]+$/;
				 if(document.stuform.class.value == ""){
						 document.getElementById('helpBlock5').innerHTML = 'Please Enter the Class name';
						 flag=1;
				 }
						else if(document.stuform.class.value.length>20){
								document.getElementById('helpBlock5').innerHTML = 'Class Name should be of Maximun 20 characters';
								flag=1;
						}
						else if(!document.stuform.class.value.match(letters)){
								document.getElementById('helpBlock5').innerHTML = 'Class should only contain alphabet characters';
								flag=1;
						}

				}

				 function checkmobile(){
						 var mobileno = /^[0-9]{10}$/;
				 if(document.stuform.mobileno.value == ""){
							document.getElementById('helpBlock6').innerHTML = 'Please Enter the Mobile No.';
						 flag=1;
					}
					else if(!document.stuform.mobileno.value.match(mobileno)){
							document.getElementById('helpBlock6').innerHTML = 'Please Enter 10 digit mobile number';
						 flag=1;
					}
				 }

				 function checkpmobile(){
						 var mobileno = /^[0-9]{10}$/;
				 if(document.stuform.pmobileno.value == ""){
							document.getElementById('helpBlock7').innerHTML = 'Please Enter the Mobile No.';
						 flag=1;
					}
					else if(!document.stuform.pmobileno.value.match(mobileno)){
							document.getElementById('helpBlock7').innerHTML = 'Please Enter 10 digit mobile number';
						 flag=1;
					}
				 }
						function validate(){
							attempt++;
							console.log("Called:validation function");
								flag=0;
								if(flags==false){
									document.getElementById('helpBlock1').innerHTML = "";
									document.getElementById('helpBlock2').innerHTML = "";
									document.getElementById('helpBlock3').innerHTML = "";
									document.getElementById('helpBlock4').innerHTML = "";
									document.getElementById('helpBlock5').innerHTML = "";
									document.getElementById('helpBlock6').innerHTML = "";
									document.getElementById('helpBlock7').innerHTML = "";
									checkstudentid();
									checkname();
									checkemailid();
									checkclass();
									checkmobile();
									checkpmobile();
									if(flag==1){
											return false;
									}
									else{
										if(mqtt=='connected'){
											alert("Inside mqtt connected");
											document.getElementById("hbutton3").click();
											return false;
										}
										else if(mqtt=='disconnected'){
											alert("Inside mqtt disconnected");
											//$('#hbutton1').click();
											document.getElementById("hbutton1").click();
											//$('#hbutton2').click();
											//$('#hbutton3').click();
											return false;
										}
										//alert("Outside if else");

										/*if($_SESSION['mqtt']=='disconnected'){

										}
										else{
											var message = new Messaging.Message("Start Registering");
				 		         	message.destinationName = "student/init";
				 		         	message.qos =2;
				 		         	client.send(message);
										}*/
										//runMQTT();
										//client.subscribe('student/register', {qos: 2});
										//publish('Start Registering','student/init',2);
										//console.log("End of javascript code");
							}
								}
								else{
									console.log("submitting data");
									return true;
								}
					}

	</script>
    <?php include "includes/Topbar.php"?>
   <div class="container">
    <div class="col-md-4 col-md-offset-4">
      <form id="myForm" class="form-horizontal" method="post" name="stuform" onsubmit="return(validate());">
        <fieldset>

          <!-- Form Name -->
          <legend>Add New Event Student Info</legend>
					<p id="success1" class="bg-success">
					<?php
					addNewStudent();
					?>
					</p>
					<div id="messages"></div>
          <!-- Text input-->
          <div class="form-group">
            <div class="col-sm-9">
              <input type="hidden" id="fpsid" name="fpsid" class="form-control" required>
							<div class="form-group has-error">
							<span id="helpBlock1" class="help-block"></span>
							</div>
            </div>
          </div>

					<!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="studentid">Student Id</label>
            <div class="col-sm-9">
              <input type="text" name="studentid" class="form-control" required>
							<div class="form-group has-error">
							<span id="helpBlock2" class="help-block"></span>
							</div>
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="name">Name</label>
            <div class="col-sm-9">
              <input type="text" name="name" class="form-control" required>
							<div class="form-group has-error">
							<span id="helpBlock3" class="help-block"></span>
							</div>
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="emailid">Email Id</label>
            <div class="col-sm-9">
              <input type="text" name="emailid" class="form-control" required>
							<div class="form-group has-error">
							<span id="helpBlock4" class="help-block"></span>
							</div>
            </div>
          </div>

          <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="class">Class</label>
            <div class="col-sm-9">
              <input type="text" name="class" class="form-control" required>
							<div class="form-group has-error">
							<span id="helpBlock5" class="help-block"></span>
							</div>
            </div>
          </div>
         <!-- Text input-->
          <div class="form-group">
            <label class="col-sm-3 control-label" for="mobileno">Mobile No</label>
            <div class="col-sm-9">
              <input type="text" name="mobileno" class="form-control" required>
							<div class="form-group has-error">
							<span id="helpBlock6" class="help-block"></span>
							</div>
            </div>
            </div>

						<!-- Text input-->
						 <div class="form-group">
							 <label class="col-sm-3 control-label" for="pmobileno">Parent's Mobile No</label>
							 <div class="col-sm-9">
								 <input type="text" name="pmobileno" class="form-control" required>
								 <div class="form-group has-error">
								 <span id="helpBlock7" class="help-block"></span>
								 </div>
							 </div>
							 </div>


          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <div class="pull-right">
                <button id="btnReg" type="submit" class="btn btn-primary" name="add">Initiate Registration</button>
              </div>
            </div>
          </div>
					<button id="hbutton1" style="visibility:hidden"onclick="client.connect(options);"></button>
	        <button id="hbutton2" style="visibility:hidden" onclick="client.subscribe('student/register', {qos: 2}); "></button>
	        <button id="hbutton3" style="visibility:hidden" onclick="publish('Start Registering','student/init',2);"></button>
	        <button id="hbutton4" style="visibility:hidden" onclick="client.disconnect();"></button>
        </fieldset>
      </form>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
  <?php include "includes/footer.php"?>
