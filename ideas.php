<?php
require_once("orm/idea.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(empty($_SERVER['PATH_INFO'])){
		if(!empty($_GET['id'])){
			$idea = idea::findByID($_GET['id']);
			if($idea == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad idea id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($idea->getJSON()));
			exit();
		}
		//find all ideas from a user
		if(!empty($_GET['userid'])){

			exit();
		}
		//find all ideas of a genre
		if(!empty($_GET['genre'])){

			exit();
		}

		//if recent delimiter is set then display most recently submitted ideas
		if(isset($_get['recent'])){
			$ideas = idea::findRecent();
			$idea_ids = array();
			foreach($ideas as $t){
				$idea_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($idea_ids));
			exit();
		}

		//if no search delimiters are set then display ideas closest to expiring
		$ideas = idea::findExpiring();
		$idea_ids = array();
		foreach($ideas as $t){
			$idea_ids[] = $t->getJSON();
		}
		header("Content-type: application/json");
		print(json_encode($idea_ids));
		#display expiring code
		exit();

	} else {

	}
} else if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_SERVER['PATH_INFO'])){
		if(empty($_POST['userid'])){
			header("HTTP/1.1 400 Bad Request");
			print("Valid user must submit");
			exit();
		}

		//no fields were changed
		if(empty($_POST['title'])&&empty($_POST['tweet'])&&empty($_POST['description'])&&empty($_POST['genre'])){
			header("HTTP/1.1 400 Bad Request");
			print("You must change at least one field");
			exit();
		}
		
		//If no id we are submitting a new idea
		if(empty($_POST['id'])){
			if(!empty($_POST['title'])&&!empty($_POST['tweet'])&&!empty($_POST['description'])&&!empty($_POST['genre'])){
				$idea = idea::createIdea(NULL, $_POST['userid'], $_POST['title'], $_POST['tweet'],
					$_POST['description'], $_POST['genre'], '0', time());
				header("Content-type: application/json");
				print(json_encode($idea->getJSON()));
				exit();
			}
			else{
				header("HTTP/1.1 400 Bad Request");
				print("All fields must be completed");
				exit();
			}
		}

		//if there is an id we are updating an existing an idea
		else{
			$idea = idea::findByID($_POST['id']);
			if($idea == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad idea id");
				exit();
			}
			$title = (empty($_POST['title'])) ? NULL : $_POST['title'];
			$tweet = (empty($_POST['tweet'])) ? NULL : $_POST['tweet'];
			$description = (empty($_POST['description'])) ? NULL : $_POST['description'];
			$genre = (empty($_POST['genre'])) ? NULL : $_POST['genre'];
			$idea->chgInfo($title, $tweet, $description, $genre);
			header("Content-type: application/json");
			print(json_encode($idea->getJSON()));
		}

	} else {
		$idea_id = intval(substr($_SERVER['PATH_INFO'], 1));
		$idea = idea::findByID($idea_id);
		if($idea==null){
			header("HTTP/1.1 404 Not Found");
			print("Invalid idea url");
			exit();
		}
		$title = (empty($_POST['title'])) ? NULL : $_POST['title'];
		$tweet = (empty($_POST['tweet'])) ? NULL : $_POST['tweet'];
		$description = (empty($_POST['description'])) ? NULL : $_POST['description'];
		$genre = (empty($_POST['genre'])) ? NULL : $_POST['genre'];
		$idea->chgInfo($title, $tweet, $description, $genre);
		header("Content-type: application/json");
		print(json_encode($idea->getJSON()));
	}
}
?>