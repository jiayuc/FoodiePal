<?php
error_reporting(E_ALL);
require_once('database.php');
	$conn = mysqli_connect('localhost', 'root', 'uiuc');
	if (mysqli_connect_errno()){
		die("Connection failed: ".$conn->connect_error);
	} else {
		return $conn;
	}
// copy file content into a string var
$handle = fopen("miniB.json", "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
    	echo $line ."<br>";
        $json_a = json_decode($line);
        echo $json_a->business_id ."<br>";
        echo $json_a->full_address ."<br>";

	}
	 fclose($handle);
} else {
    // error opening the file.
} 

/*// read the title value
$business_id = $jfo->business_id;
echo $jfo->full_address ;
// copy the posts array to a php var
$tags = $jfo->categories;
// listing posts
foreach ($tags as $tag) {
    echo $tag;
}*/
?>