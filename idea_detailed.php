<?php
require("loggedin.php");
?>
<!DOCTYPE html>
<html lang = 'en'>
<head>
	<meta charset = "utf-8">
	<title>Submit your new game idea</title>
	<link rel = "stylesheet" href = "http://localhost/teemplayweb/style.css" type = "text/css">
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="http://localhost/teemplayweb/js/idea_specifics.js"></script>
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
		</div>
		<div id = "tabs">
			 <ul>
				<li><span id = "1"><a href="#idea_misc">Idea</a></span></li>
				<li><span id = "2"><a href="#story">Story</a></span></li>
				<li><span id = "3"><a href="#character">Character Design</a></span></li>
				<li><span id = "4"><a href="#art">Art Style</a></span></li>
				<li><span id = "5"><a href="#mechanics">Core Mechanics</a></span></li>
				<li><span id = "6"><a href="#levels">Level Design</a></span></li>
				<li><span id = "7"><a href="#price">Price</a></p></li>
				<li><span id = "8"><a href="#distribution">Distribution</a></span></li>
			</ul>
			<div id ="idea_info"></div>
			<div id = "idea_misc">Stuff in here?</div>
			<div id = "story">Throw some stuff in the story</div>
			<div id = "character">And here?</div>
			<div id = "art">Lots of stuff here</div>
			<div id = "mechanics">make them all have something weird</div>
			<div id = "levels">Maybe will make it work</div>
			<div id = "price">Price needs some love</div>
			<div id = "distribution">And lets not forget distribution</div>
			<div id = "comments"></div>
			<div id = "supporters"></div>
		</div><!--#tabs-->
	</div><!--#wrapper-->
</body>
</html>