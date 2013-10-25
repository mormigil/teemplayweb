<?php
require_once("vote.php");
class vote_influence extends vote{
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
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "INSERT INTO vote_influence (id, influenceid, userid) VALUES(?,?,?)";
		$query1 = "SELECT COUNT(*) FROM vote_influence WHERE influenceid = ?";
		$query2 = "UPDATE influence SET votes = ? WHERE id = ?";
		$query3 = "SELECT COUNT(*) FROM vote_influence WHERE userid = ?";
		$query4 = "UPDATE users SET votes_influence = ? WHERE id = ?";
		$query5 = "SELECT id FROM vote_influence WHERE influenceid = ? AND userid = ?";
		parent::createVote($id, $influenceid, $userid, $mysqli, $query, $query1, $query2,
			$query3, $query4, $query5);
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT * FROM vote_influence WHERE id = ?";
		parent::findByID($id, $mysqli, $query);
	}

	public static function findByUser($userid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote_influence WHERE userid = ?";
		parent::findByUser($userid, $mysqli, $query);
	}

	public static function findByInfluence($influenceid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote_influence WHERE influenceid = ?";
		parent::findByLinked($influenceid, $mysqli, $query);
	}

	public static function findByInfluenceAndUser($influenceid, $userid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM vote_influence WHERE influenceid = ? AND userid = ?";
		parent::findByLinkedAndUser($influenceid, $userid, $mysqli, $query);
	}


	public function delete(){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "DELETE FROM vote_influence WHERE id = ?";
		parent::delete($mysqli, $query);
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