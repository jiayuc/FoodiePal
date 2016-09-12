<?php 
    if (!empty($_GET)){
    //if (strlen($_GET['searchTerm']) > 0){
       // $searchTerm = $_GET['searchTerm'];
      
        //==========access restaurant database=================
        $servername = "localhost";
        $username = "foodiepa_sassy";
        $password = "sassy411";
        $conn = mysqli_connect($servername, $username, $password);
        if (mysqli_connect_errno()) echo "failed";

        $dbname = "foodiepa_try";
        mysqli_select_db($conn, $dbname);

        $sql = "SELECT `subcategory` FROM `Categories_api`";

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
    //}
    } 
?>