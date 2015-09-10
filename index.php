<?php include("includes/header.php"); ?>

<?php
    $db = new MySql_database();
	
    if (!$home_page_id = Page::find_home_page($db)) {
	    $home_page_id = Page::latest_page_id($db);
	}
	
	if (!$home_page_id) {
	    $message = "There is no content in this site yet.";
		$db->close_connection();
	} 
	else {
	    $page = Page::get_page($db, $home_page_id );
		
	}
    
?>

<div id="wrapper">
    <?php include("includes/user_header.php"); ?>
	
	<div id="content" class="clearfix">
		
		<?php include("includes/top_nav.php"); ?>
		
		<?php include("includes/left_column.php"); ?>
		
		<div id="main_content">
			<?php if (isset ($message)) { 
			    echo $message;
			} else { ?>
			<h2><?php echo $page->page_name; ?></h2>
			<div id="page_image">
			    <?php if($image_filename = Image::get_page_image($db, $home_page_id )) {?>
			        <img src="uploads/images/<?php echo $image_filename  ?>" alt="home_page_image" /> 
                <?php }?>				
			</div>
			<div id="text_content">
			    <?php echo $page->page_content; ?>
			</div>
			
            <?php } 

			?>
		</div>
		
		
	</div>


<?php include("includes/footer.php"); ?>
