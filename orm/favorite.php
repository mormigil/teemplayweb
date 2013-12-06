<?php
class favorite{
	private $id;
	private $inspirationid;
	private $userid;


	private function __construct($id, $inspirationid, $userid){
		$this->id = $id;
		$this->inspirationid = $inspirationid;
		$this->userid = $userid;

	}

	/*doing a no no here and adding a side effect to creating a favorite. This will also serve as
	the place where the user's favorites and the inspirations's favorites are updated.*/
	public static function createFavorite($id, $inspirationid, $userid){
		$favorite = favorite::findByInspirationsAndUser($inspirationid, $userid);
		if(empty($favorite)){
			$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
			$query = "INSERT INTO favorite (id, inspirationid, userid) VALUES(?,?,?)";
			try{
				$prep = $mysqli->prepare($query);
				$prep->bind_param('sss', $id, $inspirationid, $userid);
				if($prep->execute()){
					$id = $mysqli->insert_id;
					favorite::updateInspirations($mysqli, $inspirationid);
					favorite::updateUser($mysqli, $userid);
					return new favorite($id, $inspirationid, $userid, $type);
				}
				return null;
			}
			catch($mysqli->error){
				printf("Errormessage: %s\n", $mysqli->error);
				die("failed to run query");
			}
		}
	return null;	
	}

	private static function updateInspirations($mysqli, $inspirationid){
		$query = "SELECT COUNT(*) FROM favorite WHERE inspirationid = ?";
		$query2 = "UPDATE inspirations SET favorites = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $inspirationid);
		$prep->execute();
		$prep->bind_result($count);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count, $inspirationid);
			$prep2->execute();
		}
	}

	private static function updateUser($mysqli, $userid){
		$query = "SELECT COUNT(*) FROM favorite WHERE userid = ?";
		$query2 = "UPDATE users SET favorites = ? WHERE id = ?";
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
			$prep2->execute();
		}
	}

	public static function findByID($id){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT * FROM favorite WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $id);
		$prep->execute();
		$prep->bind_result($id, $inspirationid, $userid);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			if(empty($id)){
				return null;	
			}
			return new favorite($id, $inspirationid, $userid);
		}
		return null;
	}

	public static function findByUser($userid){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM favorite WHERE userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $userid);
		$prep->execute();
		$prep->bind_result($id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$favorites = array();
		while($prep->fetch()){
			//go until there are no more favorites for the user
			while(true){
				if($id){
					$favorites[] = favorite::findByID($id);
				}
				else{
					break;
				}
			}
		}
		return $favorites;
	}

	public static function findByInspirations($inspirationid){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM favorite WHERE inspirationid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $inspirationid);
		$prep->execute();
		$prep->bind_result($id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$favorites = array();
		while($prep->fetch()){
			//go until there are no more favorites for the inspirations
			while(true){
				if($id){
					$favorites[] = favorite::findByID($id);
				}
				else{
					break;
				}
			}
		}
		return $favorites;
	}

	public static function findByInspirationsAndUser($inspirationid, $userid){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT id FROM favorite WHERE inspirationid = ? AND userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $inspirationid, $userid);
		$prep->execute();
		$prep->bind_result($id);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			if(empty($id)){
				return null;
			}
			$favorite = favorite::findByID($id);
			return $favorite;
		}
		return null;
	}


	public function delete(){
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "DELETE FROM favorite WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $this->id);
		return $prep->execute();;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['inspirationid'] = $this->inspirationid;
		$json_rep['userid'] = $this->userid;
		return $json_rep;
	}
}
?>