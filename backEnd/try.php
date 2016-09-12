<?php
	error_reporting(E_ALL); 
    include "database.php"; 
    $conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());
	//$sql = "SELECT `stars` FROM "
	$sql = "UPDATE `reviews-ml` SET `bus_rate_avg`= `bus-ml`.`stars` WHERE `reviews-ml`.`business_id` = `bus-ml`.`business_id` ";
	$result = mysqli_query($conn, $sql);
			
	if ($result) {	
		echo "worked"; 
	} else {
		echo "failed";
	}
	$conn->close();
?>