<?php
require_once("orm/user.php");
require("phpass/PasswordHash.php");
/*If I am getting a user then either I want to display that user's
information - read or delete their information - delete*/
if($_SERVER['REQUEST_METHOD'] == 'GET'){

}
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(!empty($_POST)){
		if(empty($_POST['username'])){
			header("HTTP/1.1 400 Bad Request");
			print("You must enter a username");
			exit();
		}
		if(empty($_POST['password'])){
			header("HTTP/1.1 400 Bad Request");
			print("You must enter a password");
			exit();
		}
		//create salt and salt password
		$hasher = new PasswordHash(8, false);
		// In this case, the password is retrieved from a form input
		$password = $_POST["password"];
		// Passwords should never be longer than 72 characters to prevent DoS attacks

		// The $hash variable will contain the hash of the password
		$hash = $hasher->HashPassword($password);
		if(empty($_POST['email'])){
			$user = user::findByName($_POST['username']);
			if(is_null($user)){
				header("HTTP/1.1 400 Bad Request");
				print("User name does not exist");
				exit();
			}
			else{
				if (strlen($hash) >= 20) {
					$stored_hash = "*";
					$stored_hash = $user->authenticate();
					$check = $hasher->CheckPassword($password, $stored_hash);
					if($check){
						$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
						$username = mysql_real_escape_string($_POST['username']); // XSS protection as we might print this value
						$login_string = hash('sha512', $hash.$user_browser);
						setcookie($username, $login_string, strtotime('time+06:00'), '/');
						header("Content-type: application/json");
						print(json_encode($user->getJSON()));
						exit();
					}
					else{
						header("HTTP/1.1 400 Bad Request");
						print("Authentication denied incorrect password");
					}
				} else {
					die("encryption failure");
				}
			}
			die();
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			header("HTTP/1.1 400 Bad Request");
			print("Invalid email address");
			exit();
		}
		if(strlen($hash)>=20){
		$user = user::createUser(NULL, $_POST['username'], $hash, $_POST['level'], 
			$_POST['description'], $_POST['votes'], $_POST['email']);
		header("Content-type: application/json");
		print(json_encode($user->getJSON()));
		exit();
	}
	else{
		die("encryption failure");
	}
	}
}

//zbarryte