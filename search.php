<?php include("includes/header.php"); ?>

<?php
    $db = new MySql_database();
	
    if (isset($_POST['submit'])) {
	    $search_key = $_POST['search_text'];
		
	    $sql = "SELECT * ";
        $sql .= "FROM pages ";
        $sql .=  "WHERE page_desc LIKE '%{$search_key}%' ";
		$sql .=  "OR page_name LIKE '%{$search_key}%' ";
	    $sql .=  "ORDER BY page_id DESC ";
		
		@ $search_set = $db->query($sql);
	
	} else {
	    redirect_to( "index.php");
	    
	}
    
?>

<div id="wrapper">
    <?php include("includes/user_header.php"); ?>
	
	<div id="content" class="clearfix">
		
		<?php include("includes/top_nav.php"); ?>
		
		<?php include("includes/left_column.php"); ?>
		
		<div id="main_content">
		    <?php if (!$search_set) { ?>
			    <p>No search results found</p>
			<?php } else { ?>
		    
		    <?php while ($search_item = $db->fetch_assoc_array($search_set)) {  ?>
			    <div class="page_row clearfix" >
				<div class="page_images">
				    <?php if($image_filename = Image::get_page_image($db, $search_item["page_id"])) { ?>
						<img src="uploads/images/<?php echo $image_filename  ?>" alt="home_page_image" />
                    <?php } ?>					
				</div>
				<div class="page_desc">
				    <h3><?php echo $search_item["page_name"]; ?></h3>
					<p><?php echo $search_item["page_desc"]; ?></p>
					<?php if ($search_item["page_type"] == "blog_page") { ?>
						<p><a href="single_blog.php?id=<?php echo urlencode($search_item['page_id']); ?>">Read More</a></p>
					<?php } else { ?>
					    <p><a href="single_product.php?id=<?php echo urlencode($search_item['page_id']); ?>">Read More</a></p>
					<?php }  ?>
				</div>
			</div>
			<hr/>
			
			<?php } } ?>
			
		</div>
		
		
	</div>


<?php include("includes/footer.php"); ?>
