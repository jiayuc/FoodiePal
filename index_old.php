<?php
include 'register.html';
include 'processRegister.php';
include 'jsonParser.php'; 
//==============process POST from user registration====

//==========Welcome and guest count================
$File = "counter.txt";  
$handle = fopen($File, 'r+') ;  //permission read plus write   
$data = fread($handle, 512) ;  //get the count from file 
$count = $data + 1;  
print "Welcome to FoodiePal, you are ".$count ."th visitor =) ";  //Prints the count on the page   
fseek($handle, 0) ;  //move cursor to beginning 
fwrite($handle, $count) ;  //write updated file   
fclose($handle) ;  
include 'search.html';
?>