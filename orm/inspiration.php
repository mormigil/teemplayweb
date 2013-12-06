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

	private function upload($file){
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		$target = "C:/wamp/www/teemplay_web/uploads/";
		$filehash = md5_file($file['tmp_name']);
		$name = $filehash . basename($file['name']);
		$target = $target . $name;
		if(move_uploaded_file($file['tmp_name'], $target))
		/*{
			echo "The file ". $target."has been uploaded,
			and your information has been added to the directory";
		}
		else{
			echo "Sorry, there was a problem uploading your file.";
		}*/
		return $name;
	}

	public static function createInspiration($id, $userid, $title, $tweet, $description, $url,
		$votes, $time, $pic, $vid){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		if($pic){
			$pic = inspiration::upload($pic);
		}
		$query = "INSERT INTO inspirations (id, userid, title, tweet, description, url, votes,
			time, pic, vid) VALUES(?,?,?,?,?,?,?,?,?,?)";
		$prep = $mysqli->prepare($query);
		if($mysqli->error){
			print($mysqli->error);
		}
		$prep->bind_param("ssssssssss", $id, $userid, $title, $tweet, $description, $url,
			$votes, $time, $pic, $vid);
		if($prep->execute()){
			$id = $mysqli->insert_id;
			return new Inspiration($id, $userid, $title, $tweet, $description, $url,
				$votes, $time, $pic, $vid);
		}
		return null;
	}

	public static function findByID($id){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
		$query = "SELECT * FROM inspirations WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $id);
		$prep->execute();
		$prep->bind_result($id, $userid, $title, $tweet, $description, $url, $votes, $time, $pic, $vid);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			return new Inspiration($id, $userid, $title, $tweet, $description, $url, $votes, $time, $pic, $vid);
		}
		return null;
	}

	public static function findOld($start){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
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
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
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
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
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
		$mysqli = new myslqi("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web");
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