<?php
require("loggedin.php");
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = stylesheet href = "style.css" type = "text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src = "js/submit.js"></script>
    <script src="http://localhost/teemplayweb/js/user_info.js"></script>
</head>
<body>
	<div id = "wrapper">
       <?php
        include "header.php";
        ?>
		<div id = "main">
				Title:<br>
    <input type="text" id="title" value="">
    <br><br>
    Tweet:<br>
    <input type="text" id="tweet" value="">
    <br><br>
    Description:<br>
    <textarea rows = "8" cols = "30" id = "description">Describe your game here</textarea>
    <br><br>
    Link:<br>
    <input type="text" id="url" value="">
    <br><br>Picture:<br>
    <input type = "text" id = "pic" value = "">
    <br><br>Video:<br>
    <input type = "text" id = "vid" value = "">
    <br><br>
    <input type="submit" id = "inspiration" value="Imagine">
		</div><!--main-->
	</div><!--wrapper-->
</body>
</html>