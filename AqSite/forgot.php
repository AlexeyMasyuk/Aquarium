<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Pass</title>
    <link rel="icon" href="fish.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/st_registration.css">
   
    <link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat|Permanent+Marker|Quicksand" rel="stylesheet">
</head>
    <body>
    <header>
        <nav class="topnav" id="myTopnav">
            <a href="indexAq.php" class="logo"> <img src="log.png" width=100% alt="Logo" /></a>
            <a href="indexAq.php">home</a>
            <a href="registration.php">sign up</a>
            <a id="menu" href="#" class="icon">&#9776;</a>
        </nav>
    </header>
    <form style="margin-top:20%;" method='POST' action='forgot_action.php'>	  
      <div>
        <label>username</label>
        <input type="text" name="uname" required="">
      </div>
      <input type="Submit"  value="Sign in">
    </form>
    <?php
      if(session_status() == PHP_SESSION_NONE){
        session_start();
      }
      if(isset( $_SESSION['flag'])){
          echo $_SESSION['flag'];
          unset($_SESSION['flag']);
      }
      ?>
    </body>
</html>