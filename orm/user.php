<?php
class user{
	//relevant variables
	private $id;
	private $username;
	private $password;
	private $level;
	private $description;
	private $votes;
	private $email;

	//construct new user with all fields
	private function __construct($id, $username, $password, $level, $description, $votes, $email){
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->level = $level;
		$this->description = $description;
		$this->votes = $votes;
		$this->email = $email;
	}

	public static function findByName($name){
		$mysqli = new mysqli("localhost", "root", "", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "SELECT id FROM users WHERE name = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $name);
		$prep->execute();
		$prep->bind_result($id);
		while($prep->fetch()){
			$user = User::findByID($id);
			return $user;
		}
		return null;
	}

	//create new user
	public static function createUser($id, $username, $password, $level, $description, $votes, $email){
		$mysqli = new mysqli("localhost", "root", "", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "INSERT INTO users (id, name, pass, level, description, votes, email) VALUES(
			?,?,?,?,?,?,?)";
			$prep = $mysqli->prepare($query);
			$prep->bind_param('sssssss', $id, $username, $password, $level, $description, $votes, $email);
			if($prep->execute()){
				$id = $mysqli->insert_id;
				return new User($id, $username, $password, $level, $description, $votes, $email);
			}
			return null;
		
	}

	//given an id return the user
	//useful as a call to return the correct user from other functions
	public static function findByID($id){
		$variables = array();
		$data = array();
		$mysqli = new mysqli("localhost", "mormigil", "", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "SELECT * FROM users WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $id);
		$prep->execute();
		$prep->bind_result($id, $name, $pass, $level, $descr, $votes, $email);
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		while($prep->fetch()){
			return new User($id, $name, $pass, $level, $descr, $votes, $email);
		}
		return null;
	}

	//general update for whatever fields were input
	public function update(){
		$mysqli = new mysqli("localhost", "root", "", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "UPDATE users SET username = ?, password = ?, level = ?, description = ?, votes = ?, email = ? WHERE id = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('sssssss', $this->username, $this->password, $this->level, $this->description, $this->votes, $this->email, $this->id);
		$prep->execute();
		$result = $prep->get_result();
		if($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
		}
		return $result;
	}

	//read

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['username'] = $this->username;
		$json_rep['password'] = $this->password;
		$json_rep['level'] = $this->level;
		$json_rep['description'] = $this->description;
		$json_rep['votes'] = $this->votes;
		$json_rep['email'] = $this->email;
		return $json_rep;
	}

	public function getID(){
		return ($this->id);
	}

	public function getPass(){
		return ($this->password);
	}

}
?>