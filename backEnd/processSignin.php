<?php
//==========access restaurant database=================
include "database.php"; 
$servername = "localhost";
$username = "foodiepa_sassy";
$password = "sassy411";
$conn = mysqli_connect($servername, $username, $password);
if (mysqli_connect_errno()) echo "failed";

$dbname = "foodiepa_try";
mysqli_select_db($conn, $dbname);

//==========process sign in===========
if(!empty($_POST['email']) && !empty($_POST['pwd']))
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    $checklogin = mysqli_query($conn,"SELECT * FROM Users WHERE id = '$email' AND password = '$pwd'");
    $checkexist = mysqli_query($conn, "SELECT * FROM Users WHERE id = '$email' "); 

    $ret = array();
    if ( mysqli_num_rows($checkexist) == 0 ) {
        $ret['loggedIn'] = 0;
    } else {
        if( mysqli_num_rows($checklogin) > 0 ) {
            $row = mysqli_fetch_array($checklogin);
            
            $ret['email'] = $row['id'];
            $ret['firstName'] = $row['firstName'];
            $ret['lastName'] = $row['lastName'];
            $ret['image_url'] = $row['image_url'];
            $ret['loggedIn'] = 1;
           # $array = sReviewByUser($row['id']);
            #echo $array;

        } else {
            $ret['loggedIn'] = 2;
        }
    }   
    echo json_encode($ret);
    $conn->close();
} else {
    echo "Error: wrong _POST, one field is empty";
}

?>