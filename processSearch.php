<?php
echo "Search Result for ".$_GET['searchTerm']."<br>";
echo strcmp($_GET['searchTerm'], "very much jk");
if (!empty($_GET)){
	if (strlen($_GET['searchTerm']) > 0){
		$searchTerm = $_GET['searchTerm'];
		//==========access restaurant database=================
		$servername = "localhost";
		$username = "foodiepa_sassy";
		$password = "sassy411";
		$conn = mysqli_connect($servername, $username, $password);
		if (mysqli_connect_errno()){
			die("Connection failed: ".$conn->connect_error);
		} else {
			echo "connected"."<br>";
		}
		$dbname = "foodiepa_try";
		mysqli_select_db($conn, $dbname);
		
		$sql = "SELECT * FROM `Restaurant` WHERE (`categories`='$searchTerm' OR `name`= '$searchTerm')";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result)>0) {	
			while ($row = mysqli_fetch_assoc($result) ) {
				echo "Restaurant ID:". $row["id"]. ",Name: " .$row["name"]. ",Phone number: " .$row["phone"]."<br>";
			} 
		} else {
			echo "No result found<br>";
		}
		$conn->close();
	}
} else {
		header('location: thanks.php');//change to last page
}
	// sql to create table
	/*
	$sql = "INSERT INTO `foodiepa_try`.`Restaurant` (`id`, `name`, `phone`) VALUES (\'123456\', \'imaginary food place\', \'6106210089\'), (\'654321\', \'very much jk\', \'12345678888\');";
	$sql = "CREATE TABLE Users (
		ADD COLUMN id INT(10) PRIMARY, 
		ADD COLUMN firstName VARCHAR(10) NOT NULL,
		ADD COLUMN lastName VARCHAR(10) NOT NULL,
		ADD COLUMN gender CHAR(1) NOT NULL,
		ADD COLUMN age INT(3) 
		)";
	
	if ($conn->query($sql) === TRUE) {
	    echo "Table foodiepa_try modified successfully\n";
	} else {
		printf("\nErrormessage: %s\n", $conn->error);
	}
	*/
?>