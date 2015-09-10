<?php include("includes/header.php"); ?>

<?php
    $db = new MySql_database();
	
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
	
	$products_per_page = 2;
	
	$total_products = Page::total_products($db);
	
	$pagination = new Pagination($page, $products_per_page, $total_products);
	
	$sql = "SELECT * FROM pages ";
	$sql .= "Where page_type = 'product_page' AND home_page = 'false' ";
	$sql .= "LIMIT {$products_per_page} ";
	$sql .= "OFFSET {$pagination->offset()}";
	
	@ $product_pages = $db->query($sql);
	
	 
	 if (!$product_pages) {
	     $message = "There are no blogs currently for this site.";
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
			<h2>Products</h2>
			<hr/>
			<?php while ($product = $db->fetch_assoc_array($product_pages)) {  ?>
			<div class="page_row clearfix" >
				<div class="page_images">
				    <?php if($image_filename = Image::get_page_image($db, $product["page_id"])) { ?>
						<img src="uploads/images/<?php echo $image_filename  ?>" alt="home_page_image" />
                    <?php } ?>					
				</div>
				<div class="page_desc">
				    <h3><?php echo $product["page_name"]; ?></h3>
					<p><?php echo $product["page_desc"]; ?></p>
					<p><a href="single_product.php?id=<?php echo urlencode($product['page_id']); ?>">Read More</a></p>
				</div>
			</div>
			<hr/>
			
            <?php 
			    } } 
			    
			?>
			<div id="pagination" style="clear: both;">
				<?php
					if($pagination->total_pages() > 1) {
						
						if($pagination->has_previous_page()) { 
						echo "<a href=\"products.php?page=";
					  echo $pagination->previous_page();
					  echo "\">&laquo; Previous</a> "; 
					}

						for($i=1; $i <= $pagination->total_pages(); $i++) {
							if($i == $page) {
								echo " <span class=\"selected\">{$i}</span> ";
							} else {
								echo " <a href=\"products.php?page={$i}\">{$i}</a> "; 
							}
						}

						if($pagination->has_next_page()) { 
							echo " <a href=\"products.php?page=";
							echo $pagination->next_page();
							echo "\">Next &raquo;</a> "; 
					}
						
					}

				?>
			</div>
		</div>

	</div>


<?php include("includes/footer.php"); ?>
