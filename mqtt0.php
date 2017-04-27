<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
        <script src="http://www.hivemq.com/demos/websocket-client/js/mqttws31.js" type="text/javascript"></script>
        <title>HiveMQ MQTT Websocket Demo App</title>
        <script type="text/javascript">
         //Using the HiveMQ public Broker, with a random client Id
 var client = new Messaging.Client("broker.mqttdashboard.com", 8000, "myclientid_" + parseInt(Math.random() * 100, 10));

 //Gets  called if the websocket/mqtt connection gets disconnected for any reason
 client.onConnectionLost = function (responseObject) {
     //Depending on your scenario you could implement a reconnect logic here
     alert("connection lost: " + responseObject.errorMessage);
 };
 //Gets called whenever you receive a message for your subscriptions
 client.onMessageArrived = function (message) {
     //Do something with the push message you received
     $('#messages').append('<span>Topic: ' + message.destinationName + '  | ' + message.payloadString + '</span><br/>');
 };
 //Connect Options
 var options = {
     timeout: 3,
     //Gets Called if the connection has sucessfully been established
     onSuccess: function () {
         //alert("Connected");
         console.log("Connected");
         client.subscribe('student/register', {qos: 2});


         //alert('Subscribed');
         console.log("subscribed");
         console.log("Published");
     },
     //Gets Called if the connection could not be established
     onFailure: function (message) {
         alert("Connection failed: " + message.errorMessage);
     }
 };
 client.connect(options);
    </script>
    </head>
    <body>
        <button onclick="client.disconnect();">(4. Disconnect)</button>
        <div id="messages"></div>
    </body>
</html>
