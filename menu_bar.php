<!DOCTYPE html>

<?

function page_is($page_name) {
	return (basename($_SERVER['PHP_SELF']) == $page_name);
}

function selected_if_this_page($page_name) {
	if (page_is($page_name)) {
		return "selected";
	}
	return "";
}

?>

<html>


	<div class = "bar">

		<a href="./">
		<span>
			<img class = "item" src="assets/TeemPlay Logo-13.jpg">
		</span>
		</a>
		
		<a href="./profile.html">
		<span id = "username" class = "item">
			<p>User Name</p>
		</span>
		</a>

		<?
		if (!page_is("index.html")) {
		?>

		<a href = "./play.html"
		<span class = "item miniblock <? echo selected_if_this_page("play.html")?>">
			<p>PLAY</p>
		</span>
		</a>

		<a href = "./design.html">
		<span class = "item miniblock <? echo selected_if_this_page("design.html")?>">
			<p>DESIGN</p>
		</span>
		</a>

		<a href = "./imagine.html">
		<span class = "item miniblock <? echo selected_if_this_page("imagine.html")?>">
			<p>IMAGINE</p>
		</span>
		</a>

		<?
		}
		?>

	</div> <!-- highest bar-->

	<?
	if (page_is("imagine.html")) {
	?>

	<div class = "subbar bar">
		<div class = "longblock">
			<p>Imagine Your Game<p>
		</div>
		<div class = "longblock-description">
			<p>
				This is a place where you can put an idea for a game. Words words words more words words words words words words words words words words words words.
			</p> 
		</div>
	</div>

	<?
	}
	?> <!-- middlest bar-->

	<?
	if (!page_is("index.html")) {
	?>

	<div class = "bar bar-lowest lowZ">
	</div>

	<?
	}
	?> <!-- lowest bar-->

</html> 