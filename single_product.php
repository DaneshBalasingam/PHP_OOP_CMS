<?php include("includes/header.php"); ?>

<?php
    $db = new MySql_database();
	
	$page = Page::get_page($db, $_GET["id"]);
	
	  
	if (!$page) {
	    
		redirect_to("products.php");
	
 
	}

?>

<div id="wrapper">
    <?php include("includes/user_header.php"); ?>
	
	<div id="content" class="clearfix">
		
		<?php include("includes/top_nav.php"); ?>
		
		<?php include("includes/left_column.php"); ?>
		
		<div id="main_content">
			<h2><?php echo $page->page_name; ?></h2>
			<div id="page_image">
			    <?php if($image_filename = Image::get_page_image($db, $page->page_id)) {?>
			        <img src="uploads/images/<?php echo $image_filename  ?>" alt="home_page_image" /> 
                <?php }?>				
			</div>
			<div id="text_content">
			    <?php echo $page->page_content; ?>
			</div>
			
			<?php include("includes/comment_form.php"); ?>
   
		</div>
		
		
	</div>


<?php include("includes/footer.php"); ?>
