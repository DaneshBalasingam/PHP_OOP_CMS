<?php include("includes/header.php"); ?>

<?php
    $message = "";
    if (isset($_POST['submit'])) {
	
	    $username = $_POST["username"];
		$password = $_POST["password"];
		
		if ($logged_in = User::authenticate_admin($username, $password)) {
		    $session->admin_logged_in($username);
		    redirect_to("admin.php");
		} 
		else {
		    $message = "logged In failed. Please try again";
		}
	
	}
	
?>

<div id="wrapper">
	<div id="header" class="clearfix">
	    <div id="header_logo">
		     <img src="images/logo.png" alt="syndicated luthiers logo">
		</div> 
		<div id="admin_header_log_in">
			<p>Welcome admin user</p>
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
			<h2>Log In</h2>
			<br/>
			<form action="log_in_admin.php" method="post">
				<p>Username:
					<input type="text" name="username" value="" />
				</p>
				<p>Password:
					<input type="password" name="password" value="" />
				</p>
				<input type="submit" name="submit" value="Log In" />
			</form>	
            <p><?php echo $message ?></p>			
		</div>
	</div>


<?php include("includes/footer.php"); ?>
