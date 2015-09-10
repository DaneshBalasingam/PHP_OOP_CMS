	<div id="header" class="clearfix">
	    <div id="header_logo">
		     <img src="images/logo.png" alt="syndicated luthiers logo">
		</div> 
		<div id="user_header_log_in">
		        <?php if ( isset ($_SESSION["user"]) ) { ?>
				     
					<p>Welcome <?php echo $_SESSION['user'] ?></p> 

                    <p><a href="log_out_user.php">Log Out</a></p>
				<?php } elseif ( isset ($_SESSION["admin_user"]) ) { ?>
				    <p>Welcome <?php echo $_SESSION['admin_user'] ?></p> 

                    <p><a href="log_out_admin.php">Log Out</a></p>
                				
				<?php	} else {
				?>
				<a href="log_in_user.php" id="logInButton">LOG IN</a></br>
				<div id="createAccLink">
				    <a href="create_user.php">Create Account</a>
				</div>
				<?php } ?>
		</div>

	</div>