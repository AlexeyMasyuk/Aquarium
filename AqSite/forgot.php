<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot password</title>
    <link rel="icon" href="images/fish.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/st_forgot.css">
   
    <link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat|Permanent+Marker|Quicksand" rel="stylesheet">
</head>
    <body>
    <header>
        <nav class="topnav" id="myTopnav">
            <a href="indexAq.php" class="logo"> <img src="images/logo.png" width=100% alt="Logo" /></a>
            <a href="indexAq.php">home</a>
            <a href="registration.php">sign up</a>
            <a id="menu" href="#" class="icon">&#9776;</a>
        </nav>
    </header>
	 <div class="fullscreen-bg">
        <div class="overlay">
		<section id="forgotForm">
		<p>Forgot password? Enter your username...</p>
    <form  method='POST' action='PageActClasses/Forget.php'>	  
       <div>
        <input type="text" name="uname" required="">
      </div>
      <input type="Submit"  value="Send">
    </form>
	</section>
    <?php
      require_once('AlertOnHTML.php');
      ?>
	  </div>
	   <video loop muted autoplay poster="video/videoplayback3.webm" class="fullscreen-bg__video">
        <source src="video/videoplayback3.webm" type="video/webm">
    </body>
</html>