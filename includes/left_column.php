<div id="left_column">
     <div id="search_box">
	    <form action="search.php" method="POST">
			<p><label for="search">Search </label></p>
			<p><input type="text" name="search_text" id="search_input"></p>
			<p><input type="submit" name="submit" value="Search"></p>
		</form>
	 </div>
	 <div id="left_nav">
		<?php 
			$category_set = Category::find_all_cat($db);
			
			while($category = $db->fetch_assoc_array($category_set)) {
		?>
		<ul>
			<li><a href="product_cat.php?id=<?php echo $category["cat_id"]  ?>"><?php echo $category["cat_name"]  ?></a></li>
		</ul>
		<?php } ?>
	</div>
</div>