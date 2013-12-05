<?php
class vote_influence{
	private $id;
	private $influenceid;
	private $userid;


	private function __construct($id, $influenceid, $userid){
		$this->id = $id;
		$this->influenceid = $influenceid;
		$this->userid = $userid;

	}

	/*doing a no no here and adding a side effect to creating a vote_influence. This will also serve as
	the place where the user's vote_influences and the influence's vote_influences are updated.*/
	public static function createvote_influence($id, $influenceid, $userid){
		$vote_influence = vote_influence::findByInfluenceAndUser($influenceid, $userid);
		if(empty($vote_influence)){
			$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
			$query = "INSERT INTO vote_influence (id, influenceid, userid) VALUES(?,?,?)";
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('sss', $id, $influenceid, $userid);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					vote_influence::updateInfluence($mysqli, $influenceid);
					vote_influence::updateUser($mysqli, $userid);
					return new vote_influence($id, $influenceid, $userid);
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

	private static function updateInfluence($mysqli, $influenceid){
		$query = "SELECT COUNT(*) FROM vote_influence WHERE influenceid = ?";
		$query2 = "UPDATE influence SET votes = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $influenceid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			$count = $result->fetch_array();
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count[0], $influenceid);
			$prep2->execute();
		}
	}

	private static function updateUser($mysqli, $userid){
		$query = "SELECT COUNT(*) FROM vote_influence WHERE userid = ?";
		$query2 = "UPDATE users SET votes_influence = ? WHERE id = ?";
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
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT * FROM vote_influence WHERE id = ?";
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
		$vote_influence_info = $result->fetch_array();
		return new vote_influence($vote_influence_info['id'], $vote_influence_info['influenceid'], $vote_influence_info['userid']);
		}
		return null;
	}

	public static function findByUser($userid){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM vote_influence WHERE userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $userid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$vote_influences = array();
		if($result){
			//go until there are no more vote_influences for the user
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$vote_influences[] = vote_influence::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $vote_influences;
	}

	public static function findByInfluence($influenceid){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM vote_influence WHERE influenceid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $influenceid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$vote_influences = array();
		if($result){
			//go until there are no more vote_influences for the influence
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$vote_influences[] = vote_influence::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $vote_influences;
	}

	public static function findByInfluenceAndUser($influenceid, $userid){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM vote_influence WHERE influenceid = ? AND userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $influenceid, $userid);
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
			$vote_influence = vote_influence::findByID($id[0]);
			return $vote_influence;
		}
		return null;
	}


	public function delete(){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "DELETE FROM vote_influence WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $this->id);
		$prep->execute();
		$result = $prep->get_result();
		return $result;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['influenceid'] = $this->influenceid;
		$json_rep['userid'] = $this->userid;
		return $json_rep;
	}
}
?>