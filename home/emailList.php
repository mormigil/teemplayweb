<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_POST['email'])){
		header("HTTP/1.1 400 Bad Request");
		print("Valid user must submit");
		exit();
	}
	else{
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "INSERT INTO emailList (id, email) VALUES (?, ?)";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $_POST['email']);
		return $_POST['email'];
	}
}
?>