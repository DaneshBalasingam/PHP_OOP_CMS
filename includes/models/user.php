<?php
class User {
	
	protected $data = array();
	
	public function __construct($id) {
		$this->user_id = $id;
	}
	
	public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return false;
        }
    }
	
	public static function authenticate_admin($username, $password) {
	    $db = new MySql_database();
		
	    $user = self::get_user_by_username($db, $username);
		
		$db->close_connection();
		
		if($user) {
		
			if ( $user->user_type == "admin" ) {	
				$hash = crypt($password, $user->hashed_password);
				if ($hash === $user->hashed_password) {
				   return true;
				} else {
				   return false;
				}
			}
		}
		else {
		    return false;
		}
	}
	
	public static function authenticate_user($db,$username, $password) {
		
	    $user = self::get_user_by_username($db, $username);
		
		if($user) {
		
			if ( $user->user_type == "user" ) {	
				$hash = crypt($password, $user->hashed_password);
				if ($hash === $user->hashed_password) {
				   return true;
				} else {
				   return false;
				}
			}
		}
		else {
		    return false;
		}
	}
	
	public static function password_encrypt($password) {
		$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
		$salt_length = 22; 					// Blowfish salts should be 22-characters or more
		$salt = self::generate_salt($salt_length);
		$format_and_salt = $hash_format . $salt;
		$hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	public static function generate_salt($length) {
	    // Not 100% unique, not 100% random, but good enough for a salt
	    // MD5 returns 32 characters
	    $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	    $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	    $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	    $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	public static function create_user($db, $username, $password, $email, $user_type) {
		
		if (self::check_unique_user($db,$username)) {
			$clean_username = $db->escape_value($username);
			$hashed_password = self::password_encrypt($password);
			$clean_email = $db->escape_value($email);
			
			$sql  = "INSERT INTO users (";
			$sql .= "  username, hashed_password, email, user_type ";
			$sql .= ") VALUES (";
			$sql .= " '{$clean_username}', '{$hashed_password}', '{$clean_email}', '{$user_type}' ";
			$sql .= ")";
			
			@ $db->query($sql);
			
			$new_id = $db->confirm_insert();
			
			return $new_id;
		}
		
		else {
		    $new_id = false;
			return $new_id;
		}
	    
	}
	
	public static function update_user($db, $password, $email, $id) {

			$hashed_password = self::password_encrypt($password);
			$clean_email = $db->escape_value($email);
			
			$sql  = "UPDATE users SET ";
			$sql .= "hashed_password = '{$hashed_password}', ";
			$sql .= "email = '{$clean_email}' ";
			$sql .= "WHERE user_id = {$id} ";
			
			@ $db->query($sql);
			
			if ($db->affected_rows()) {
			    return true;
			}
			else {
			    return false;
			}

	    
	}
	
	public static function delete_user($db, $id) {
	
	    $sql = "DELETE FROM users WHERE user_id = {$id} LIMIT 1";
		
		@ $db->query($sql);
		
		if ($db->affected_rows()) {
			    return true;
			}
			else {
			    return false;
			}
	}
	
	public static function check_unique_user($db, $username) {
	    $current_admins = self::find_all_admins($db);
		
		while($admin = $db->fetch_assoc_array($current_admins)) {
		    if ($admin["username"] == $username) {
			    return false;
			}
		}
		
		return true;
	    
	}
	
	
	
	public static function find_all_admins($db) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "Where user_type = 'admin' ";
		$sql .= "ORDER BY username ASC";
		$admin_set = $db->query($sql);
		
		return $admin_set;
	}
	
	public static function find_user_by_id ($db, $id) {
	    $sql  = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "Where user_id = {$id} ";
		$sql .= "LIMIT 1 ";
		
		$user = $db->query($sql);
	    
		return $user;
	
	}
	
	public static function get_user($db, $id) {
	
	    $sql  = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "Where user_id = {$id} ";
		$sql .= "LIMIT 1 ";
		
		try {
		
			$result = $db->query($sql);
		
			if (!$result) {
			    throw new database_exception ( 	"Database query failed: " );
			} else {
				// Create and return user object using the database result
				return $result->fetch_object('User', array($id));
				
			}
		}
		
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}

	}
	
		public static function get_user_by_username($db, $username) {
	
	    $sql  = "SELECT * ";
		$sql .= "FROM users ";
		$sql .= "Where username = '{$username}' ";
		$sql .= "LIMIT 1 ";
		
		try {
		
			$result = $db->query($sql);
		
			if (!$result) {
			    throw new database_exception ( 	"Database query failed: " );
			} else {
				// Create and return user object using the database result
				return $result->fetch_object('User', array($username));
				
			}
		}
		
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}

	}

}



?> 