<html>
<head>
  <title>test Ws mqtt.js</title>
</head>
<body>
<script src="./browserMqtt.js"></script>
<script>
  var client = mqtt.connect("ws://broker.mqttdashboard.com") // you add a ws:// url here
  client.subscribe("mqtt/demo")

  client.on("message", function (topic, payload) {
    alert([topic, payload].join(": "))
    client.end()
  })

  client.publish("mqtt/demo", "hello world!")
</script>
</body>
</html>
