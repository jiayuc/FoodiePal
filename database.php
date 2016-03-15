<?php
function connect(){
	$servername = "localhost";
	$username = "foodiepa_sassy";
	$password = "sassy411";
	$conn = mysqli_connect($servername, $username, $password);
	if (mysqli_connect_errno()){
		die("Connection failed: ".$conn->connect_error);
	} else {
		return $conn;
	}
}

function connect2($username, $password){
	$servername = "localhost";
	$conn = mysqli_connect($servername, $username, $password);
	if (mysqli_connect_errno()){
		die("Connection failed: ".$conn->connect_error);
	} else {
		return $conn;
	}
}

function addRestaurant($id,$name,$phone,$address,$rating,$reservationURL,$reviewCount,$imageUrl,$city,$postal_code,$snippet_text){
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$stmt = $conn->prepare("INSERT INTO Restaurant (id,name,phone,address,rating,reservationURL,reviewCount,imageUrl,city,postal_code,snippet_text) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssissis", $id,$name,$phone,$address,$rating,$reservationURL,$reviewCount,$imageUrl,$city,$postal_code,$snippet_text);
	$stmt->execute();

	$stmt->close();
	$conn->close();
}

?>