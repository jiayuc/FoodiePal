<?php
require_once('database.php');

$conn = connect();

$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);

if (!empty($_GET)){
	if (strlen($_GET['id']) > 0){
		
		$id = $_GET['id'];

		$sql = "SELECT `rating`, `rating_date`,`name`, `phone`, `address`, `stars`, `reviewCount`, `imageUrl`, `city`, `postal_code`, `snippet_text`, `state`, `rating_img_url`, `rating_img_url_small`, `url` FROM `Ratings`, `Restaurant` WHERE `Ratings`.`bus_id` = `Restaurant`.`id` AND `user_id`= '$id'"; 
		$date = mysqli_query($conn, $sql);
		if ($date==FALSE) echo "wrong!";
		$count = 0;
	        if (mysqli_num_rows($date)>0) {
	            while ($row = mysqli_fetch_assoc($date) ) {
	                $array[] = $row;
	                $count = $count+1;
	            }
	        }
		        
		echo json_encode($array);
		//$sql2  = "SELECT * FROM `Restaurant` WHERE `id` IN (SELECT `bus_id`, `rating`, `rating_date` FROM `foodiepa_try`.`Ratings` WHERE `user_id`= '$id')";
		//$ret = mysqli_query($conn, $sql);
		//$arr = array('firstName' => $firstName, 'id' => $id);
		//if ($ret==FALSE) echo "wrong!";
		//else echo json_encode($arr);
		
		//echo json_encode($array1);
		
		$conn->close();
	}
} else{
	echo "no post to process";
}
?>