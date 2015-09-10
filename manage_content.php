<?php include("includes/header.php"); ?>

<?php 
    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}

?>

<div id="wrapper">
	<div id="header" class="clearfix">
	    <div id="header_logo">
		     <img src="images/logo.png" alt="syndicated luthiers logo">
		</div> 
		<div id="admin_header_log_in">
			<p>Welcome <?php echo $_SESSION['admin_user'] ?> </p>
		</div>

	</div>
	<div id="content" class="clearfix">
		<div id="left_column">
			<ul>
			    <li><a href="admin.php">Home</a></li>
			    <li><a href="manage_content.php">Manage Content</a></li>
			    <li><a href="manage_admins.php">Manage Users</a></li>
			    <li><a href="log_out_admin.php">Logout</a></li>
			</ul>
	      
		</div>
	    <div id="main_content">
			<h2>Content Management</h2>
			<div><?php
			     if (isset($_SESSION['message'])) {
					    echo $_SESSION['message'];
						$session->delete_message();
					} 
				?></div>
			<br/>
			<ul>
			    <li><a href="add_page.php">Add Page</a></li>
				<li><a href="add_category.php">Add Category</a></li>
				<li><a href="edit_image.php">Edit Image</a></li>
			<ul>
	
		</div>
	</div>


<?php include("includes/footer.php"); ?>
