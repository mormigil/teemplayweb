<?php
require_once("orm/favorite.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){
	if(empty($_SERVER['PATH_INFO'])){
		//find a specific favorite
		if(!empty($_GET['id'])&&!empty($_GET['delete'])){
			$favorite = favorite::findByID($_GET['id']);
			$favorite->delete();
			header("Content-type: application/json");
			print(json_encode(true));
			exit();
		} else if (!empty($_GET['id'])){
			$favorite = favorite::findByID($_GET['id']);
			if($favorite == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad favorite id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($favorite->getJSON()));
			exit();
		}
		//find all favorites cast from a user
		//favorites will need some kind of expiration mechanic so that this query is 
		//limited to no more than roughly
		//300 favorites
		if(!empty($_GET['userid'])&&!empty($_GET['type'])&&empty($_GET['influenceid'])){
			$favorites = favorite::findByUser($_GET['userid']);
			$favorite_ids = array();
			foreach($favorites as $t){
				$favorite_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($favorite_ids));
			exit();
		}
		//find all favorites from an influence
		else if(!empty($_GET['influenceid'])&&!empty($_GET['type'])&&empty($_GET['userid'])){
			$favorites = favorite::findByInfluence($_GET['influenceid']);
			$favorite_ids = array();
			foreach($favorites as $t){
				$favorite_ids[] = $t->getJSON();
			}
			header("Content-type: application/json");
			print(json_encode($influence_ids));
			exit();
		}
		//find the favorite of userid on influenceid
		else if(!empty($_GET['influenceid'])&&!empty($_GET['type'])){
			$favorite = favorite::findByInfluenceAndUser($_GET['influenceid'], $_GET['userid']);
			if($favorite == null){
				header("HTTP/1.1 400 Bad Request");
				print("bad user or influence id");
				exit();
			}
			header("Content-type: application/json");
			print(json_encode($favorite->getJSON()));
			exit();
		}
		else if(empty($_GET['type'])){
			header("HTTP/1.1 400 Bad Request");
			print("Need a type");
			exit();
		}
		else{
			header("HTTP/1.1 400 Bad Request");
			print("Need a type and some form of id");
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
		if(empty($_POST['influenceid'])){
			header("HTTP/1.1 400 Bad Request");
			print("favorite must be cast on valid influence");
			exit();
		}
		if(empty($_POST['type'])){
			header("HTTP/1.1 400 Bad Request");
			print("favorite must have a type");
			exit();
		}
		$favorite = favorite::createfavorite(NULL, $_POST['influenceid'], $_POST['userid']);
		if($favorite){
			header("Content-type: application/json");
			print(json_encode($favorite->getJSON()));
			exit();
		}
		header("HTTP/1.1 400 Bad Request");
		print("You can only favorite on influences once");
		exit();
	} else {

	}
}
?>