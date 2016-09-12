<?php 
     if (!empty($_GET)){

        if ( strlen( $_GET['category_name'] ) >0 || strlen($_GET['rest_name'] ) > 0 )  {
            $category_name = $_GET['category_name'];
            $rest_name = $_GET['rest_name'];

            //==========access restaurant database=================
            $servername = "localhost";
            $username = "foodiepa_sassy";
            $password = "sassy411";
            $conn = mysqli_connect($servername, $username, $password);
            if (mysqli_connect_errno()) echo "failed";

            $dbname = "foodiepa_try";
            mysqli_select_db($conn, $dbname);

            if ( $category_name ) {
                if ( $rest_name ) {
                    $sql = "SELECT * FROM `Restaurant` WHERE `id` IN  (SELECT `id` FROM `Restaurant` WHERE `name`='$rest_name') UNION 
                            SELECT * FROM `Restaurant` WHERE `id` IN  (SELECT `rid` FROM  `Restaurant_Categories` WHERE `cid` IN ( SELECT `id` FROM `Categories_api`  WHERE `category`='$category_name' OR `subcategory`='$category_name' )  )";
                } else { //no restaurant
                    $sql = "SELECT * FROM `Restaurant` WHERE `id` IN  (SELECT `rid` FROM  `Restaurant_Categories` WHERE `cid` IN ( SELECT `id` FROM `Categories_api`  WHERE `category`='$category_name' OR `subcategory`='$category_name' )  )";
                }
            }else{
            	$sql="SELECT * FROM `Restaurant` WHERE `id` IN  (SELECT `id` FROM `Restaurant` WHERE `name`='$rest_name')";
            }

            $result = mysqli_query($conn, $sql);
            if ($result == FALSE) echo 'search failed'.'<br>';
            $count = 0;
            if (mysqli_num_rows($result)>0) {
                while ($row = mysqli_fetch_assoc($result) ) {
                    $array[] = $row;
                    $count = $count+1;
                }
            }
            echo json_encode($array);
            $conn->close();
    } 
    
     } else {
         echo "empty";
         //die();
     }
?>