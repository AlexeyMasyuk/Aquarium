<!DOCTYPE html>
<html lang="en">
<head>
    <title>Settings</title>
   <link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat|Permanent+Marker|Quicksand" rel="stylesheet">
    <link rel="icon" href="images/fish.png" type="image/x-icon">
	<link rel="stylesheet" href="styles/st_settings.css">
    <script type="text/javascript" src="js/settingsChange.js"></script>
</head>


<body onload="currentSettings()">
<div class="content">
        <header>
              <nav class="topnav" id="myTopnav">
                <a href="dataTbl.php" class="logo"> <img src="images/logo.png"  alt="Logo" /></a>
                <a href="dataTbl.php">my aquarium</a>
				<a href="settChng.php" onclick="limitsToSettChngData()">settings</a>
                <a href="indexAq.php">sign out</a>
                <a id="menu" href="#" class="icon">&#9776;</a>
            </nav>
      </header>
      <h1>Change Your Settings</h1>
      <div>
      <label>Personal: </label>
      <label class='userSettigs'>FirstName-</label>
      <label class='userSettigs'>,LastName-</label>
      <label class='userSettigs'>,UserName-</label>
      <label class='userSettigs'>,Email-</label>
<br>
      <label class='userSettigs'> ,Aquarium Settings: PH High-</label>
      <label class='userSettigs'>,PH Low-</label>
      <label class='userSettigs'>,Temp. High-</label>
      <label class='userSettigs'>,Temp. Low-</label>
      <label class='userSettigs'>,Puuling Cycle in Ms. </label>
      <label class='userSettigs'>,Feeding Time Alert </label>
      
      </div>
	  
	   <div class="buttons">
      <button type="button" onclick="openOrClose('personal','aqua')">Personal Settings</button>
      <button type="button" onclick="openOrClose('aqua','personal')">Aquarium Settings</button><br>
      </div>

      <?php
      require_once('AlertOnHTML.php');
      ?>
      <form method='POST' action='PageActClasses/SettingsChange.php'>
         <div class="container">
        <div id="personal" >
            <label>All Personal Settings?</label>
            <input type="checkbox" id="allP" onchange="openAllTextBox(value,'personalInput')" value="allP"><br>
    
            <label>email</label>
            <input type="checkbox" class="personalInput" name="emailCheckbox" onclick="openOrClose('email')" value="email">
            <input type="text" class="personalInput" id="email" name="email" style="display: none;"><br>
    
            <label>password</label>
            <input type="checkbox" class="personalInput" name="passCheckbox" onchange="openOrClose('pass')" value="pass">
            <input type="text" class="personalInput" id="pass" name="pass" style="display: none;"><br>
    
            <label>first Name</label>
            <input type="checkbox" class="personalInput" name="fnameCheckbox" onchange="openOrClose('fname')" value="fname">
            <input type="text" class="personalInput" id="fname"  name="fname" style="display: none;"><br>
    
            <label>last Name</label>
            <input type="checkbox" class="personalInput" name="lnameCheckbox" onchange="openOrClose('lname')" value="lname">
            <input type="text" class="personalInput" id="lname" name="lname" style="display: none;"><br>
        </div>
    
        <div id="aqua" class="aqua" >
            <label>All Aqua Settings?</label>
            <input type="checkbox" id="allA" onchange="openAllTextBox(value,'aquaInput')" value="allA"><br>
    
            <label>PH high level</label>
            <input type="checkbox" class="aquaInput" name="phHighCheckbox" onchange="openOrClose('phHigh')" value="phHigh">
            <input type="text" class="aquaInput" id="phHigh"  name="phHigh" style="display: none;"><br>

            <label>PH low level</label>
            <input type="checkbox" class="aquaInput" name="phLowCheckbox" onchange="openOrClose('phLow')" value="phLow">
            <input type="text" class="aquaInput" id="phLow"  name="phLow" style="display: none;"><br>
    
            <label>temperature high level</label>
            <input type="checkbox" class="aquaInput" name="tempHighCheckbox" onchange="openOrClose('tempHigh')" value="tempHigh">
            <input type="text" class="aquaInput" id="tempHigh"  name="tempHigh" style="display: none;"><br>

            <label>temperature low level</label>
            <input type="checkbox" class="aquaInput" name="tempLowCheckbox" onchange="openOrClose('tempLow')" value="tempLow">
            <input type="text" class="aquaInput" id="tempLow"  name="tempLow" style="display: none;"><br>
            
            <label>Feeding Alert</label>
            <input type="checkbox" class="aquaInput" name="feedAlertCheckbox" onchange="openOrClose('feedAlert')" value="feedAlert">
            <p class="aquaInput" name="feedAlert" id="feedAlert" style="display: none;"><br>
             Once in 
              <select name="feedAlert">
                <option value="1">1</option>
                <option value="2">2</option>
              </select>
             day/days.
            </p>
            <br><br>
        </div>
		
	         
            <input type="submit" value="Apply settings" id="applyButton">
         </div>
    </form>
	 <video loop muted autoplay poster="video/ClearWater.mp4" class="BgVideo">
                        <source src="video/ClearWater.mp4" type="video/mp4">
                 </video >
	</div>		 
	  <footer >
    &#9990; +97277777777 &#9993; y.b.doar@gmail.com 
    </footer>
    </body>
</html>