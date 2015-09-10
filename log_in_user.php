<?php include("includes/header.php"); ?>

<?php
    $db = new MySql_database();
	
    $message = "";
    if (isset($_POST['submit'])) {
	
	    $username = $_POST["username"];
		$password = $_POST["password"];
		
		if ($logged_in = User::authenticate_user($db,$username, $password)) {
		    $session->user_logged_in($username);
		    redirect_to("index.php");
		} 
		else {
		    $message = "logged In failed. Please try again";
		}
	
	}
    
?>

<div id="wrapper">
	<?php include("includes/user_header.php"); ?>
	
	<div id="content" class="clearfix">
	
		<?php include("includes/top_nav.php"); ?>
		
		<?php include("includes/left_column.php"); ?>
		
		<div id="main_content">
			<h2>Log In</h2>
			<br/>
			<form action="log_in_user.php" method="post">
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
