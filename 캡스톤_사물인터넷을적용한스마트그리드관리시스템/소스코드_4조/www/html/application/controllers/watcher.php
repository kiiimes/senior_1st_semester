<?php	
	$dbConnect = mysqli_connect("203.250.148.23", "root", "ngn787178","smartHome");
	if(mysqli_connect_error()){
		echo "연결 실패: ".mysqli_connect_error();
	}
	mysqli_select_db($dbConnect, "smartHome");
	$time = date("H:i").":00";

	$sql = "select * from push";
	$result = $dbConnect->query($sql);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	while($row = mysqli_fetch_array($result)){
		if($time == $row['pushTime']){
			echo "time!\n";
			require_once('./Push.php');
			$this->push();
		}
	}
?>
