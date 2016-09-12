<?php
function connect(){
	$servername = "localhost";
	$username = "foodiepa_sassy";
	$password = "sassy411";
	$conn = mysqli_connect($servername, $username, $password);
	if (mysqli_connect_errno()){
		die("Connection failed: ".$conn->connect_error);
	} else {
		//echo "connect"."<br>";
		return $conn;
	}
}

function addRestaurant($id,$name,$phone,$address,$rating,$reservationURL,$reviewCount,$imageUrl,$city,$postal_code,$snippet_text,$state,$rating_img_url,$rating_img_url_small, $url){
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$stmt = $conn->prepare("INSERT INTO Restaurant (id,name,phone,address,stars,reservationURL,reviewCount,imageUrl,city,postal_code,snippet_text,state,rating_img_url,rating_img_url_small, url) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssississsss", $id,$name,$phone,$address,$rating,$reservationURL,$reviewCount,$imageUrl,$city,$postal_code,$snippet_text,$state,$rating_img_url,$rating_img_url_small, $url);
	$stmt->execute();

	$stmt->close();
	$conn->close();
}

function addUser($id, $firstName, $lastName, $password, $image_url) {
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$stmt = $conn->prepare("INSERT INTO Users (id, firstName, lastName, password, image_url) VALUES (?,?,?,?,?)");
	$stmt->bind_param("sssss", $id, $firstName, $lastName, $password, $image_url);
	$stmt->execute();

	$stmt->close();
	$conn->close();
}

function addReview($id, $rating, $rating_image_url, $rating_image_small_url, $excerpt, $time_created, $userid ) {
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$stmt = $conn->prepare("INSERT INTO Reviews (id, rating, rating_image_url, rating_image_small_url, excerpt, time_created, userid) VALUES (?,?,?,?,?,?,?)");
	$stmt->bind_param("sisssis", $id, $rating, $rating_image_url, $rating_image_small_url, $excerpt, $time_created, $userid);
	$stmt->execute();

	$stmt->close();
	$conn->close();
}


function sReviewByUser($userId){
	//search for reviews written by this user
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$userId = mysqli_real_escape_string($conn, $userId);
	$sql = "SELECT * FROM Reviews WHERE userid = '$userId' ";
	$result = $conn->query($sql);

	$count = 0;
	if ($result->num_rows > 0) {
	    if (mysqli_num_rows($result)>0) {
			while ($row = mysqli_fetch_assoc($result) ) {
	    		$array[$count] = json_encode($row);
	    		return json_encode($row);
	    		$count = $count+1;
			}
		}
	    return json_encode($array);
	} else {
	    return -1;
	}
	$conn->close();
}


function lastCategory(){
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$sql = "select id from Categories_api order by id desc limit 1";
	$result = $conn->query($sql);


	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        return $row['id'];
	    }
	} else {
	    echo "0 results";
	}
	$conn->close();
}



function categoryID2($c1,$c2){
	//param:category,subcategory
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$sql = "select id from Categories_api where category='$c1' and subcategory='$c2'";
	$result = $conn->query($sql);


	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        return $row['id'];
	    }
	} else {
	    return -1;
	}
	$conn->close();
}

function categoryID1($category){
	//match category or subcategory
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());

	$sql = "select id from Categories_api where category='$category' or subcategory='$category'";
	$result = $conn->query($sql);


	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        return $row['id'];
	    }
	} else {
	    return -1;
	}
	$conn->close();
}



function addCategory($c1,$c2){
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());
	
	$sql = "INSERT INTO Categories_api (category, subcategory) VALUES ('$c1','$c2')";
	
	if ($conn->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close();

}

function addRC($rid,$cid){
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());
	
	$sql = "INSERT INTO Restaurant_Categories (rid,cid) VALUES ('$rid','$cid')";
	
	if ($conn->query($sql) === FALSE) {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close();

}

function delete_res_tuple($attribute, $value, $conn){
    if ( mysqli_query($conn, "DELETE FROM `Restaurant` WHERE `$attribute` IS NULL") == FALSE ) {
        echo "error sql";
    } else {
        echo "ok";
    } 
}

function clear_table($tableName){
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname) or
	die("Unable to select databse: ".mysql_error());
    if ( mysqli_query($conn, "DELETE * FROM Users WHERE 1")  == FALSE ) {
        echo "error sql";
    } else {
        echo "ok";
    } 	
    $conn->close();
}

function delete_cat_tuple($attribute, $value, $conn){
    if ( mysqli_query($conn, "DELETE * FROM `Categories` WHERE `name` <> 1") == FALSE ) {
        echo "error sql";
    } else {
        echo "ok";
    } 
}

?>