<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(is_null($_SERVER['PATH_INFO'])){
			if(!is_null($_GET['name'])){
				$mysqli = new mysqli("mydb5address", "username", "password", "database");
				$result = $mysqli->query("SELECT * FROM tbl_ideas WHERE idea_id = ".$_GET['name']);
			}		
		}
	}
?>