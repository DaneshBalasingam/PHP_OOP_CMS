<?php

class Image {

	protected $data = array();
	
	public function __construct($id) {
		$this->user_id = $id;
	}
	
	public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        } else {
            return false;
        }
    }
    
	public static function add_page_photo ($db, $file, $page_id) {
	    self::upload($file);
		
		$file_name = basename($file['name']);
		$file_type = $file['type'];
		$file_size = $file['size'];
		
		$sql  = "INSERT INTO images (";
		$sql .= "  file_name, file_size, file_type, page_id ";
		$sql .= ") VALUES (";
		$sql .= " '{$file_name}', '{$file_size}', '{$file_type}', '{$page_id}' ";
		$sql .= ")";
			
		@ $db->query($sql);
		
		$new_id = $db->confirm_insert();
	}
	
	public static function add_cat_photo ($db, $file, $cat_id) {
	    self::upload($file);
		
		$file_name = basename($file['name']);
		$file_type = $file['type'];
		$file_size = $file['size'];
		
		$sql  = "INSERT INTO images (";
		$sql .= "  file_name, file_size, file_type, cat_id ";
		$sql .= ") VALUES (";
		$sql .= " '{$file_name}', '{$file_size}', '{$file_type}', '{$cat_id}' ";
		$sql .= ")";
			
		@ $db->query($sql);
		
		$new_id = $db->confirm_insert();
	}
	
	public static function upload ($file) {
	    try {
			
			$tmp_file = $file['tmp_name'];

			$target_file = basename($file['name']);

			$upload_dir = "uploads".DS."images";

			if(move_uploaded_file($tmp_file, $upload_dir.DS.$target_file)) {
				return $target_file;
			} else {
				throw new file_upload_exception($file['error']);
			}
		}
		catch( file_upload_exception $e) {
			$_SESSION["message"] = $e . "<br/>";

		}
	}
	
	public static function exist_file ($image_file) {
	    if ($dir_handle = opendir("uploads".DS."images")) {
		    while($filename = readdir($dir_handle)) {
				if ( $filename == $image_file ) {
				    return true;
				}
            }
		}
		
		closedir($dir_handle);
		
		return false;
	}
	
	public static function get_page_image ($db, $page_id ) {
	
	    $sql  = "SELECT file_name ";
		$sql .= "FROM images ";
		$sql .= "Where page_id = {$page_id} ";
		
		$image_set = $db->query($sql);
		
		if($image = $db->fetch_assoc_array($image_set)) {
		    return $image["file_name"];	
		}
		else {
		   return false;
		}
	
	}
	
	public static function get_cat_image ($db, $cat_id ) {
	
	    $sql  = "SELECT file_name ";
		$sql .= "FROM images ";
		$sql .= "Where cat_id = {$cat_id} ";
		
		$image_set = $db->query($sql);
		
		if($image = $db->fetch_assoc_array($image_set)) {
		    return $image["file_name"];	
		}
		else {
		   return false;
		}
	
	}
	
	public static function get_image_by_id($db, $id) {
	
	    $sql  = "SELECT * ";
		$sql .= "FROM images ";
		$sql .= "Where image_id = ? ";
		$sql .= "LIMIT 1 ";
		
		try {
		
			$result = $db->query($sql);
		
			if (!$result) {
			    throw new database_exception ( 	"Database query failed" );
			} else {
				// Create and return user object using the database result
				return $result->fetch_object('Image', array($id));
				
			}
		}
		
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}

	}
	
	public static function find_all_images($db) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM images ";
		$sql .= "ORDER BY image_id ASC";
		$image_set = $db->query($sql);
		
		return $image_set;
	}
	
	
	public static function resize_jpeg ($new_w,$new_h,$orig_w,$orig_h,$full_path) {
	    $im = ImageCreateTrueColor($new_w,$new_h);
		$baseimage = ImageCreateFromJpeg($full_path);
		imagecopyResampled($im,$baseimage,0,0,0,0,$new_w,$new_h,$orig_w,$orig_h);
		imagejpeg($im,$full_path);
		imagedestroy($im);
		
		if (file_exists($full_path)) {
		    return true;
		} else {
		    return false;
		}
	}
	
	public static function resize_png ($new_w,$new_h,$orig_w,$orig_h,$full_path) {
	    $im = ImageCreateTrueColor($new_w,$new_h);
		$bgc = ImageColorAllocate($im, 255,255,255);
		imagecolortransparent($im,$bgc);
		imagefilledrectangle($im,0,0,$new_w,$new_h,$bgc);
		$baseimage = ImageCreateFromPng($full_path);
		imagecopyResampled($im,$baseimage,0,0,0,0,$new_w,$new_h,$orig_w,$orig_h);
		imagepng($im,$full_path);
		imagedestroy($im);
		
		if (file_exists($full_path)) {
		    return true;
		} else {
		    return false;
		}
	}
	
	//manual for resize http://php.net/manual/en/function.imagecreatefromgif.php
	public static function resize_gif ($new_w,$new_h,$orig_w,$orig_h,$full_path) {
	    $im = ImageCreateTrueColor($new_w,$new_h);
		$bgc = ImageColorAllocate($im, 255,255,255);
		imagecolortransparent($im,$bgc);
		imagefilledrectangle($im,0,0,$new_w,$new_h,$bgc);
		$baseimage = ImageCreateFromGif($full_path);
		imagecopyResampled($im,$baseimage,0,0,0,0,$new_w,$new_h,$orig_w,$orig_h);
		imagegif($im,$full_path);
		imagedestroy($im);
		
		if (file_exists($full_path)) {
		    return true;
		} else {
		    return false;
		}
	}
	
} 






?>