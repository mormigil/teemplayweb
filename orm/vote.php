<?php
abstract class vote{
	private $id;
	private $linkedid;
	private $userid;
	private $mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");


	private function __construct($id, $linkedid, $userid){
		$this->id = $id;
		$this->linkedid = $linkedid;
		$this->userid = $userid;

	}

	/*doing a no no here and adding a side effect to creating a vote. This will also serve as
	the place where the user's votes and the linked's votes are updated.*/
	public static function createVote($id, $linkedid, $userid, $mysqli, $query, $query1,
		$query2, $query3, $query4){
		$vote = vote::findByLinkedAndUser($linkedid, $userid, $mysqli, $query5);
		if(empty($vote)){
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('sss', $id, $linkedid, $userid);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					vote::updatelinked($mysqli, $linkedid, $query1, $query2);
					vote::updateUser($mysqli, $userid, $query3, $query4);
					return new vote($id, $linkedid, $userid);
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

	private static function updateLinked($mysqli, $linkedid, $query1, $query2){
		$prep = $mysqli->prepare($query1);
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

	private static function updateUser($mysqli, $userid, $query1, $query2){
		$prep = $mysqli->prepare($query1);
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

	public static function findByID($id, $mysqli, $query){
		
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
		return new vote($vote_info['id'], $vote_info['linkedid'], $vote_info['userid']);
		}
		return null;
	}

	public static function findByUser($userid, $mysqli, $query){
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
					$votes[] = vote::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $votes;
	}

	public static function findByLinked($linkedid, $mysqli, $query){
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $linkedid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
		if($result){
			//go until there are no more votes for the linked
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

	public static function findByLinkedAndUser($linkedid, $userid, $mysqli, $query){
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $linkedid, $userid);
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


	public function delete($mysqli, $query){
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
		return $json_rep;
	}
}
?>