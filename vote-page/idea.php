<?php
class idea{
	private $id;
	private $votes;

	private function __construct($id, $votes){
		$this->id = $id;
		$this->votes = $votes;
	}

	public static function findAll(){
		$mysqli = new mysqli("localhost", "root", "", "tbl_ideas");
		$result = $mysqli->query("SELECT * FROM tbl_ideas");
		$ideas = array();
		if($result){
		if($result->num_rows == 0){
			return null;
		}
		for($i=1;$i<=9;$i++){
			$idea_info = $result->fetch_array();
			if($idea_info){
				$ideas[] = idea::findByID($idea_info[0]);
			}
		}
		}
		return $ideas;
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost", "root", "", "tbl_ideas");
		$result = $mysqli->query("SELECT * FROM tbl_ideas WHERE id = ".$id);
		if($result){
		if($result->num_rows == 0){
			return null;
		}
		$idea_info = $result->fetch_array();
		return new idea(intval($idea_info['id']), intval($idea_info['votes']));
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

	public function update(){
		$mysqli = new mysqli("localhost", "root", "", "tbl_ideas");
		$user_id = $_SERVER['REMOTE_ADDR'];
                $time = time();
		$result2 = $mysqli->query("INSERT INTO tbl_records (id, user, vote, timestamp) VALUES (NULL, '$user_id', '$this->id', '$time')");
		$result = $mysqli->query("UPDATE tbl_ideas SET votes = ". $this->votes ." WHERE id = ". $this->id);
		return $result;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['votes'] = $this->votes;
		return $json_rep;
	}
}
?>