<?PHP //Alexey Masyuk,Yulia Berkovich Aquarium Control System
// File to generate random data to SQL user table
session_start();
$servername = "localhost";
$username = "root";
$dbname = "php_prj";
$password="";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$i=0;
while($i<10){
	$date=rand(2000,2020)."-".rand(1,12)."-".rand(1,31)." ".rand(0,23)."-".rand(0,60)."-".rand(0,60);
	$sql = "INSERT INTO `".$_SESSION['dataCreate']."` (`tmp`, `time`) VALUES ('".rand(22,25)."','".$date."')";
	if ($conn->query($sql) === TRUE) {
		$i+=1;
}
 else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
}
$conn->close();
readfile('indexAq  .php');
exit();
?>