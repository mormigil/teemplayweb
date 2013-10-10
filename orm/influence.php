<?php
class influence{
	private $id;
	private $userid;
	private $ideaid;
	private $title;
	private $description;
	private $pics_ref;
	private $votes;
	private $type;
	private $time;

	private function __construct($id, $userid, $ideaid, $title, $description, $pics_ref, $votes, $type, $time){
		$this->id = $id;
		$this->userid = $userid;
		$this->ideaid = $ideaid;
		$this->title = $title;
		$this->description = $description;
		$this->pics_ref = $pics_ref;
		$this->votes = $votes;
		$this->type = $type;
		$this->time = $time;
	}

	public static function createInfluence($id, $userid, $ideaid, $title, $description, $pics_ref, $votes, $type, $time){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "INSERT INTO influence (id, userid, ideaid, title, description, pics_ref, votes, type, time) VALUES 
		(?,?,?,?,?,?,?,?, ?)";
		$prep = $mysqli->prepare($query);
		$prep->bind_param("ssssssss", $id, $userid, $ideaid, $title, $description, $pics_ref, $votes, $type, $time);
		if($prep->execute()){
			$id = $mysqli->insert_id;
			return new Influence($id, $userid, $ideaid, $title, $description, $pics_ref, $votes, $type, $time);
		}
		printf("Errormessage: %s\n", $mysqli->error);
		return null;
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT * FROM influence WHERE id = ?";
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
		$influence_info = $result->fetch_array();
		return new Influence($influence_info['id'], $influence_info['name'], $influence_info['pass'], $influence_info['level'],
			$influence_info['description'], $influence_info['votes'], $influence_info['email'], $influence_info['time']);
		}
		return null;
	}

	public static function findByRecentIdea($ideaid, $type, $start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM influence WHERE ideaid = ? AND type = ? ORDER BY time desc";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s,s', $ideaid, $type);
		$prep->execute();
		$result = $prep->get_result();
		$ideas = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$ideas[] = influence::findByID($next_row[0]);
				}
			}
		}
	}

	public static function findByVoteIdea($ideaid, $type, $start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM influence WHERE ideaid = ? AND type = ? ORDER BY time desc";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s,s', $ideaid, $type);
		$prep->execute();
		$result = $prep->get_result();
		$influences = $result->num_rows();
		$ideas = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				double $choice = rand(1, $influences);
				$choice = ceil((($choice/$influences)^2)*$choice)-1;
				$result->data_seek($choice);
				$row = $result->fetch_row();
				if($row){
					$ideas[] = influence::findByID($row[0]);
				}
			}
		}
	}

	public static function findByUser($userid){
		$query = "SELECT id FROM influence WHERE userid = ? AND type = ? ORDER BY time desc";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s,s', $ideaid, $type);
		$prep->execute();
		$result = $prep->get_result();
		$ideas = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$ideas[] = influence::findByID($next_row[0]);
				}
			}
		}
	}

	public function update(){
		$mysqli = new mysqli("localhost:3306", "root", "", "nu");
		$query = "UPDATE influence SET userid = ?, ideaid = ?, title = ?, description = ?, pics_ref = ?,  
			votes = ?, type = ?, time = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('sssssssss', $this->userid, $this->ideaid, $this->title, $this->description, 
			$this->pics_ref, $this->votes, $this->type, $this->time, $this->id);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		return $result;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['userid'] = $this->userid;
		$json_rep['ideaid'] = $this->ideaid;
		$json_rep['title'] = $this->title;
		$json_rep['description'] = $this->description;
		$json_rep['pics_ref'] = $this->pics_ref;
		$json_rep['votes'] = $this->votes;
		$json_rep['type'] = $this->type;
		$json_rep['time'] = $this->time;
		return $json_rep;
	}

}
?>