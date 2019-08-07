<?php

$host = 'localhost';
$user = 'root';
$pw = 'ngn787178';
$dbName = 'smartHome';
$mysqli = new mysqli($host, $user, $pw, $dbName);

if($mysqli){
	echo "MySQL 접속 성공";
} else {
	echo "MySQL 접속 실ㅠㅐ";
}

?>
