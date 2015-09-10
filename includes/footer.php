			<div id="footer">Copyright not reserved</div>
        </div> <!-- closes wrapper -->
		
		<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
			tinymce.init({
			selector: "#page_content",
			
			plugins: "colorpicker, media, image, textcolor",
			
			toolbar: "forecolor backcolor"
			
			

			
		});
		</script>
	</body>
</html>
<?php
    if(isset($db)) { $db->close_connection(); } 
	
	ob_flush();
?>
