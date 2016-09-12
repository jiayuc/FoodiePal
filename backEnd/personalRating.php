<?php
$UTC = new DateTimeZone("UTC");
require_once('database.php');

$conn = connect();

$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);

if (!empty($_POST)){
	if (strlen($_POST['user_id']) > 0){
		
		$user_id = $_POST['user_id'];
    		$bus_id = $_POST['bus_id'];
		$rating= $_POST['rating'];
		//$cur_date = new DateTime(null, new DateTimeZone('UTC'));
		$cur_date = new DateTime();
		$cur_date = $cur_date->setTimezone($UTC);
		$result = $cur_date->format("Y-m-d H:i:s");
		//$sql_date = date("Y-m-d H:i:s", $cur);
		
        	$sql = "INSERT INTO `foodiepa_try`.`Ratings` (`user_id`, `bus_id`,  `rating`, `rating_date`) VALUES ('$user_id', '$bus_id', '$rating', '$result')"; 
		$ret = mysqli_query($conn, $sql);
		if ($ret==FALSE) 
			echo "Oops... Something goes wrong...";
		else 
			echo "success posting rating";	
    	

		
		/*if (mysqli_connect_errno()){
			echo "failed";
			//die("Connection failed: ".$conn->connect_error);
		} else {
			echo "connected"."<br>";
		}*/
		//echo json_encode($array1);
		
		$conn->close();
	}
} else{
	echo "no post to process";
}

?>