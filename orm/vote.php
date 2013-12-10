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
			$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
			$query = "INSERT INTO vote (id, linkedid, userid, type) VALUES(?,?,?,?)";
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('ssss', $id, $linkedid, $userid, $type);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					if($type==1)
						$query2 = "UPDATE ideas SET votes = ? WHERE id = ?";
					else if ($type == 2)
						$query2 = "UPDATE influence SET votes = ? WHERE id = ?";
					else if ($type == 3)
						$query2 = "UPDATE inspirations SET votes = ? WHERE id = ?";
					vote::updateLinked($mysqli, $linkedid, $query2);
					vote::updateUser($mysqli, $userid);
					return new vote($id, $linkedid, $userid, $type);
				}
				return null;
			}
			catch(mysqli_sql_exceptions $e){
				printf("Errormessage: %s\n", $mysqli->error);
				die("failed to run query");
			}
		}
	return null;	
	}

	private static function updateLinked($mysqli, $linkedid, $query2){
		$query = "SELECT COUNT(*) FROM vote WHERE linkedid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $linkedid);
		$prep->execute();
		$prep->bind_result($count);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count, $linkedid);
			$prep2->execute();
		}
	}

	private static function updateUser($mysqli, $userid){
		$query = "SELECT COUNT(*) FROM vote WHERE userid = ?";
		$query2 = "UPDATE users SET votes = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $userid);
		$prep->execute();
		$prep->bind_result($count);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count, $userid);
			$prep->execute();
		}
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT * FROM vote WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $id);
		$prep->execute();
		$prep->bind_result($id, $linkedid, $userid, $type);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($prep->fetch()){
			if(empty($id)){
				return null;
			}
			return new vote($id, $linkedid, $userid, $type);
		}
		return null;
	}

	public static function findByUser($userid, $type){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM vote WHERE userid = ? AND type = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $userid, $type);
		$prep->execute();
		$prep->bind_result($id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
			//go until there are no more votes for the user
		while($prep->fetch()){
			$votes[] = vote::findByID($id);
		}
		return $votes;
	}

	public static function findByIdea($linkedid, $type){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM vote WHERE linkedid = ? AND type = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $linkedid, $type);
		$prep->execute();
		$prep->bind_result($id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$votes = array();
			//go until there are no more votes for the user
		while($prep->fetch()){
			$votes[] = vote::findByID($id);
		}
		return $votes;
	}

	public static function findByIdeaAndUser($linkedid, $userid, $type){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM vote WHERE linkedid = ? AND userid = ? AND type = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('sss', $linkedid, $userid, $type);
		$prep->execute();
		$prep->bind_result($id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($prep->fetch()){
			if(empty($id)){
				return null;
			}
			$vote = vote::findByID($id);
			//if there were two matches return error!
			if($prep->fetch()){
				return null;
			}
			return $vote;
		}
		return null;
	}


	public function delete(){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
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