<?php
require_once("idea.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
		/*if(!is_null($_GET['id'])){
			$ideas = idea::findByID($_GET['id']);
			if(is_null($ideas)){
				header("HTTP/1.1 400 Bad Request");
				print("Error in id");
				exit();
			}
			$games_ids = $ideas->getJSON();
			header("Content-type: application/json");
			print(json_encode($games_ids));
			exit();
		}
		else{*/
			$ideas = idea::findAll();
			if(is_null($ideas)){
				header("HTTP/1.1 400 Bad Request");
				print("Error in request");
				exit();
			}
			$idea_ids = array();
			foreach($ideas as $t){
				$idea_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($idea_ids));
			exit();
		//}
}
else if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(!is_null($_POST['id'])){
			$idea = idea::findByID($_POST['id']);
			if(is_null($idea)){
				header("HTTP/1.1 400 Bad Request");
				print("Bad ID that doesn't exist");
				exit();
			}
			$idea->vote();
			setcookie('onevote', $_POST['id'], strtotime('tomorrow 06:00'), '/');
			header("Content-type: application/json");
			print(json_encode($idea->getJSON()));
			exit();
		}
		else{
			header("HTTP/1.1 400 Bad Request");
			print("error in id");
			exit();
		}
}
?>