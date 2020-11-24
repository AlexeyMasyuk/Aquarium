<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/st_dataTbl.css">
    <title>Settings</title>
    <link rel="icon" href="images/fish.png" type="image/x-icon">
    <script type="text/javascript" src="js/settingsChange.js"></script>
</head>


    <body>
        <header>
            <nav class="topnav" id="myTopnav">
                <a href="dataTbl.php" class="logo"> <img src="images/logo.png"  alt="Logo" /></a>
       
                <a href="indexAq.php">sign out</a>
                <a id="menu" href="#" class="icon">&#9776;</a>
            </nav>
      </header>
      <h1>Change Your Settings</h1>
      <button type="button" onclick="openOrClose('personal')">Personal</button>
      <button type="button" onclick="openOrClose('aqua')">Aquarium</button><br>

      <?php
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }
      if(isset( $_SESSION['flag'])){
          echo $_SESSION['flag'];
          unset($_SESSION['flag']);
      }
      ?>
      <form method='POST' action='settingsChange_action.php'>
          <div id="personal" style="display: none;">
            <label>All Personal Settings</label>
            <input type="checkbox" id="allP" onchange="openAllTextBox(value,'personalInput')" value="allP"><br>
    
            <label>email</label>
            <input type="checkbox" class="personalInput" name="emailCheckbox" onclick="openOrClose('email')" value="email">
            <input type="text" class="personalInput" id="email" name="email" style="display: none;"><br>
    
            <label>Password</label>
            <input type="checkbox" class="personalInput" name="passCheckbox" onchange="openOrClose('pass')" value="pass">
            <input type="text" class="personalInput" id="pass" name="pass" style="display: none;"><br>
    
            <label>First Name</label>
            <input type="checkbox" class="personalInput" name="fnameCheckbox" onchange="openOrClose('fname')" value="fname">
            <input type="text" class="personalInput" id="fname"  name="fname" style="display: none;"><br>
    
            <label>Last Name</label>
            <input type="checkbox" class="personalInput" name="lnameCheckbox" onchange="openOrClose('lname')" value="lname">
            <input type="text" class="personalInput" id="lname" name="lname" style="display: none;"><br>
            </div>
    
            <div id="aqua" class="aqua" style="display: none;">
            <label>All Aqua Settings</label>
            <input type="checkbox" id="allA" onchange="openAllTextBox(value,'aquaInput')" value="allA"><br>
    
            <label>PH</label>
            <input type="checkbox" class="aquaInput" name="phCheckbox" onchange="openOrClose('ph')" value="ph">
            <input type="text" class="aquaInput" id="ph"  name="ph" style="display: none;"><br>
    
            <label>Temperature</label>
            <input type="checkbox" class="aquaInput" name="tempCheckbox" onchange="openOrClose('temp')" value="temp">
            <input type="text" class="aquaInput" id="temp"  name="temp" style="display: none;"><br>
            </div>
    
            <input type="submit" value="Submit"><br>
    </form>
    </body>
</html>