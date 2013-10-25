<?php
class vote_idea{
	private $id;
	private $ideaid;
	private $userid;


	private function __construct($id, $ideaid, $userid){
		$this->id = $id;
		$this->ideaid = $ideaid;
		$this->userid = $userid;

	}

	/*doing a no no here and adding a side effect to creating a vote. This will also serve as
	the place where the user's votes and the idea's votes are updated.*/
	public static function createVote($id, $ideaid, $userid){
		$vote = vote_idea::findByIdeaAndUser($ideaid, $userid);
		if(empty($vote)){
			$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
			$query = "INSERT INTO vote (id, ideaid, userid) VALUES(?,?,?)";
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('sss', $id, $ideaid, $userid);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					vote_idea::updateIdea($mysqli, $ideaid);
					vote_idea::updateUser($mysqli, $userid);
					return new vote_idea($id, $ideaid, $userid);
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

	private static function updateIdea($mysqli, $ideaid){
		$query = "SELECT COUNT(*) FROM vote WHERE ideaid = ?";
		$query2 = "UPDATE ideas SET votes = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $ideaid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			$count = $result->fetch_array();
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count[0], $ideaid);
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
		return new vote_idea($vote_info['id'], $vote_info['ideaid'], $vote_info['userid']);
		}
		return null;
	}

	public static function findByUser($userid){
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
			//go until there are no more votes for the user
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$votes[] = vote_idea::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $votes;
	}

	public static function findByIdea($ideaid){
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
			//go until there are no more votes for the idea
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$votes[] = vote_idea::findByID($next_row[0]);
				}
				else{
					break;
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
			if($result->num_rows == 0){
				return null;
			}
			$id = $result->fetch_row();
			$vote = vote_idea::findByID($id[0]);
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