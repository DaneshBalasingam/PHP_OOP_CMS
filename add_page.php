<?php include("includes/header.php"); ?>

<?php 
    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}
	
	$message = "";
	
	if(isset($_POST['submit'])) {
	
	    $required_fields = array("page_name", "page_desc", "page_content");
		
		if (!$errors = Validator::validate_presences($required_fields)) {
		
		    $required_lengths = array("page_name" => "20", "page_desc" => "300", "page_content" => "1000");
			
			if (!$errors = Validator::validate_max_lengths($required_lengths)) {
			    $db = new MySql_database();
				
				$image_file = $_FILES['file_upload'];
				$file_name = basename($image_file['name']);
				
				if (Image::exist_file($file_name)) {
				    $errors = array("image_name" => "Image name is already in use");
					$db->close_connection();
				    
				}
				else {
					if (!isset($_POST['home_page'])) {
						$_POST['home_page'] = 'false';
					}
					
				
					$new_id = Page::create_page($db,$_POST['page_name'],$_POST['page_desc'],$_POST['page_content'],$_POST['page_type'],$_POST['home_page'],$_POST['category']);
					
					
					if (!$new_id) {
							$errors = array("page_name" => "Page name is already in use");
							$db->close_connection();
					}
					else {
							
						Image::add_page_photo($db, $image_file, $new_id);
						$session->create_message("New page " . htmlspecialchars($_POST["page_name"]) ." with id " . $new_id . " created" );
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
			<h2>Add Page</h2>
			<form action="add_page.php" enctype="multipart/form-data" method="post">
			    <div class="form_row clearfix">
					<div class="form_left">
						<label for="page_name">Page Name</label>
					</div>
					<div class="form_right">
							<input  name="page_name" type="text" 
							    value="<?php if (isset ($_POST['page_name'])) { echo $_POST['page_name'];} ?>" id="page_name"/>
							<div class="error">
							    <?php if (isset ($errors["page_name"])) {
							          echo $errors["page_name"]; } 
								?>
							</div>
					</div>
				</div>
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="page_desc">Page Description</label>
					</div>
					<div class="form_right">
							<textarea  name="page_desc" rows="8" cols="35" 
							    value="" id="page_desc"><?php if (isset ($_POST['page_desc'])) { echo $_POST['page_desc'];} ?></textarea>
							<span class="error">
							    <?php if ( isset ($errors["page_desc"])) {
							          echo $errors["page_desc"]; } 
								?>
							</span>
					</div>
				</div>
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="email">Page Content</label>
					</div>
					<div class="form_right">
							<textarea  name="page_content" rows="15" cols="35"
							     value="" id="page_content"/><?php if (isset ($_POST['page_content'])) { echo $_POST['page_content'];} ?></textarea>
							<span class="error">
							    <?php if ( isset ($errors["page_content"])) {
							          echo $errors["page_content"]; } 
								?>
							</span>
					</div>
				</div>
				
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="page_type">Page Type</label>
					</div>
					<div class="form_right">
						<select name="page_type">
							<option value="blog_page">Blog Page</option>
							<option value="product_page">Product Page</option>					    
                        </select>						
					</div>
				</div>
				
				<div class="form_row clearfix">
					<div class="form_left">
						<label for="category">Category</label>
					</div>
					<div class="form_right">
						<select name="category">
						    <option value="0">None</option>
						    <?php 
							    $db = new MySql_database();
								$category_set = Category::find_all_cat($db);
								while($category = $db->fetch_assoc_array($category_set)) {
							?>
							<option value="<?php echo $category["cat_id"]  ?>"><?php echo $category["cat_name"]  ?></option>
                            <?php } ?>							
                        </select>						
					</div>
				</div>
				
				<div class="form_row clearfix">
				    <input type="checkbox" name="home_page" value="true"><span>Set as home page</span>
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
			
				<input type="submit" name="submit" value="Add Page" />
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
