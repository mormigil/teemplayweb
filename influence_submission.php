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
       <?php
        include "header.php";
        ?>
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