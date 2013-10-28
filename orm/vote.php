<?php
class vote{
	private $id;
	private $linkedid;
	private $userid;
	private $type;


	private function __construct($id, $linkedid, $userid, $type){
		$this->id = $id;
		$this->linkedid = $linkedid;
		$this->userid = $userid;
		$this->type = $type;

	}

	/*doing a no no here and adding a side effect to creating a vote. This will also serve as
	the place where the user's votes and the idea's votes are updated.*/
	public static function createVote($id, $linkedid, $userid, $type){
		$vote = vote::findByIdeaAndUser($linkedid, $userid, $type);
		if(empty($vote)){
			$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
			$query = "INSERT INTO vote (id, linkedid, userid, type) VALUES(?,?,?,?)";
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('ssss', $id, $linkedid, $userid, $type);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					vote::updateIdea($mysqli, $linkedid);
					vote::updateUser($mysqli, $userid);
					return new vote($id, $linkedid, $userid, $type);
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

	private static function updateIdea($mysqli, $linkedid){
		$query = "SELECT COUNT(*) FROM vote WHERE linkedid = ?";
		$query2 = "UPDATE ideas SET votes = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $linkedid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			$count = $result->fetch_array();
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count[0], $linkedid);
			$prep2->execute();
		}
	}

	private static function updateUser($mysqli, $userid){
		$query = "SELECT COUNT(*) FROM vote WHERE userid = ?";
		$query2 = "UPDATE users SET votes = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $userid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			$count = $result->fetch_array();
			$prep = $mysqli->prepare($query2);
			$prep->bind_param('ss', $count[0], $userid);
			$prep->execute();
		}
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
		return new vote($vote_info['id'], $vote_info['linkedid'], $vote_info['userid'], 
			$vote_info['type']);
		}
		return null;
	}

	public static function findByUser($userid, $type){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote WHERE userid = ? AND type = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $userid, $type);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
		if($result){
			//go until there are no more votes for the user
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$votes[] = vote::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $votes;
	}

	public static function findByIdea($linkedid, $type){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote WHERE linkedid = ? AND type = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $linkedid, $type);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
		if($result){
			//go until there are no more votes for the idea
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$votes[] = vote::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $votes;
	}

	public static function findByIdeaAndUser($linkedid, $userid, $type){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote WHERE linkedid = ? AND userid = ? AND type = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('sss', $linkedid, $userid, $type);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			if($result->num_rows == 0){
				return null;
			}
			$id = $result->fetch_row();
			$vote = vote::findByID($id[0]);
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
		$json_rep['linkedid'] = $this->linkedid;
		$json_rep['userid'] = $this->userid;
		$json_rep['type'] = $this->type;
		return $json_rep;
	}
}
?>