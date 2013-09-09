<?php
if(isset($_COOKIE['username'], $_COOKIE['a'])){
	$username = $_COOKIE['username'];
	$login_string = $_COOKIE['a'];

	$curl = curl_init();
	$url = 'http://localhost/teemplayweb/users.php?username='.$username.'&secret='.$login_string;
	$browser = $_SERVER['HTTP_USER_AGENT'];
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_USERAGENT => $browser));
	$response = curl_exec($curl);
	curl_close($curl);
	$pass = json_decode($response);
	if($pass == 'success'){
		header("Location: http://localhost/teemplayweb/login.html");
		die("redirecting to login page");
	}
}
else{
	echo("no success");
	header("Location: http://localhost/teemplayweb/login.html");
	die("redirecting to login page");
}
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = stylesheet href = "register.css" type = "text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="load_ideas.js"></script>
</head>
<body>
	<div id = "wrapper">
		<div id = "ideas">
		</div><!--#ideas-->
	</div><!--#wrapper-->
</body>
</html>