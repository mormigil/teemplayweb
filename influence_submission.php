<?php
require("loggedin.php");
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = stylesheet href = "http://localhost/teemplayweb/style.css" type = "text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src = "http://localhost/teemplayweb/js/submit.js"></script>
    <script src="http://localhost/teemplayweb/js/user_info.js"></script>
</head>
<body>
	<div id = "wrapper">
        <div id = "header">
            <a href = "#"><img id = "logoimg" src = "http://localhost/teemplayweb/transparlogo.png" alt = "logo"></img></a>
            <ul id = "nav-menu">
                <a href = "idea_viewing.php"><li>Imagine</li></a>
                <a href = "idea_detailed.php"><li>Design</li></a>
                <li>Play</li>
            </ul>
            <div id = "userinfo"></div>
        </div><!--header-->
		<div id = "main">
				Title:<br>
    <input type="text" id="title" value="">
    <br><br>
    Pictures:<br>
    <input type="text" id="pics_ref" value="">
    <br><br>
    description:<br>
    <textarea rows = "8" cols = "60" id = "description">Give a description of your addition here</textarea>
    <br><br>
    <input type="submit" id = "influenceidea" value="Imagine"> 
		</div><!--main-->
	</div><!--wrapper-->
</body>
</html>