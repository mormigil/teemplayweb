<?php
class inspiration{
	private $id;
	private $userid;
	private $title;
	private $tweet;
	private $description;
	private $url;
	private $votes;
	private $time;
	private $pic;
	private $vid;

	private function __construct($id, $userid, $title, $tweet, $description, $url,
		$votes, $time, $pic, $vid){
		$this->id = $id;
		$this->userid = $userid;
		$this->title = $title;
		$this->tweet = $tweet;
		$this->description = $description;
		$this->url = $url;
		$this->votes = $votes;
		$this->pic = $pic;
		$this->vid = $vid;
	}

	public static function createInspiration($id, $userid, $title, $tweet, $description, $url,
		$votes, $time, $pic, $vid){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "INSERT INTO inspirations (id, userid, title, tweet, description, url, votes,
			time, pic, vid) VALUES (?,?,?,?,?,?,?,?,?,?)";
		$prep = $mysqli->prepare($query);
		$prep->bind_param("sssssssssss", $id, $userid, $title, $tweet, $description, $url,
			$votes, $time, $pic, $vid);
		if($prep->execute()){
			$id = $mysqli->insert_id;
			return new Inspiration($id, $userid, $title, $tweet, $description, $url,
				$votes, $time, $pic, $vid);
		}
		return null;
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT * FROM inspirations WHERE id = ?";
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
		$inspiration_info = $result->fetch_array();
		return new Inspiration($inspiration_info['id'], $inspiration_info['userid'], 
			$inspiration_info['title'], $inspiration_info['tweet'],	$inspiration_info['description'],
			$inspiration_info['url'], $inspiration_info['votes'], $inspiration_info['time'], 
			$inspiration_info['pic'], $inspiration_info['vid']);
		}
		return null;
	}

	public static function findOld($start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM inspirations ORDER BY time";
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$result = $prep->get_result();
		$inspirations = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$inspirations[] = inspiration::findByID($next_row[0]);
				}
			}
		}
		return $inspirations;
	}

	public static function findNew($start){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM inspirations ORDER BY time desc";
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$result = $prep->get_result();
		$inspirations = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$inspirations[] = inspiration::findByID($next_row[0]);
				}
			}
		}
		return $inspirations;
	}

	public static function findPopular($start){
		$mysqli = new myslqi("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT id FROM inspirations ORDER BY votes";
		$prep = $mysqli->prepare($query);
		$prep->execute();
		$result = $prep->get_result();
		$inspirations = array();
		if($result){
			for($i=$start;$i<($start+10);$i++){
				$next_row = $result->fetch_row();
				if($next_row){
					$inspirations[] = inspiration::findByID($next_row[0]);
				}
			}
		}
		return $inspirations;
	}

	public function vote(){
		$this->votes = $this->votes + 1;
		return $this->update();
	}

	public function removeVote(){
		$this->votes = $this->votes - 1;
		return $this->update();
	}

	public function update(){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "UPDATE inspirations SET userid = ?, title = ?, tweet = ?, description = ?, 
			url = ?, votes = ?, time = ?, pic = ?, vid = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('ssssssssss', $this->userid, $this->title, $this->tweet, $this->description, 
			$this->url, $this->votes, $this->time, $this->pic, $this->vid, $this->id);
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
		$json_rep['title'] = $this->title;
		$json_rep['tweet'] = $this->tweet;
		$json_rep['description'] = $this->description;
		$json_rep['url'] = $this->url;
		$json_rep['votes'] = $this->votes;
		$json_rep['time'] = $this->time;
		$json_rep['pic'] = $this->pic;
		$json_rep['vid'] = $this->vid;
		return $json_rep;
	}
}
?>