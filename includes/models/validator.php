<?php

class Validator {

    public static function has_presence($value) {
		return isset($value) && $value !== "";
	}
	
	public static function validate_presences($required_fields) {
		$errors = array();
		foreach($required_fields as $field) {
			$value = trim($_POST[$field]);
			if (!self::has_presence($value)) {
				$errors[$field] = $field . " can't be blank";
			}
		}
		
		return $errors;
	}
	
	public static function has_max_length($value, $max) {
		return strlen($value) <= $max;
	}

	public static function validate_max_lengths($fields_with_max_lengths) {
	    $errors = array();
		// Expects an assoc. array
		foreach($fields_with_max_lengths as $field => $max) {
			$value = trim($_POST[$field]);
		  if (!self::has_max_length($value, $max)) {
			$errors[$field] = $field . " is too long";
		  }
		}
		
		return $errors;
	}
	
	public static function validate_email($email) {
	
	    $emailregexp = "/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/";
	    $result = (preg_match($emailregexp, $email)) ? true : false; 
		return $result;
	}
	
}

?>