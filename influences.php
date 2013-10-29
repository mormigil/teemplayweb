<?php
require_once("orm/influence.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(empty($_SERVER['PATH_INFO'])){
		//user information
		if(!empty($_GET['id'])){
			$influence = influence::findByID($_GET['id']);
			if($influence == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad influence id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($influence->getJSON()));
			exit();
		}
		else if(!empty($_GET['userid'])){
			$influences = influence::findByUser($_GET['userid'], 0);
			$influence_ids = array();
			foreach($influences as $t){
				$influence_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($influence_ids));
			exit();
		}
		else if(empty($_GET['blacklist'])&&!empty($_GET['influences'])&&!empty($_GET['ideaid'])
			&&!empty($_GET['type'])){
			$influences = array();
			//for each influence in the array test and put it in a blacklist array
			for($i=0; $i<=count($_GET['influences'])-1; $i++){
				$id = $_GET['influences'][$i];
				$id = $id['linkedid'];
				$influence = influence::findByID($id);
				if($influence->getType()==$_GET['type']&&$influence->getIdeaID()==$_GET['ideaid']){
					$influences[] = $influence;
				}
			}
			if($influences==null){
				header("HTTP/1.1 400 Bad Request");
				print("No results found for the blacklist");
				exit();
			}
			foreach($influences as $t){
				$influence_ids[] = $t->getJSON();
			}
			header("Content-type:application/json");
			print(json_encode($influence_ids));
			exit();
		}
		else if(empty($_GET['blacklist'])&&!empty($_GET['ideaid'])&&!empty($_GET['type'])){
			$influences = influence::findWinner($_GET['ideaid'], $_GET['type'], 0);
			$influence_ids = array();
			if($influences==null){
				header("HTTP/1.1 400 Bad Request");
				print("No results found for your request");
				exit();
			}
			foreach($influences as $t){
				$influence_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($influence_ids));
			exit();
		}
		//if there is a blacklist passed in
		else if(!empty($_GET['blacklist'])&&!empty($_GET['ideaid'])&&!empty($_GET['type'])){
			//if there is an element in the blacklist
			$influence_ids = array();
			if($_GET['blacklist']!=5){
				$influences = influence::findByVoteIdea($_GET['ideaid'], $_GET['type'], 0, $_GET['blacklist']);
			}
			else{
				$influences = influence::findByVoteIdea($_GET['ideaid'], $_GET['type'], 0, $influence_ids);
			}
			
			if($influences==null){
				header("HTTP/1.1 400 Bad Request");
				print("No results found for your request");
				exit();
			}
			foreach($influences as $t){
				$influence_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($influence_ids));
			exit();
		}
		else{
			header("HTTP/1.1 Bad Request");
			print("Need user id or influence id or idea information");
			exit();
		}
	} else {
		$influence_id = intval(substr($_SERVER['PATH_INFO'], 1));
		$influence = influence::findByID($influence_id);
		if($influence == null){
			header("HTTP/1.1 404 Not Found");
			print("Invalid influence url");
			exit();
		}
		header("Content-type: application/json");
		print(json_encode($influence->getJSON()));
		exit();
	}
} else if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(empty($_SERVER['PATH_INFO'])){
			//if not a valid user
			if(empty($_POST['userid'])){
				header("HTTP/1.1 400 Bad Request");
				print("Valid user must submit");
				exit();
			}
			else if(empty($_POST['ideaid'])){
				header("HTTP/1.1 400 Bad Request");
				print("An influence needs a valid idea to be submitted for");
				exit();
			}
			else if(empty($_POST['type'])){
				header("HTTP/1.1 400 Bad Request");
				print("An influence needs a valid type");
				exit();
			}
			else if(!empty($_POST['title'])&&!empty($_POST['description'])&&!empty($_POST['pics_ref'])){
				$influence = influence::createInfluence(null, $_POST['userid'], $_POST['ideaid'],
					$_POST['title'], $_POST['description'], $_POST['pics_ref'], 0, $_POST['type'], time());
				header("Content-type: application/json");
				print(json_encode($influence->getJSON()));
				exit();
			}
			else{
				header("HTTP/1.1 400 Bad Request");
				print("Missing fields in your influence creation");
				exit();
			}
		}
}