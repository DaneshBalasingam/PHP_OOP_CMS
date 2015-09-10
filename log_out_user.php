<?php include("includes/header.php"); ?>

<?php
    
	if (!isset($_SESSION['user'])) {
	    redirect_to("log_in_user.php");
	}

	$session->user_log_out();
	redirect_to("log_in_user.php");
	
	
?>


