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
	<script src="http://localhost/teemplayweb/js/inspiration_specifics.js"></script>
	<script src="http://localhost/teemplayweb/js/user_info.js"></script>
</head>
<body>
	<div id = "wrapper">
		<?php
		include "header.php";
		?>
		<div id = "main">
			<div id = "image_content">
			</div>
			<div id = "text_description">
			</div>
			<div id = "author_info">
			</div>
			<div id = "actions">
				<button id = "bookmark">Bookmark</button>
				<button id = "connect">Add To Project</button>
			</div>
		</div>
		
	</div><!--#wrapper-->
</body>
</html>