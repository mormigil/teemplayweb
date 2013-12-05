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
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "SELECT id FROM users WHERE name = ?";
		$prep = $mysqli->prepare($query);
		$prep->bind_param('s', $name);
		$prep->execute();
		$result = $prep->get_result();
		if($result){
			if($result->num_rows == 0){
				return null;
			}
			$id = $result->fetch_row();
			$user = User::findByID($id[0]);
			return $user;
		}
		return null;
	}

	//create new user
	public static function createUser($id, $username, $password, $level, $description, $votes, $email){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "INSERT INTO users (id, name, pass, level, description, votes, email) VALUES(
			?,?,?,?,?,?,?)";
		try{
			$prep = $mysqli->prepare($query);
			$prep->bind_param('sssssss', $id, $username, $password, $level, $description, $votes, $email);
			if($prep->execute()){
				$id = $mysqli->insert_id;
				return new User($id, $username, $password, $level, $description, $votes, $email);
			}
			return null;
		}
		catch($mysqli->error){
			printf("Errormessage: %s\n", $mysqli->error);
			die("failed to run query");
		}
		
	}

	//given an id return the user
	//useful as a call to return the correct user from other functions
	public static function findByID($id){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web")
		or die ("I cannot connect to the database.");
		$query = "SELECT * FROM users WHERE id = ?";
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
		$user_info = $result->fetch_array();
		return new User($user_info['id'], $user_info['name'], $user_info['pass'], $user_info['level'],
			$user_info['description'], $user_info['votes'], $user_info['email']);
		}
		return null;
	}

	//general update for whatever fields were input
	public function update(){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web")
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