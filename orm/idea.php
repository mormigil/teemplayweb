<?php
class idea{
	private $id;
	private $userid;
	private $title;
	private $tweet;
	private $description;
	private $genre;
	private $votes;
	private $time;

	private function __construct($id, $userid, $title, $tweet, $description, $genre, $votes, $time){
		$this->id = $id;
		$this->userid = $userid;
		$this->title = $title;
		$this->tweet = $tweet;
		$this->description = $description;
		$this->genre = $genre;
		$this->votes = $votes;
		$this->time = $time;
	}

	public static function createIdea($id, $userid, $title, $tweet, $description, $genre, $votes, $time){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "INSERT INTO ideas (id, userid, title, tweet, description, genre, votes, time) VALUES(
			?,?,?,?,?,?,?,?)";
		try{
			$prep = $mysqli->prepare($query);
			$prep->bind_param('ssssssss', $id, $userid, $title, $tweet, $description, $genre, $votes, $time);
			if($prep->execute()){
				$id = $mysqli->insert_id;
				return new Idea($id, $userid, $title, $tweet, $description, $genre, $votes, $time);
			}
			return null;
		}
		catch(PDOException $pdo){
			printf("Errormessage: %s\n", $mysqli->error);
			die("failed to run query");
		}
		
	}

	public static function findExpiring(){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM ideas ORDER BY time";
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$result = $prep->get_result();
		$ideas = array();
		if($result){
			for($i=1;$i<=10;$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$ideas = idea::findByID($next_row[0]);
				}
			}
		}
		return $ideas;
	}

	public static function findRecent(){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM ideas ORDER BY time desc";
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$result = $prep->get_result();
		$ideas = array();
		if($result){
			for($i=1;$i<=10;$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$ideas = idea::findByID($next_row[0]);
				}
			}
		}
		return $ideas;
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT * FROM ideas WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $id);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
		if($result->num_rows == 0){
			return null;
		}
		$idea_info = $result->fetch_array();
		return new Idea($idea_info['id'], $idea_info['userid'], $idea_info['title'], $idea_info['tweet'],
			$idea_info['description'], $idea_info['genre'], $idea_info['votes'], $idea_info['time']);
		}
		return null;
	}

	public function vote(){
		$this->votes = $this->votes + 1;
		return $this->update();
	}

	public function removeVote(){
		$this->votes = $this->votes - 1;
		return $this->update();
	}

	public function chgInfo($title, $tweet, $description, $genre){
		$this->title = empty($title) ? $this->title : $title;
		$this->tweet = empty($tweet) ? $this->tweet : $tweet;
		$this->description = empty($description) ? $this->description : $description;
		$this->genre = empty($genre) ? $this->genre : $genre;
		return $this->update();
	}

	public function update(){
		$mysqli = new mysqli("localhost:3306", "root", "", "nu");
		$query = "UPDATE idea SET userid = ?, title = ?, tweet = ?, description = ?, genre = ?,  
			votes = ?, time = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ssssssss', $this->userid, $this->title, $this->tweet, $this->description, $this->genre, $this->votes, $this->time, $this->id);
		$prep->execute();
		$result = $prep->get_result();
		printf("Errormessage: %s\n", $mysqli->error);
		return $result;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['userid'] = $this->userid;
		$json_rep['title'] = $this->title;
		$json_rep['tweet'] = $this->tweet;
		$json_rep['description'] = $this->description;
		$json_rep['genre'] = $this->genre;
		$json_rep['votes'] = $this->votes;
		$json_rep['time'] = $this->time;
		return $json_rep;
	}
}
?>