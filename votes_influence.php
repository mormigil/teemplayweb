<?php
require_once("orm/vote_influence.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(empty($_SERVER['PATH_INFO'])){
		//find a specific vote_influence
		if(!empty($_GET['id'])&&!empty($_GET['delete'])){
			$vote_influence = vote_influence::findByID($_GET['id']);
			$vote_influence->delete();
			header("Content-type: application/json");
			print(json_encode(true));
			exit();
		} else if (!empty($_GET['id'])){
			$vote_influence = vote_influence::findByID($_GET['id']);
			if($vote_influence == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad vote_influence id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($vote_influence->getJSON()));
			exit();
		}
		//find all vote_influences cast from a user
		//vote_influences will need some kind of expiration mechanic so that this query is limited to no more than roughly
		//300 vote_influences
		if(!empty($_GET['userid'])&&empty($_GET['ideaid'])){
			$vote_influences = vote_influence::findByUser($_GET['userid'], 0);
			$vote_influence_ids = array();
			foreach($vote_influences as $t){
				$vote_influence_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($vote_influence_ids));
			exit();
		}
		//find all vote_influences from an idea
		else if(!empty($_GET['ideaid'])&&empty($_GET['userid'])){
			$vote_influences = vote_influence::findByIdea($_GET['ideaid'], 0);
			$vote_influence_ids = array();
			foreach($vote_influences as $t){
				$vote_influence_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($idea_ids));
			exit();
		}
		//find the vote_influence of userid on ideaid
		else if(!empty($_GET['ideaid'])){
			$vote_influence = vote_influence::findByIdeaAndUser($_GET['ideaid'], $_GET['userid']);
			if($vote_influence == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad user or idea id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($vote_influence->getJSON()));
			exit();
		}

	} else {

	}
} else if($_SERVER['REQUEST_METHOD'] = 'POST'){
	if(empty($_SERVER['PATH_INFO'])){
		if(empty($_POST['userid'])){
			header("HTTP/1.1 400 Bad Request");
			print("Valid user must submit");
			exit();
		}
		if(empty($_POST['ideaid'])){
			header("HTTP/1.1 400 Bad Request");
			print("vote_influence must be cast on valid idea");
			exit();
		}
		$vote_influence = vote_influence::createvote_influence(NULL, $_POST['ideaid'], $_POST['userid']);
		if($vote_influence){
			header("Content-type: application/json");
			print(json_encode($vote_influence->getJSON()));
			exit();
		}
		header("HTTP/1.1 400 Bad Request");
		print("You can only vote on influences once");
		exit();
	} else {

	}
}
?>