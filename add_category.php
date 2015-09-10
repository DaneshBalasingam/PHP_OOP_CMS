<?php include("includes/header.php"); ?>

<?php 
    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}
	
	$message = "";
	
	if(isset($_POST['submit'])) {
	
	    $required_fields = array("cat_name");
		
		if (!$errors = Validator::validate_presences($required_fields)) {
		
		    $required_lengths = array("cat_name" => "20" );
			
			if (!$errors = Validator::validate_max_lengths($required_lengths)) {
			    $db = new MySql_database();
				
				$image_file = $_FILES['file_upload'];
				$file_name = basename($image_file['name']);
				
				if (Image::exist_file($file_name)) {
				    $errors = array("image_name" => "Image name is already in use");
					$db->close_connection();
				    
				}
				else {
					
					$new_id = Category::create_category($db,$_POST['cat_name']);
					
					if (!$new_id) {
							$errors = array("cat_name" => "Category name is already in use");
							$db->close_connection();
					}
					else {
							
						Image::add_cat_photo($db, $image_file, $new_id);
						$session->create_message("New category " . htmlspecialchars($_POST["cat_name"]) ." with id " . $new_id . " created" );
						$db->close_connection();
						redirect_to("manage_content.php");
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
			<h2>Add Category</h2>
			<form action="add_category.php" enctype="multipart/form-data" method="post">
			    <div class="form_row clearfix">
					<div class="form_left">
						<label for="cat_name">Category Name</label>
					</div>
					<div class="form_right">
							<input  name="cat_name" type="text" 
							    value="<?php if (isset ($_POST['cat_name'])) { echo $_POST['cat_name'];} ?>" id="cat_name"/>
							<div class="error">
							    <?php if (isset ($errors["cat_name"])) {
							          echo $errors["cat_name"]; } 
								?>
							</div>
					</div>
				</div>
				
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="image">Image Upload </label>
					</div>
					<div class="form_right">
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
						<p><input type="file" name="file_upload" /></p>
						<span class="error">
							<?php if ( isset ($errors["image_name"])) {
								  echo $errors["image_name"]; } 
							?>
						</span>
					</div>
				</div>
			
				<input type="submit" name="submit" value="Add Category" />
			</form>
	        <div><?php
			     if (isset($_SESSION['message'])) {
					    echo $_SESSION['message'];
						$session->delete_message();
					} 
				?></div>
		</div>
	</div>


<?php include("includes/footer.php"); ?>
