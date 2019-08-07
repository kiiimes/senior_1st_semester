<?php	
	$dbConnect = mysqli_connect("203.250.148.23", "root", "ngn787178","smartHome");
	if(mysqli_connect_error()){
		echo "연결 실패: ".mysqli_connect_error();
	}
	mysqli_select_db($dbConnect, "smartHome");
	$time = date("H:i").":00";

	$sql = "select * from push";
	$result = $dbConnect->query($sql);
	//$row = $result->mysqli_fetch_assoc($result);
	while($row = mysqli_fetch_array($result)){
		if($time == $row['pushTime']){
			echo "time!\n";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://203.250.148.23/index.php/push/push/");
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			echo 'finish';
		}
	}
/*
	//test용
	echo "start"."\n";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://203.250.148.23/index.php/push/push/");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	curl_close($ch);
	echo "finish"."\n";
*/
?>
