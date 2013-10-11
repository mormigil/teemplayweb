<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['email'])){
		header("HTTP/1.1 400 Bad Request");
		print("Valid user must submit");
		exit();
	}
	else{
		$mysqli = new mysqli("localhost", "teemplay_morm", "3EeG9nTn6lid", "teemplay_web");
		$query = "INSERT INTO emaillist (email) VALUES (?)";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $_POST['email']);
		$prep->execute();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
			return false;
		}
		$json_data = array();
		header("Content-type: application/json");
		print(json_encode($json_data));
		exit();
	}
}
?>