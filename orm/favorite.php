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
			$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
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
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		if($result){
			$count = $result->fetch_array();
			$prep2 = $mysqli->prepare($query2);
			$prep2->bind_param('ss', $count[0], $inspirationid);
			$prep2->execute();
		}
	}

	private static function updateUser($mysqli, $userid){
		$query = "SELECT COUNT(*) FROM favorite WHERE userid = ?";
		$query2 = "UPDATE users SET favorites = ? WHERE id = ?";
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
		$query = "SELECT * FROM favorite WHERE id = ?";
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
		$favorite_info = $result->fetch_array();
		return new favorite($favorite_info['id'], $favorite_info['inspirationid'], $favorite_info['userid']);
		}
		return null;
	}

	public static function findByUser($userid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM favorite WHERE userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $userid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$favorites = array();
		if($result){
			//go until there are no more favorites for the user
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$favorites[] = favorite::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $favorites;
	}

	public static function findByInspirations($inspirationid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM favorite WHERE inspirationid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $inspirationid);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		$favorites = array();
		if($result){
			//go until there are no more favorites for the inspirations
			while(true){
				$next_row = $result->fetch_row();
				if($next_row){
					$favorites[] = favorite::findByID($next_row[0]);
				}
				else{
					break;
				}
			}
		}
		return $favorites;
	}

	public static function findByInspirationsAndUser($inspirationid, $userid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM favorite WHERE inspirationid = ? AND userid = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ss', $inspirationid, $userid);
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
			$favorite = favorite::findByID($id[0]);
			return $favorite;
		}
		return null;
	}


	public function delete(){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "DELETE FROM favorite WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $this->id);
		$prep->execute();
		$result = $prep->get_result();
		return $result;
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