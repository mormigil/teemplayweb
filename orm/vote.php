<?php
class vote{
	private $id;
	private $ideaid;
	private $userid;


	private function __construct($id, $ideaid, $userid){
		$this->id = $id;
		$this->ideaid = $ideaid;
		$this->userid = $userid;

	}

	public static function createVote($id, $ideaid, $userid){
		$vote = vote::findByIdeaAndUser($ideaid, $userid);
		if(empty($vote)){
			$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
			$query = "INSERT INTO vote (id, ideaid, userid) VALUES(?,?,?)";
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('sss', $id, $ideaid, $userid);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					return new vote($id, $ideaid, $userid);
				}
				return null;
			}
			catch(PDOException $pdo){
				printf("Errormessage: %s\n", $mysqli->error);
				die("failed to run query");
			}
		}
	return null;
		
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT * FROM vote WHERE id = ?";
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
		$vote_info = $result->fetch_array();
		return new vote($vote_info['id'], $vote_info['ideaid'], $vote_info['userid']);
		}
		return null;
	}

	public static function findByUser($userid, $start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote WHERE userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $userid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
		if($result){
			for($i=$start; $i<($start+20);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$votes[] = vote::findByID($next_row[0]);
				}
			}
		}
		return $votes;
	}

	public static function findByIdea($ideaid, $start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote WHERE ideaid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $ideaid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
		if($result){
			for($i=$start; $i<($start+20);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$votes[] = vote::findByID($next_row[0]);
				}
			}
		}
		return $votes;
	}

	public static function findByIdeaAndUser($ideaid, $userid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote WHERE ideaid = ? AND userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $ideaid, $userid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			if($result->num_rows != 1){
				return null;
			}
			$id = $result->fetch_row();
			$vote = vote::findByID($id);
			return $vote;
		}
		return null;
	}


	public function delete(){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "DELETE FROM vote WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $this->id);
		$prep->execute();
		$result = $prep->get_result();
		return $result;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['ideaid'] = $this->ideaid;
		$json_rep['userid'] = $this->userid;
		return $json_rep;
	}
}
?>