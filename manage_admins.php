<?php 
    include("includes/header.php"); 
?>

<?php

    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}
	
    $db = new MySql_database();
	$admin_set = User::find_all_admins($db);
	
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
			<h2>Manage Admins</h2>
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
				    <th>Username</th>
					<th>Actions</th>
				</tr>
				<?php while($admin = $db->fetch_assoc_array($admin_set)) { ?>
				<tr>
					<td><?php echo htmlspecialchars($admin["username"]); ?></td>
					<td><a href="edit_admin.php?id=<?php echo $admin['user_id'] ?>">Edit</a></td>
					<td><a href="delete_admin.php?id=<?php echo urlencode($admin['user_id']); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
				</tr>
				<?php 
				    } 
								
				?>
			</table>
			<br />
			<a href="create_admin.php">Add new admin</a>
			
			
		
		</div>
	</div>


<?php include("includes/footer.php"); ?>
