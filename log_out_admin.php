<?php include("includes/header.php"); ?>

<?php
    
	if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}

	$session->admin_log_out();
	redirect_to("log_in_admin.php");
	
	
?>


