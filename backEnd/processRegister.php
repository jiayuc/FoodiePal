<?php
require_once('database.php');

$conn = connect();

$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);

if (!empty($_POST)){
	if (strlen($_POST['firstname']) > 0){
		
		$id = mysqli_real_escape_string($conn, $_POST['email']);
    		$password = mysqli_real_escape_string($conn, $_POST['password']);
    		
		$firstName = mysqli_real_escape_string($conn, $_POST['firstname']);
		$lastName = mysqli_real_escape_string($conn, $_POST['lastname']);
		$checkexist = mysqli_query($conn, "SELECT * FROM Users WHERE id = '$id' "); 
		if ( mysqli_num_rows($checkexist) == 0 ) {
        		$sql = "INSERT INTO `foodiepa_try`.`Users` (`id`, `firstName`,  `lastName`, `password` ) VALUES ('$id', '$firstName', '$lastName', '$password')"; 
			$ret = mysqli_query($conn, $sql);
			$arr = array('firstName' => $firstName, 'id' => $id);
			if ($ret==FALSE) 
				echo "Oops... Something goes wrong...";
			else 
				echo json_encode($arr);	
    		}else{
    			echo "used";
    		}

		
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