<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	$mysqli = new mysqli('localhost:3306', 'root', '', 'nu');
	if ($mysqli->connect_errno) {
    	printf("Connect failed: %s\n", $mysqli->connect_error);
    	exit();
	}
}
?>