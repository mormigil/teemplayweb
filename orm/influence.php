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
		(?,?,?,?,?,?,?,?,?)";
		$prep = $mysqli->prepare($query);
		$prep->bind_param("sssssssss", $id, $userid, $ideaid, $title, $description, $pics_ref, $votes, $type, $time);
		if($prep->execute()){
			$id = $mysqli->insert_id;
			return new influence($id, $userid, $ideaid, $title, $description, $pics_ref, $votes, $type, $time);
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
		return new Influence($influence_info['id'], $influence_info['userid'], $influence_info['ideaid'], $influence_info['title'],
			$influence_info['description'], $influence_info['pics_ref'], $influence_info['votes'], $influence_info['type'], $influence_info['time']);
		}
		return null;
	}

	public static function findByRecentIdea($ideaid, $type, $start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM influence WHERE ideaid = ? AND type = ? ORDER BY time desc";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $ideaid, $type);
		$prep->execute();
		$result = $prep->get_result();
		$influences = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$influences[] = influence::findByID($next_row[0]);
				}
			}
		}
		return $influences;
	}


	/*I need a voted black list so that ideas you've already voted for don't reappear
	on the voting function. I guess this means votes have finality however (hard to
	change your vote). The idea is that you generate a random number between the results
	and then if that number is blacklisted try the next number until you find an empty one
	if there are no empty numbers it won't run because the blacklist is the size of the
	results array.*/
	public static function findByVoteIdea($ideaid, $type, $start, $votedBlackList){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM influence WHERE ideaid = ? AND type = ? ORDER BY votes desc";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $ideaid, $type);
		$prep->execute();
		$result = $prep->get_result();
		$influences = $result->num_rows;
		$ideas = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$choice = rand(1, 100);
				$choice = ceil(($choice*$choice/10000)*($influences));
				/*print($choice);
				print($votedBlackList[0]);
				while(in_array($choice, $votedBlackList)){\
					if($influences==count($votedBlackList)){
						break;
					}
					if($choice<$influences){
						$choice++;
					}
					else{
						$choice = 0;
					}
				}*/
				$result->data_seek($choice-1);
				$row = $result->fetch_row();
				if($row){
					$id = $row[0];
					while(in_array($id, $votedBlackList)){
						if($influences == count($votedBlackList)){
							return $ideas;
						}
						$upchoice = $choice++;
						if($choice<$influences){
							$choice++;
						}
						else{
							$choice = 0;
						}
						$result->data_seek($choice-1);
						$row = $result->fetch_row();
						if($row){
							$id = $row[0];
						}
					}
					$ideas[] = influence::findByID($row[0]);
					$votedBlackList[] = $row[0];
				}
			}
		}
		return $ideas;
	}

	public static function findByUser($userid, $start){
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