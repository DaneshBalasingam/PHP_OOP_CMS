<?php include("includes/header.php"); ?>

<?php

    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}

		$db = new MySql_database();
		
		$admin = User::get_user($db, $_GET["id"]);
	
	  
	if (!$admin) {
	    
		redirect_to("manage_admins.php");
	}
	
?>

<?php
    if (isset($_POST['submit'])) {
	

        $required_fields = array("password", "email");
	    
		if (!$errors = Validator::validate_presences($required_fields)) {
		  
		    $required_lengths = array("password" => "20", "email" => "50");
			
			if (!$errors = Validator::validate_max_lengths($required_lengths)) {
		
				if(!Validator::validate_email($_POST["email"])) {
					 $errors = array("email" => "Please enter valid email");
				
				}
				else {
			        $db = new MySql_database();
					$updated = User::update_user($db, $_POST["password"], $_POST["email"], $admin->user_id );
                    $db->close_connection();
					
					if($updated) {
					    $session->create_message("User " . $admin->username . " updated" );
					    redirect_to( "manage_admins.php" );
					}					
					
				}
			}
	
	    }

	}	

?>

<div id="wrapper">
	<div id="header" class="clearfix">
	    <div id="header_logo">
		     <img src="images/logo.png" alt="syndicated luthiers logo">
		</div> 
		<div id="admin_header_log_in">
			<p>Welcome <?php echo $_SESSION['admin_user'] ?></p>
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
			<h2>Update admin user</h2>
			
			<form action="edit_admin.php?id=<?php echo $admin->user_id ?>" method="post">
			    <div class="form_row clearfix">
					<div class="form_left">
						<p for="username">Username</p>
					</div>
					<div class="form_right">
						<?php echo $admin->username; ?>
					</div>
				</div>
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="password">Password</label>
					</div>
					<div class="form_right">
							<input  name="password" type="password" value="" id="password"/>
							<span class="error">
							    <?php if ( isset ($errors["password"])) {
							          echo $errors["password"]; } 
								?>
							</span>
					</div>
				</div>
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="email">Email</label>
					</div>
					<div class="form_right">
							<input  name="email" type="email" 
							     value="<?php echo $admin->email; ?>" id="email"/>
							<span class="error">
							    <?php if ( isset ($errors["email"])) {
							          echo $errors["email"]; } 
								?>
							</span>
					</div>
				</div>
			
				<input type="submit" name="submit" value="Update Admin" />
			</form>
			
			
			<br />
			<a href="manage_admins.php">Cancel</a>
			
			
		
		</div>
	</div>
    

<?php include("includes/footer.php"); ?>
