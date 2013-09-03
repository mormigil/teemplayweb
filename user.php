<?php
class idea{
	//relevant variables
	private $id;
	private $username;
	private $password;
	private $level;
	private $description;
	private $votes;
	private $salt;
	private $email;

	//construct new user with all fields
	private function __construct($id, $username, $password, $level, $description, $votes, $salt, $email){
		$this->id = $id;
		$this->username = $username;
		$this->password = $password;
		$this->level = $level;
		$this->description = $description;
		$this->votes = $votes;
		$this->salt = $salt;
		$this->email = $email;
	}

	//create new user
	public static function createUser($id, $username, $password, $level, $description, $votes, $salt, $email){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "INSERT INTO users (id, name, pass, level, description, votes, salt, email) VALUES(
			:id,
			:username,
			:password,
			:level,
			:description,
			:votes,
			:salt,
			:email
			)";
	$query_params = array(':id' => $id, ':username' => $username, ':password' => $password, ':level' => $level, 
		':description' => $description, ':votes' => $votes, ':salt' => $salt, ':email' => $email);
		$prep = $mysqli->prepare($query);
		$result = $prep->execute($query_params);
		printf("Errormessage: %s\n", $mysqli->error);
		return $result;
	}

	//given an id return the user
	//useful as a call to return the correct user from other functions
	public static function findByID($id){
		$mysqli = new mysqli("localhost:3306", "root", "", "teemplayweb");
		$query = "SELECT * FROM users WHERE id = :id";
		$query_params = array(':id'=>$id);
		$prep = $mysqli->prepare($query);
		$result = $prep->execute($query_params);
		printf("Errormessage: %s\n", $mysqli->error);
		if($result){
		if($result->num_rows == 0){
			return null;
		}
		$idea_info = $result->fetch_array();
		return new idea(intval($idea_info['id']), intval($idea_info['votes']));
		}
		return null;
	}

	//general update for whatever fields were input
	public function update(){
		$mysqli = new mysqli("localhost:3306", "root", "", "nu");
		$query = "UPDATE users SET username = :username, password = :password, level = :level, description = :description, votes = :votes WHERE id = :id";
		$query_params = array(':id' => $id, ':username' => $username, ':password' => $password, ':level' => $level, 
		':description' => $description, ':votes' => $votes, ':salt' => $salt, ':email' => $email);
		$prep = $mysqli->prepare($query);
		$result = $prep->execute($query_params);
		printf("Errormessage: %s\n", $mysqli->error);
		return $result;
	}

	public function getJSON(){
		$json_rep = array();
		$json_rep['id'] = $this->id;
		$json_rep['username'] = $this->username;
		$json_rep['password'] = $this->password;
		$json_rep['level'] = $this->level;
		$json_rep['description'] = $this->description;
		$json_rep['votes'] = $this->votes;
		$json_rep['salt'] = $this->salt;
		$json_rep['email'] = $this->email;
		return $json_rep;
	}
}
?>