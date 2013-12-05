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
		try{
			$pdo = new PDO("mysql:host=localhost;dbname=teemplay_web", "root", "");
			$query = "SELECT id FROM users WHERE name = :name";
			$prep = $pdo->prepare($query);
			$params = array(':name' => $name);
			$prep->execute($params);
			$id = $prep->fetch(PDO::FETCH_ASSOC);
			if($id){
				$user = User::findByID($id['id']);
				return $user;
			}
			return null;
		}
		catch(PDOException $err){
			printf("Errormessage: %s\n", $err);
			die("failed to run query");
		}
		/*$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web")
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
		return null;*/
	}

	//create new user
	public static function createUser($id, $username, $password, $level, $description, $votes, $email){
		$mysqli = new mysqli("localhost", "teemplay_morm", "x1Zh8T1VbhX7", "teemplay_web")
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
		try{
			$pdo = new PDO("mysql:host=localhost;dbname=teemplay_web", "root", "");
			$query = "SELECT * FROM users WHERE id = :id";
			$prep = $pdo->prepare($query);
			$params = array(":id" => $id);
			$prep->execute($params);
			$user_info = $prep->fetch(PDO::FETCH_ASSOC);
			if($user_info){
				return new User($user_info['id'], $user_info['name'], $user_info['pass'], $user_info['level'],
			$user_info['description'], $user_info['votes'], $user_info['email']);
			}
			return null;

		}
		catch(PDOException $err){
			printf("Errormessage: %s\n", $err);
			die("failed to run query");
		}
			$result = $prep->get_result();

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
		try{
			$pdo = new PDO("mysql:host=localhost;dbname=teemplay_web", "root", "");
			$query = "UPDATE users SET username = :user, password = :pass, level = :level, 
			description = :descr, votes = :votes, email = :email WHERE id = :id";
			$prep = $pdo->prepare($query);
			$params = (":user" => $this->username, ":pass" => $this->password, 
				":level" => $this->level, ":descr" => $this->description, 
				":votes" => $this->votes, ":email" => $this->email, ":id" => $this->id);
			
			$prep->execute();
			$result = $prep->get_result();
			if($result){
				if
			}
		}
		catch(PDOException $err){
			printf("Errormessage: %s\n", $err);
			die("failed to run query");
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