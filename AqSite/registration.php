<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registration</title>
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


    <div class="container">
        <div style="text-align:center">
            <h1>Registration</h1>
        </div>
        <div class="row">
            <div class="column">
                <figure><img src="images/registrationImage.jpg" width="100%" alt="#"></figure>
                <div class="social"> <a target="_blank" title="follow us on instagram" href="https://www.instagram.com"><img alt="follow me on instagram" src="https://c866088.ssl.cf3.rackcdn.com/assets/instagram40x40.png" border=0></a>
                    <a target="_blank" title="follow us on youtube" href="https://www.youtube.com"><img alt="follow me on youtube" src="https://c866088.ssl.cf3.rackcdn.com/assets/youtube40x40.png" border=0></a>
                    <a target="_blank" title="follow us on facebook" href="https://www.facebook.com"><img alt="follow me on facebook" src="https://c866088.ssl.cf3.rackcdn.com/assets/facebook40x40.png" border=0></a>
                </div>
            </div>
			<br/><?php  //Alexey Masyuk,Yulia Berkovich Aquarium Control System
			       // Checking if some error flag returned from connection_action.php page
			       session_start();
                   if(isset($_SESSION['flag']))
				   {
				       echo $_SESSION['flag'];   // Print the error ocured
					   unset($_SESSION['flag']);
				   }
			 ?><br/>
            <div class="column">
                <form method='POST' action='registration_action.php'>
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" placeholder="Your name.." required="">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" placeholder="Your last name.." required="">
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="me@gmail.com" required="">
                    <label>Username</label>
                    <input type="text" name="uname" placeholder="Your username.." required="">
					 <label>Password</label>
                    <input type="text" name="pword" placeholder="Your password.." required="">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <footer>
        &#9990; +97277777777 &#9993; y.b.doar@gmail.com
    </footer>
    <script src="js/index.js"></script>
    <script src="js/contact.js"></script>
</body>

</html>
