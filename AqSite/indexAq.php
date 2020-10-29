<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
	 <link rel="icon" href="images/fish.png" type="image/x-icon">
    
    <link rel="stylesheet" href="styles/site.css">
	
    <link href="https://fonts.googleapis.com/css?family=Cinzel|Montserrat|Permanent+Marker|Quicksand" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="topnav" id="myTopnav">
            <a href="indexAq.php" class="logo"> <img src="images/logo.png"  alt="Logo" /></a>
            <a href="indexAq.php">home</a>
            <a href="registration.php">sign up</a>
            <a id="menu" href="#" class="icon">&#9776;</a>
        </nav>
    </header>
	
    <div class="fullscreen-bg">
        <div class="overlay">
           <div id="heading">
            <h1>Aquarium control system</h1>
            <h2>Make your life easier</h2>
			</div>
		    <button class="button-class" id="button" onclick="openForm()">Sign In</button>
		<section id="signInForm">
		<img class="closeButton" src="images/closeButton.png " alt="" onclick="closeForm()">
		
		<?php  
			    // Checking if some error flag returned from connection_action.php page
			       session_start();
                   if(isset($_SESSION['flag']))
				   {
				       echo $_SESSION['flag']; // Print the error ocured
					   unset($_SESSION['flag']);
				   }
				   ?>
      <form method='POST' action='connection_action.php'>
	  
        <div>
          <input type="text" name="uname" required="">
          <label>username</label>
        </div>
        <div>
          <input type="password" name="pword" required="">
          <label>password</label>
        </div>
        <input type="Submit"  value="Sign in">
		<a class="create" href="registration.html">new user?</a>
      </form>
    </section>
		
		<div class="wrapper">
		<div class="arrow one">
		<a href="#info"><img src="images/arrow.png " alt=""></a>

		</div>
		<div class="arrow two">
		<a href="#info"><img src="images/arrow.png " alt=""></a>
		</div>
		
	</div>
	
	
        </div>
        <video loop muted autoplay poster="video/videoplayback3.webm" class="fullscreen-bg__video">
        <source src="video/videoplayback3.webm" type="video/webm">
    </video >
    </div>
	

	
	 <main class="container">
	<p id="info">___________</p>
        <h1>Information</h1>
       <img src="images/info1.jpg " alt="#">
    <div class="grid-container">
    <div class="block">
        <h3>Lorem ipsum dolor sit amet</h3>
        <p>Quisque iaculis justo ut turpis ornare rutrum. Aliquam erat volutpat. Nam vel augue ante. Phasellus sed turpis urna. Proin massa leo, imperdiet quis turpis at, tempus cursus metus. In mauris quam, vulputate consectetur mattis ac, ultrices eget ipsum. Fusce fermentum, sem et facilisis posuere, erat nisi aliquet massa, sit amet luctus ex justo et libero. Pellentesque lacinia elit at velit mollis blandit.</p>
        </div>
         <div class="block">
        <h3>Ut purus quam</h3>
        <p> Ut nisl libero, pretium sit amet tempus at, suscipit quis erat. Quisque malesuada gravida faucibus. Vivamus vehicula tristique bibendum. Nunc aliquet nec urna vehicula bibendum. Mauris molestie placerat quam, id semper turpis aliquet at. Aenean auctor lacus quis semper congue. Integer eu arcu pulvinar, vehicula nisl imperdiet, faucibus arcu. Aliquam erat volutpat. In condimentum vitae lacus a aliquet.</p>
        </div>
         <div class="block">
        <h3>Aenean felis ligula</h3>
        <p>Nunc ultricies justo ut volutpat porta. Nullam tempor tempor ante vitae congue. Nulla facilisi. Sed sed ex eu risus elementum scelerisque nec in mi. Nunc molestie ipsum ut maximus semper. In hac habitasse platea dictumst. Maecenas mollis malesuada quam sit amet bibendum. Etiam ultrices ex sem, vel accumsan metus imperdiet imperdiet. Integer et eros nunc. Quisque fringilla leo id ultrices mollis.</p>
        </div>
         <div class="block">
        <h3>Mauris finibus</h3>
        <p>Pellentesque sed mauris risus. Curabitur non cursus justo. Aenean condimentum faucibus lectus eu consequat. Proin eu libero non leo tempor mattis. Duis ultricies congue felis a vehicula. Proin tincidunt tempus leo, ac varius erat. Pellentesque ut mi quis leo varius facilisis. Pellentesque ligula ligula, elementum a enim vitae, ornare lobortis nisi. Sed consectetur arcu id blandit gravida. Nullam aliquam luctus libero id volutpat.</p>
        </div>
        
       </div>
    </main>

	
    <footer >
    &#9990; +97277777777 &#9993; y.b.doar@gmail.com 
    </footer>
     <script src="js/index.js"></script> 
</body>

</html>
