<?php
require_once("orm/user.php");
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
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
		$password = hash('sha512', $_POST['password'].$random_salt);
		if(empty($_POST['email'])){
			$user = user::findByName($_POST['username']);
			if(is_null($user)){
				header("HTTP/1.1 400 Bad Request");
				print("User name does not exist");
				exit();
			}
			else{
				
				if($user->authenticate($password)){
					$user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $_POST('username')); // XSS protection as we might print this value
					$login_string = hash('sha512', $password.$user_browser);
					setcookie($username, $login_string, strtotime('time+06:00'), '/');
					header("Content-type: application/json");
					print(json_encode($user->getJSON()));
					exit();
				}
				else{
					header("HTTP/1.1 400 Bad Request");
					print("Authentication denied incorrect password");
				}

			}
			die();
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			header("HTTP/1.1 400 Bad Request");
			print("Invalid email address");
			exit();
		}
		$user = user::createUser(NULL, $_POST['username'], $password, $_POST['level'], 
			$_POST['description'], $_POST['votes'], $random_salt, $_POST['email']);
		header("Content-type: application/json");
		print(json_encode($user->getJSON()));
		exit();
	}
}