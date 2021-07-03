<?php
    class rickmortydb{
        private $db_host = "localhost";
        private $db_user = "root";
        private $db_pass = "";
        private $db_name = "rickmortydb";
        private $con;
        public function connect(){
			if($connect = mysqli_connect($this->db_host, $this->db_user, $this->db_pass)){
				if(mysqli_select_db($connect, $this->db_name)){
					$this->con = $connect;
					mysqli_query($this->con, "SET NAMES 'utf8'");
					return true;
				}else{
                    throw new Exception("Database selection failed");
				}
			}else{
				throw new Exception("Not connected to the database");
			}
		}
        public function register($email, $password){
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                throw new Exception("Email is not correct");
            }
            if(strlen($password) < 6){
                throw new Exception("Password to short");
            }
            if($this->con){
                $token = $this->generate_hash($email);
                $_pass = $this->generate_hash($password);
                if(mysqli_num_rows(mysqli_query($this->con, "SELECT email FROM users WHERE email = '$email'")) > 0){
                    throw new Exception("Email already in use");
                }
                $query = "INSERT INTO users (email, password, token) VALUES ('$email', '$_pass', '$token')";
                if(mysqli_query($this->con, $query)){
                    $this->login($email, $password);
                    return true;
                }else{
                    throw new Exception("Can't fetch data");
                }
            }else{
                throw new Exception("Not connected to the database");
            }
        }
        public function login($email, $password){
            if($this->con){
                $_pass = $this->generate_hash($password);
                $query = "SELECT token FROM users WHERE email = '$email' AND password = '$_pass'";
                if($row = mysqli_fetch_assoc(mysqli_query($this->con, $query))){
                    setcookie("user", $row['token'], time() + (86400 * 30), "/");
                    return true;
                }else{
                    throw new Exception("Cannot login, wrong data");
                }
            }else{
                throw new Exception("Not connected to the database");
            }
        }
        public function get_user_data_from_token($token){
            if($this->con){
                $query = "SELECT id, email FROM users WHERE token = '$token'";
                if($row = mysqli_fetch_assoc(mysqli_query($this->con, $query))){
                    return $row;
                }else{
                    throw new Exception("Cannot get user data");
                }
            }else{
                throw new Exception("Not connected to the database");
            }
        }
        public function rate_character($token, $character_id, $rate){
            if($this->con){
                if($rate >=1 && $rate <=5 ){
                    $user_id = $this->get_user_data_from_token($token)['id'];
                    if(mysqli_num_rows(mysqli_query($this->con, "SELECT id FROM ratings WHERE character_id = $character_id AND user_id = $user_id")) > 0){
                        $query = "UPDATE ratings SET rate = $rate WHERE character_id = $character_id AND user_id = $user_id";
                    }else{
                        $query = "INSERT INTO ratings (character_id, user_id, rate) VALUES ($character_id, $user_id, $rate)";
                    }
                    if(mysqli_query($this->con, $query)){
                        return true;
                    }else{
                        throw new Exception("The character could not be assessed");
                    }
                }else{
                    throw new Exception("Rate is not between 1 and 5");
                }
            }else{
                throw new Exception("Not connected to the database");
            }
        }
        public function search_character($token, $character_name, $status='all', $gender='all'){
            if($this->con){
                $params = "";
                if($status != 'all') $params .= "&status=$status";
                if($gender != 'all') $params .= "&gender=$gender";
                if(!$json = file_get_contents("https://rickandmortyapi.com/api/character/?name=" . str_replace(" ", "+", $character_name) . $params)){
                    throw new Exception("No data was found");
                }
                $obj = json_decode($json);
                $characters = array();
                foreach($obj->results as $character){
                    $data = array();
                    $data['id'] = $character->id;
                    $data['name'] = $character->name;
                    $data['status'] = $character->status;
                    $data['species'] = $character->species;
                    $data['type'] = $character->type;
                    $data['gender'] = $character->gender;
                    $data['image'] = $character->image;
                    $data['rate'] = $this->get_character_rate($token, $character->id);
                    array_push($characters, $data);
                }
                return $characters;
            }else{
                throw new Exception("Not connected to the database");
            }
        }
        public function get_character_rate($token, $character_id){
            if($this->con){
                $user_id = $this->get_user_data_from_token($token)['id'];
                if($row = mysqli_fetch_assoc(mysqli_query($this->con, "SELECT rate FROM ratings WHERE character_id = $character_id AND user_id = $user_id"))){
                    $rate = $row['rate'];
                }else{
                    $rate = 0;
                }
                return $rate;
            }else{
                throw new Exception("Not connected to the database");
            }
        }
        public function generate_hash($content){
            return sha1($content . "3j98wryhea0sf8y");
        }
	}
?>