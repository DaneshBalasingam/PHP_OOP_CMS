<?php include("includes/header.php"); ?>

<?php
    
	if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}

	$db = new MySql_database();
		
	$deleted = User::delete_user($db, $_GET["id"]);
	
	$db->close_connection(); 
	  
	if (!deleted) {
	    $session->create_message("Failed to delete user." );
		redirect_to("manage_admins.php");
	} 
	else {
	   $session->create_message("User deleted" );
       redirect_to("manage_admins.php");
    }	
	
	
	
?>


