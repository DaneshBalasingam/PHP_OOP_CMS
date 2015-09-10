<?php include("includes/header.php"); ?>
<?php
    
	$db = new MySql_database();
	
	if (Comment::delete_comment($db,$_GET["comment_id"])) {
	    $session->create_message("Comment deleted");
	} else {
		$session->create_message("Unable to delete due to error");
	}
	
	redirect_to( $_GET["page"]."?id=".$_GET["page_id"]);
?>
<?php include("includes/footer.php"); ?>