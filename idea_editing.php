<?php
require("loggedin.php");
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = stylesheet href = "register.css" type = "text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src = "submit.js"></script>
</head>
<body>
	<div id = "wrapper">
	<div id = "main">Title:<br>
    <input type="text" id="title" value="">
    <br><br>
    Tweet:<br>
    <input type="text" id="tweet" value="">
    <br><br>
    description:<br>
    <textarea rows = "8" cols = "60" id = "description">Describe your game here</textarea>
    <br><br>
    <input type="text" id="genre" value="">
    <br><br>
    <input type="submit" id = "changeidea" value="Imagine"> 
		</div><!--main-->
	</div><!--wrapper-->
</body>
</html>