<?php
require("loggedin.php");
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = stylesheet href = "http://localhost/teemplayweb/style.css" type = "text/css">
	<link rel = stylesheet href = "http://localhost/teemplayweb/style_viewing.css" type = "text/css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://localhost/teemplayweb/js/load_ideas.js"></script>
	<script src="http://localhost/teemplayweb/js/user_info.js"></script>
</head>
<body>
	<div id = "wrapper">
		<?php
		include "header.php";
		?>
		<div id = "submissions">
			<button id = "change">Change</button>
		</div>
		<div id = "ideas">
		</div><!--#ideas-->
	</div><!--#wrapper-->
</body>
</html>