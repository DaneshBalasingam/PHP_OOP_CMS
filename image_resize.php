<?php include("includes/header.php"); ?>
<?php

    if (!isset($_SESSION['admin_user'])) {
	    redirect_to("log_in_admin.php");
	}
	
?>
<?php 

    $db = new MySql_database();
	
	$message = "";
	
	$id = $_GET['id'];
	
	$image = Image::get_image_by_id($db, $id);
	$full_path = "uploads/images/{$image->file_name}";
	$image_info = getimagesize($full_path);
	$orig_w = $image_info[0];
	$orig_h = $image_info[1];
	
	$dimension = $_GET['size'];
	
	if($orig_h>$orig_w) {
		$new_w = ($dimension/$orig_h)*$orig_w;
		$new_h = $dimension;
	} else {
	   $new_h = ($dimension/$orig_w)*$orig_h;
	   $new_w = $dimension;
	}
	
	if ($image->file_type == "image/jpeg") {
		$success = Image::resize_jpeg($new_w,$new_h,$orig_w,$orig_h,$full_path);
	} elseif ($image->file_type == "image/png"){
		$success = Image::resize_png($new_w,$new_h,$orig_w,$orig_h,$full_path);
	} elseif ($image->file_type == "image/gif") {
	   $success = Image::resize_gif($new_w,$new_h,$orig_w,$orig_h,$full_path);
	} else {
	  $message = "Image format not supported for resize";
	}
	
	if($success) {
	    $session->create_message("Image resize success");
	} else {
	    $session->create_message("Unable to resize image. " . $message );
	}
	redirect_to("edit_image.php");

?>

<?php include("includes/footer.php"); ?>