<?php
	require_once('database.php');
	$conn = connect();
	$dbname = "foodiepa_try";
	mysqli_select_db($conn, $dbname);

	if (!empty($_GET)){
		if (strlen($_GET["id"]) > 0){
			$id = $_GET["id"];          
			$sql = "SELECT `bus_id`,`rating` FROM `Ratings` WHERE `user_id` = '$id' "; 
			$result = mysqli_query($conn, $sql);
			if ($result == FALSE) {
				//no review
				echo 'no review record'.'<br>';
			} else {
		        $request = "";
		        if (mysqli_num_rows($result)>0) {
		            while ($row = mysqli_fetch_assoc($result) ) {
		                    $array[] = array($row["bus_id"], $row["rating"]);
		                    $request = $request.",".$row["bus_id"].",".$row["rating"];
		            }
		            $request = substr($request,1);
		            //echo $request;


		            //send request via TCP===============================
		            $socket=socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
					if ( !$socket ) {
					    $errno = socket_last_error();
					    $error = sprintf('%s (%d)', socket_strerror($errno), $errno);
					    trigger_error($error, E_USER_ERROR);
					}

					//TODO:change host address
					if ( !socket_connect($socket, '172.22.153.97', 9999) ) {
					    $errno = socket_last_error($socket);
					    $error = sprintf('%s (%d)', socket_strerror($errno), $errno);
					    trigger_error($error, E_USER_ERROR);
					}

					$buff = $request;
					$length = strlen($buff);
					$sent = socket_write($socket, $buff, $length);
					if ( FALSE === $sent ) {
					    $errno = socket_last_error($socket);
					    $error = sprintf('%s (%d)', socket_strerror($errno), $errno);
					    trigger_error($error, E_USER_ERROR);
					}
					else if ( $length!==$sent ) {
					    $msg = sprintf('only %d of %d bytes sent', $length, $sent);
					    trigger_error($msg, E_USER_NOTICE);
					}


			        if (false === ($buf = socket_read($socket, 600, PHP_NORMAL_READ))) {
			        	die();
			            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($socket)) . "\n";
			            break 2;
			        }
			        // if (!$buf = trim($buf)) {
			        //     continue;
			        // }
			        // echo "$buf\n";
					$my_file = 'cjy.txt';
		            $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
					fwrite($handle, $buf);
					fclose($handle);
				    socket_close($socket);				


					//=======end of TCP===========
					$response = "sitara-urbana,black-dog-smoke-and-ale-house-urbana,sushi-kame-champaign";
					$response = $buf;
					$busArr = explode(',', $response);
					//echo $busArr;
					foreach ($busArr as $busid) {
			            $sql = "SELECT * FROM `Restaurant` WHERE `id` = '$busid' "; 
			            $result = mysqli_query($conn, $sql);
	            		if ($result == FALSE) echo 'search failed'.'<br>';  
	            		if (mysqli_num_rows($result)>0) {
		                	while ($row = mysqli_fetch_assoc($result) ) {
		                    	$retarr[] = $row;
		                	}
	           			}
	           		}
            		echo json_encode($retarr); 
		        }
		    }

		} else{
			echo "empty user email";
		}
	} else {
		echo "empty $_GET";
	}
	$conn->close();
?>