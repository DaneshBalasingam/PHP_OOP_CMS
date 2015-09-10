<?php
    include("includes/header.php");

?>

<?php
    $db = new MySql_database();
	
    if (isset($_POST['submit'])) {
	

        $required_fields = array("username", "password", "email");
	    
		if (!$errors = Validator::validate_presences($required_fields)) {
		  
		    $required_lengths = array("username" => "20", "password" => "20", "email" => "50");
			
			if (!$errors = Validator::validate_max_lengths($required_lengths)) {
		
				if(!Validator::validate_email($_POST["email"])) {
					 $errors = array("email" => "Please enter valid email");
				
				}
				else {
			        
					$new_id = User::create_user($db, $_POST["username"], $_POST["password"], $_POST["email"], "user");
					if (!$new_id) {
					    $errors = array("username" => "Username is already in use");
						
					}
					else {
					    $session->create_message("New user " . htmlspecialchars($_POST["username"]) ." with id " . $new_id . " created" );
					    
					}
					
					
					
				}
			}
	
	    }

	}	

?>

<div id="wrapper">
    <?php include("includes/user_header.php"); ?>
	
	<div id="content" class="clearfix">
	    
		<?php include("includes/top_nav.php"); ?>
		
		<?php include("includes/left_column.php"); ?>
		
	    <div id="main_content">			
			<?php 
				if (isset($_SESSION['message'])) {
					    echo $_SESSION['message'];
						$session->delete_message();
					}
			     
			?>
			<h2>Create User</h2>
			<form action="create_user.php" method="post">
			    <div class="form_row clearfix">
					<div class="form_left">
						<label for="username">Username</label>
					</div>
					<div class="form_right">
							<input  name="username" type="text" 
							    value="<?php if (isset ($_POST['username'])) { echo $_POST['username'];} ?>" id="username"/>
							<span class="error">
							    <?php if (isset ($errors["username"])) {
							          echo $errors["username"]; } 
								?>
							</span>
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
							     value="<?php if (isset ($_POST['email'])) { echo $_POST['email'];} ?>" id="email"/>
							<span class="error">
							    <?php if ( isset ($errors["email"])) {
							          echo $errors["email"]; } 
								?>
							</span>
					</div>
				</div>
			
				<input type="submit" name="submit" value="Create User" />
			</form>
		
		</div>
	</div>


<?php include("includes/footer.php"); ?>
