<?php
$servername = "localhost";
$username = "foodiepa_sassy";
$password = "sassy411";
$conn = mysqli_connect($servername, $username, $password);
if (mysqli_connect_errno()){
    die("Connection failed: ".$conn->connect_error);
}
$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);
echo $_POST['deleteid'];
if (isset($_POST['id'])){
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = $_POST['phone'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $stars = $_POST['stars'];
    $reviewCount = $_POST['reviewCount'];
    $imageUrl = $_POST['imageUrl'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $snippet_text = $_POST['snippet_text'];
    $state = $_POST['state'];
    $tagName = mysqli_real_escape_string($conn, $_POST['categories']);    
    
    
    $ret2=mysqli_query($conn, "SELECT * FROM `Restaurant` WHERE `id`='$id'");
    //update existing Restaurant
    if (mysqli_num_rows($ret2)>0){
        $ret2 = mysqli_fetch_assoc($ret2); 
        $name = $name? $name: $ret2['name'];
        $phone = $phone? $phone: $ret2['phone'];
        $address = $address? $address: $ret2['address'];
        $stars = $stars? $stars: $ret2['stars'];
        $reviewCount = $reviewCount? $reviewCount : $ret2['reviewCount'];
        $imageUrl = $imageUrl? $imageUrl: $ret2['imageUrl'];
        $city = $city? $city: $ret2['city'];
        $postal_code = $postal_code? $postal_code: $ret2['postal_code'];
        $snippet_text = $snippet_text? $snippet_text: $ret2['snippet_text'];
        $state = $state? $state: $ret2['state'];
        $categories = $categories? $categories: $ret2['categories']; 
        $sql="UPDATE `Restaurant` SET `name`= '$name',`phone`= '$phone',`address`= '$address',`stars`= '$stars',`reviewCount`= '$reviewCount',`imageUrl`= '$imageUrl',`city`= '$city',`postal_code`= '$postal_code',`snippet_text`= '$snippet_text',`state`= '$state' WHERE `id` = '$id'";
        $ret = mysqli_query($conn, $sql);
        if ($ret==FALSE) echo "Failed to update Restaurant ".$name."<br>";
        else echo "Restaurant ".$name." updated <br>"; 

        if ($tagName) {
            $sql = "UPDATE `Categories_api` SET `subcategory`= '$tagName' WHERE `id` = '$id' ";
            if (mysqli_query($conn, $sql)==FALSE) echo "Failed to update tag ".$tagName."<br>";
        }
    //insert new Restaurant
    } else {

        $sql = "INSERT INTO `foodiepa_try`.`Restaurant` (`id`, `name`, `address`, `stars`, `reviewCount`, `city`,  `state`, `phone`,
                             `imageUrl`, `postal_code`, `snippet_text`) 
                VALUES ('$id', '$name', '$address', '$stars', '$reviewCount', '$city' , '$state', '$phone',  '$imageUrl', 
                        '$postal_code', '$snippet_text')";   
        $ret = mysqli_query($conn, $sql);
        if ($ret==FALSE) echo "Failed to insert Restaurant ".$name."<br>";
        else echo "Restaurant ".$name." inserted <br>";  

        if ( mysqli_query($conn, "INSERT INTO `foodiepa_try`.`Categories_api`(`id`, `subcategory`) VALUES ('$id', '$tagName') ") == FALSE )  
            echo "error with tag".$tagName."<br>";
            
            
    }
//delete Restaurant
} else if (isset($_POST['deleteid'])){
	$deleteid = $_POST['deleteid'];
	echo " Trying to delete ".$_POST['deleteid']."<br>";
    $sql = "DELETE FROM `Restaurant` WHERE `id`= '$deleteid' ";
    $ret = mysqli_query($conn, $sql);
    if ($ret==FALSE) echo "Failed to delete!<br>";
    else echo "Restaurant ".$name." with id ".$_POST['deleteid']." deleted <br>";    

    $sql = "DELETE  FROM `Categories_api` WHERE `id`= '$deleteid' ";
    $ret = mysqli_query($conn, $sql);
    if ($ret==FALSE) echo "Failed to delete category for this Restaurant!<br>";

} else {
    echo "post failed";
}
?>