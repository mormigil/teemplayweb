<?php
require_once("orm/vote.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(empty($_SERVER['PATH_INFO'])){
		//find a specific vote
		if(!empty($_GET['id'])&&!empty($_GET['delete'])){
			$vote = vote::findByID($_GET['id']);
			$vote->delete();
			header("Content-type: application/json");
			print(json_encode(true));
			exit();
		} else if (!empty($_GET['id'])){
			$vote = vote::findByID($_GET['id']);
			if($vote == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad vote id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($vote->getJSON()));
			exit();
		}
		//find all votes cast from a user
		//votes will need some kind of expiration mechanic so that this query is limited to no more than roughly
		//300 votes
		if(!empty($_GET['userid'])&&empty($_GET['ideaid'])){
			$votes = vote::findByUser($_GET['userid'], 0);
			$vote_ids = array();
			foreach($votes as $t){
				$vote_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($vote_ids));
			exit();
		}
		//find all votes from an idea
		else if(!empty($_GET['ideaid'])&&empty($_GET['userid'])){
			$votes = vote::findByIdea($_GET['ideaid'], 0);
			$vote_ids = array();
			foreach($votes as $t){
				$vote_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($idea_ids));
			exit();
		}
		//find the vote of userid on ideaid
		else if(!empty($_GET['ideaid'])){
			$vote = vote::findByIdeaAndUser($_GET['ideaid'], $_GET['userid']);
			if($vote == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad user or idea id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($vote->getJSON()));
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
			print("Vote must be cast on valid idea");
			exit();
		}
		$vote = vote::createVote(NULL, $_POST['ideaid'], $_POST['userid']);
		if($vote){
			header("Content-type: application/json");
			print(json_encode($vote->getJSON()));
			exit();
		}
		header("HTTP/1.1 400 Bad Request");
		print("You can only vote on ideas once");
		exit();
	} else {

	}
}
?>