<?php include("includes/header.php"); ?>
<?php

    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}
	$db = new MySql_database();
	
	$image_set = Image::find_all_images($db);

	
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
			<h2>Resize image</h2>
			
			<p>
			    <?php 
				    if (isset($_SESSION['message'])) {
					    echo $_SESSION['message'];
						$session->delete_message();
					}
				?>
			</p>
			
			<br />
			<table>
				<tr>
				    <th>Image</th>
					<th>Resize</th>
				</tr>
				<?php while($image = $db->fetch_assoc_array($image_set)) { ?>
				<tr>
					<td><?php echo htmlspecialchars($image["file_name"]); ?></td>
					<td><a href="image_resize.php?id=<?php echo $image['image_id']?>&size=300" onclick="return confirm('Are you sure?');">Small</a></td>
					<td><a href="image_resize.php?id=<?php echo $image['image_id'];?>&size=600" onclick="return confirm('Are you sure?');">Medium</a></td>
				</tr>
				<?php 
				    } 
								
				?>
			</table>
			
			
		
		</div>
	</div>
<?php include("includes/footer.php"); ?>