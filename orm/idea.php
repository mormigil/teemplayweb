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
	private $stage;

	private function __construct($id, $userid, $title, $tweet, $description, $genre, $votes, $time, $stage){
		$this->id = $id;
		$this->userid = $userid;
		$this->title = $title;
		$this->tweet = $tweet;
		$this->description = $description;
		$this->genre = $genre;
		$this->votes = $votes;
		$this->time = $time;
		$this->stage = $stage;
	}

	public static function createIdea($id, $userid, $title, $tweet, $description, $genre, $votes, $time, $stage){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "INSERT INTO ideas (id, userid, title, tweet, description, genre, votes, time, stage) VALUES(
			?,?,?,?,?,?,?,?,?)";
		try{
			$prep = $mysqli->prepare($query);
			$prep->bind_param('sssssssss', $id, $userid, $title, $tweet, $description, $genre, $votes, $time, $stage);
			if($prep->execute()){
				$id = $mysqli->insert_id;
				return new Idea($id, $userid, $title, $tweet, $description, $genre, $votes, $time, $stage);
			}
			return null;
		}
		catch(PDOException $pdo){
			printf("Errormessage: %s\n", $mysqli->error);
			die("failed to run query");
		}
		
	}

	public static function findExpiring($start, $current){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		if($current){
			$query = "SELECT id FROM ideas WHERE stage != 0 ORDER BY time";
		}
		else{
			$query = "SELECT id FROM ideas WHERE stage = 0 ORDER BY time";
		}
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$prep->bind_result($id);
		$ideas = array();
		for($i=$start;$i<($start+10)&&$prep->fetch();$i++){
			if($id){
				$idea = idea::findByID($id);
				if($idea->getTimeLeft($idea->getStage())>0){
					$ideas[] = $idea;
				}
				else{
					$idea->chgStage();
				}
			}
		}
		return $ideas;
	}

	public static function findRecent($start, $current){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		if($current){
			$query = "SELECT id FROM ideas WHERE stage != 0 ORDER BY time desc";
		}
		else{
			$query = "SELECT id FROM ideas WHERE stage = 0 ORDER BY time desc";
		}
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$prep->bind_result($id);
		$ideas = array();
		for($i=$start;$i<($start+10)&&$prep->fetch();$i++){
			if($id){
				$idea = idea::findByID($id);
				if($idea->getTimeLeft($idea->getStage())>0){
					$ideas[] = $idea;
				}
				else{
					$idea->chgStage();
				}
			}
		}
		return $ideas;
	}

	public static function findByID($id){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT * FROM ideas WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $id);
		$prep->execute();
		$prep->bind_result($id, $userid, $title, $tweet, $description, $genre, $votes, $time, $stage);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			return new Idea($id, $userid, $title, $tweet, $description, $genre, $votes, $time, $stage);
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

	public function chgStage(){
		$newStage = (($this->time+30*24*60*60)+($stage*15*24*60*60))-time();

		$firstTime = (($this->time+30*24*60*60))-time();
		if($firstTime<0){
			$stage = -floor($newStage/(15*24*60*60));
			if($stage>8){
				$stage = 8;
			}
		}
		else{$stage = 0;}
		$this->stage = $stage;
		$this->update();
	}


	//update broken needs to be checked
	public function update(){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "UPDATE ideas SET userid = ?, title = ?, tweet = ?, description = ?, genre = ?,  
			votes = ?, time = ?, stage = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('sssssssss', $this->userid, $this->title, $this->tweet, $this->description, 
			$this->genre, $this->votes, $this->time, $this->stage, $this->id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		return $prep->execute();
	}

	public function getTitle(){
		return $this->title;
	}

	public function getUser(){
		return $this->userid;
	}

	public function getTweet(){
		return $this->tweet;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getGenre(){
		return $this->genre;
	}

	public function getVotes(){
		return $this->votes;
	}

	public function getTime(){
		return $this->time;
	}

	public function getTimeLeft($stage){
		return ($this->time+30*24*60*60)+($stage*15*24*60*60)-time();
	}

	public function getStage(){
		return $this->stage;
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
		$json_rep['stage'] = $this->stage;
		$json_rep['timeleft'] = $this->getTimeLeft($this->stage);
		return $json_rep;
	}
}
?>