<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aquarium</title>
     <link rel="icon" href="images/fish.png" type="image/x-icon">
	 
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="js/chart.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat|Permanent+Marker|Quicksand" rel="stylesheet">
	<link rel="stylesheet" href="styles/st_dataTbl.css">
 </head>
 
 <body onload="change()">
  <header>
        <nav class="topnav" id="myTopnav">
            <a href="dataTbl.php" class="logo"> <img src="images/logo.png"  alt="Logo" /></a>
   
            <a href="signOut.php">sign out</a>
            <a id="menu" href="#" class="icon">&#9776;</a>
        </nav>
  </header>
	  <h1>Your aquarium</h1>
    <div id="alarms_div" style="width: 100%; height: 20%; text-align: center; overflow-y:scroll;"></div>
    
    <div id="chart_div" style="width: 100%; height: 500px;"></div>
    <select id="chart" onchange="ContentSwich()">
      <option name="select" value="Temp">Temp</option>
      <option name="select" value="PH">PH</option>
      <option name="select" value="level">Level</option>
    </select>
    <select id="chartFilter" onchange="openSelection(value)" >
      <option name="select" value="all">All Collected</option>
      <option name="select" value="day">Day</option>
      <option name="select" value="month">Month</option>
    </select>
    <p id="day" class="dayMonth" style="display: none;">Enter DD.MM.YY day format</p>
    <p id="month" class="dayMonth" style="display: none;">Enter MM.YY month format</p>
    <form class="dayMonth" id="dayMonthForm" onsubmit="dateFormatValidation(); return false;" style="display: none;">
    <input type="text" id="wantedDate">
    <input type="submit" value="Submit">
    </form>
    <a class="forgot" href="settChng.php">Settings Change</a>
	
	
	 
	
  </body>
</html>	