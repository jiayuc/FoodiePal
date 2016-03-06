<?php
include 'register.html';
include 'jsonParser.php'; 
//==========Welcome and guest count================
$File = "counter.txt";  
$handle = fopen($File, 'r+') ;  //permission read plus write   
$data = fread($handle, 512) ;  //get the count from file 
$count = $data + 1;  
print "Welcome to FoodiePal, you are ".$count ."th visitor =) ";  //Prints the count on the page   
fseek($handle, 0) ;  //move cursor to beginning 
fwrite($handle, $count) ;  //write updated file   
fclose($handle) ;  

//==========access restaurant database=================
$servername = "localhost";
$username = "foodiepa_sassy";
$password = "sassy411";
$conn = mysqli_connect($servername, $username, $password);
if (mysqli_connect_errno()){
	die("Connection failed: ".$conn->connect_error);
} 
$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);

$sql = "INSERT INTO `foodiepa_try`.`Restaurant` (`id`, `name`, `phone`) VALUES (\'123456\', \'imaginary food place\', \'6106210089\'), (\'654321\', \'very much jk\', \'12345678888\');";
$sql = "SELECT * FROM Restaurant";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result)>0) {
	while ($row = mysqli_fetch_assoc($result) ) {
	echo "Restaurant ID:". $row["id"]. ",Name: " .$row["name"]. ",Phone number: " .$row["phone"]."<br>";
	} } else {
	echo "No Students found";
}
?>