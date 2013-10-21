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
        <div id = "header">
            <a href = "#"><img id = "logoimg" src = "http://localhost/teemplayweb/transparlogo.png" alt = "logo"></img></a>
            <ul id = "nav-menu">
                <a href = "idea_viewing.php"><li>Imagine</li></a>
                <a href = "project_viewing.php"><li>Design</li></a>
                <li>Play</li>
            </ul>
            <div id = "userinfo"></div>
        </div><!--header-->
		<div id = "main">
				Title:<br>
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
    <input type="submit" id = "gameidea" value="Imagine"> 
		</div><!--main-->
	</div><!--wrapper-->
</body>
</html>