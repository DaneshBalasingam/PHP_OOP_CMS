<?php

class Session {
	
	function __construct() {
		session_start();
  
	}
	
	function admin_logged_in($username) {
	    $_SESSION["admin_user"] = $username;
	}
	
	function user_logged_in($username) {
	    $_SESSION["user"] = $username;
	}
	
	function admin_log_out() {
	    $_SESSION["admin_user"] = null;		
	}
	
	function user_log_out() {
	    $_SESSION["user"] = null;		
	}
	
	function create_message($message) {
	    $_SESSION["message"] = $message;
	}
	
	function delete_message() {
	    $_SESSION["message"] = null;
	}
 
}

$session = new Session();



?>