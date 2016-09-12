<?php
require_once('database.php');
$UTC = new DateTimeZone("UTC");
$conn = connect();

$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);

if (!empty($_POST)){
	
		
		//asian, casual, unhealthy, healthy, upscale, dietary, cafe, meat, bar, special
		$result = $_POST['result'];
		for($x=0; $x<10; $x++){
			$bus_id = $result[$x]['bus_id'];
			$user_id = $result[$x]['user_id'];
			$rating  = $result[$x]['rating'];
			$cur_date = new DateTime();
			$cur_date = $cur_date->setTimezone($UTC);
			$final_date = $cur_date->format("Y-m-d H:i:s");
			//$sql_date = date("Y-m-d H:i:s", $cur);
			
	        	$sql = "INSERT INTO `foodiepa_try`.`Ratings` (`user_id`, `bus_id`,  `rating`, `rating_date`) VALUES ('$user_id', '$bus_id', '$rating', '$final_date')"; 
			$ret = mysqli_query($conn, $sql);
			if ($ret==FALSE){
				echo "Oops... Something goes wrong...";
				$conn->close();
				break;
			}	
		}
		$conn->close();
		
		/*$sql = "UPDATE `foodiepa_try`.`Users` SET `asian`='$asian',`special`='$special',`casual`='$casual',`unhealthy`='$unhealthy',`healthy`='$healthy',`upscale`='$upscale',`dietary`='$dietary',`cafe`='$cafe',`meat`='$meat',`bar`='$bar' WHERE `id`='$id'";
		$ret = mysqli_query($conn, $sql);
		if ($ret==FALSE) echo "wrong!";
		else echo "success!";
		$conn->close();*/
		/*$sql = "INSERT INTO `foodiepa_try`.`Users` (`id`, `firstName`,  `lastName`, `password` ) VALUES ('$id', '$firstName', '$lastName', '$password')"; 
		$ret = mysqli_query($conn, $sql);
		if ($ret==FALSE) echo "wrong!";
		else echo $firstName;*/
		/*if (mysqli_connect_errno()){
			echo "failed";
			//die("Connection failed: ".$conn->connect_error);
		} else {
			echo "connected"."<br>";
		}*/
		//echo json_encode($array1);
		
	
} else{
	echo "no post to process";
}
//echo "process data here\n";

?>