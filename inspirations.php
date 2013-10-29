<?php
require_once("orm/inspiration.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(empty($_SERVER['PATH_INFO'])){
		//find a specific inspiration
		if(!empty($_GET['id'])){
			$inspiration = inspiration::findByID($_GET['id']);
			if($inspiration == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad inspiration id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($inspiration->getJSON()));
			exit();
		}

		//find all inspirations from a user
		if(!empty($_GET['userid'])){

			exit();
		}
		if(isset($_GET['popular'])){
			$inspirations = inspiration::findPopular(0);
			$inspiration_ids = array();
			foreach($inspirations as $t){
				$inspiration_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($inspiration_ids));
			exit();
		}
		//if recent delimiter is set then display most recently submitted inspirations
		if(isset($_GET['old'])){
			$inspirations = inspiration::findOld(0);
			$inspiration_ids = array();
			foreach($inspirations as $t){
				$inspiration_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($inspiration_ids));
			exit();
		}

		//if no search delimiters are set then display inspirations closest to expiring
		$inspirations = inspiration::findNew(0);
		$inspiration_ids = array();
		foreach($inspirations as $t){
			$inspiration_ids[] = $t->getJSON();
		}
		header("Content-type: application/json");
		print(json_encode($inspiration_ids));
		#display expiring code
		exit();

	} else {
		$inspiration_id = intval(substr($_SERVER['PATH_INFO'], 1));
		$inspiration = inspiration::findByID($inspiration_id);
		if($inspiration==null){
			header("HTTP/1.1 404 Not Found");
			print("Invalid inspiration url");
			exit();
		}
		header("Content-type: application/json");
		print(json_encode($inspiration->getJSON()));
		exit();

	}
} else if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(empty($_SERVER['PATH_INFO'])){
		if(empty($_POST['userid'])){
			header("HTTP/1.1 400 Bad Request");
			print("Valid user must submit");
			exit();
		}

		//no fields were changed
		if(empty($_POST['title'])&&empty($_POST['tweet'])&&empty($_POST['description'])){
			header("HTTP/1.1 400 Bad Request");
			print("You must change at least one field");
			exit();
		}
		
		//If no id we are submitting a new inspiration
		if(empty($_POST['id'])){
			if(!empty($_POST['title'])&&!empty($_POST['tweet'])&&!empty($_POST['description'])){
				$url = (empty($_POST['url'])) ? "" : $_POST['url'];
				$pic = (empty($_POST['pic'])) ? "" : $_POST['pic'];
				$vid = (empty($_POST['vid'])) ? "" : $_POST['vid'];
				$inspiration = inspiration::createInspiration(NULL, $_POST['userid'], 
					$_POST['title'], $_POST['tweet'],$_POST['description'], $url,
					'0', time(), $pic, $vid);
				header("Content-type: application/json");
				print(json_encode($inspiration->getJSON()));
				exit();
			}
			else{
				header("HTTP/1.1 400 Bad Request");
				print("All fields must be completed");
				exit();
			}
		}

		//if there is an id we are updating an existing inspiration
		else{
			$inspiration = inspiration::findByID($_POST['id']);
			if($inspiration == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad inspiration id");
				exit();
			}
			if($_POST['userid']!=$inspiration->getUser()){
				header("HTTP/1.1 403 Forbidden");
				print("Must be same user who submitted to edit");
				exit();
			}
			$title = (empty($_POST['title'])) ? NULL : $_POST['title'];
			$tweet = (empty($_POST['tweet'])) ? NULL : $_POST['tweet'];
			$description = (empty($_POST['description'])) ? NULL : $_POST['description'];
			$genre = (empty($_POST['genre'])) ? NULL : $_POST['genre'];
			$inspiration->chgInfo($title, $tweet, $description, $genre);
			header("Content-type: application/json");
			print(json_encode($inspiration->getJSON()));
		}

	} else {
		$inspiration_id = intval(substr($_SERVER['PATH_INFO'], 1));
		$inspiration = inspiration::findByID($inspiration_id);
		if($inspiration==null){
			header("HTTP/1.1 404 Not Found");
			print("Invalid inspiration url");
			exit();
		}
		$title = (empty($_POST['title'])) ? NULL : $_POST['title'];
		$tweet = (empty($_POST['tweet'])) ? NULL : $_POST['tweet'];
		$description = (empty($_POST['description'])) ? NULL : $_POST['description'];
		$genre = (empty($_POST['genre'])) ? NULL : $_POST['genre'];
		$inspiration->chgInfo($title, $tweet, $description, $genre);
		header("Content-type: application/json");
		print(json_encode($inspiration->getJSON()));
	}
}
?>