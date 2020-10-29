<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="fish.png" type="image/x-icon">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat|Permanent+Marker|Quicksand" rel="stylesheet">
</head>

<body onload="change('temp')">
	<h1>Your aquarium</h1>
    <?php include 'js/chart.php';?>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
    <select id="chart" onChange="change(this.value)">
    <option name="select" value="temp">Temp</option>
    <option name="select" value="PH">PH</option>
    <option name="select" value="level">Level</option>
  </select>
    </body>
</html>	