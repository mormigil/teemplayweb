<?php
require("loggedin.php");
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = "stylesheet" href = "http://localhost/teemplayweb/style_detailed.css" type = "text/css">
	<link rel = "stylesheet" href = "http://localhost/teemplayweb/style.css" type = "text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="http://localhost/teemplayweb/js/project_specifics.js"></script>
	<script src="http://localhost/teemplayweb/js/user_info.js"></script>
</head>
<body>
	<div id = "wrapper">
		<?php
		include "header.php";
		?>
		<div id = "tabs">
			 <ul>
				<li><span id = "1"><a href="#idea_misc">Idea</a></span></li>
				<li><span id = "2"><a href="#story">Story</a></span></li>
				<li><span id = "3"><a href="#character">Character Design</a></span></li>
				<li><span id = "4"><a href="#art">Art Style</a></span></li>
				<li><span id = "5"><a href="#mechanics">Core Mechanics</a></span></li>
				<li><span id = "6"><a href="#levels">Level Design</a></span></li>
				<li><span id = "7"><a href="#price" class = "inactive">Price</a></span></li>
				<li><span id = "8"><a href="#distribution">Distribution</a></span></li>
			</ul>
			<div id ="idea_info"></div>
			<div id = "idea_misc"></div>
			<div id = "story"></div>
			<div id = "character"></div>
			<div id = "art"></div>
			<div id = "mechanics"></div>
			<div id = "levels"></div>
			<div id = "price"></div>
			<div id = "distribution"></div>
			<div id = "comments"></div>
			<div id = "supporters"></div>
		</div><!--#tabs-->
	</div><!--#wrapper-->
</body>
</html>