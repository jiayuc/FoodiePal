<?php

if (!empty($_POST)){
	if (strlen($_POST['name']) > 0){
		header('location: thanks.php');
	}
} else{
	echo "no post to process";
}
echo "process data here\n";
echo $_POST['name'] ;
?>