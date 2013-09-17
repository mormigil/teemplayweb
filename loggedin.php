<?php
if(isset($_COOKIE['username'], $_COOKIE['a'])){
	$userid = $_COOKIE['username'];
	$login_string = $_COOKIE['a'];

	$curl = curl_init();
	$url = 'http://localhost/teemplayweb/users.php?username='.$userid.'&secret='.$login_string;
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