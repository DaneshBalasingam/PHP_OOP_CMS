<?php

class Page {
    
	protected $data = array();
	
	public function __construct($id) {
		$this->page_id = $id;
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

    public static function create_page($db, $page_name, $page_desc, $page_content, $page_type, $home_page, $category) {
		
		$page_name = $db->escape_value($page_name);
		$page_desc = $db->escape_value($page_desc);
		$page_content = $db->escape_value($page_content);
		$page_type = $db->escape_value($page_type);
		
		if (self::check_unique_page($db,$page_name)) {
		
			if($home_page == "true") {
				self::change_home_page($db);
			}
		
			$sql  = "INSERT INTO pages (";
			$sql .= "  page_name, page_desc, page_content, page_type, home_page, cat_id ";
			$sql .= ") VALUES (";
			$sql .= " '{$page_name}', '{$page_desc}', '{$page_content}', '{$page_type}', '{$home_page}', {$category}  ";
			$sql .= ")";
			
			@ $db->query($sql);
			
			$new_id = $db->confirm_insert();
			
			return $new_id;
		}
	
		else {
			$new_id = false;
			return $new_id;
		}
	    
	}
	
	public static function check_unique_page($db, $page_name) {
	    $current_pages = self::find_all_pages($db);
		
		while($page = $db->fetch_assoc_array($current_pages)) {
		    if ($page["page_name"] == $page_name) {
			    return false;
			}
		}
		
		return true;
	    
	}
	
	public static function find_home_page($db) {
	    $current_pages = self::find_all_pages($db);
		
		while($page = $db->fetch_assoc_array($current_pages)) {
		    if ($page["home_page"] == 'true') {
			    return $page["page_id"];
			}
		}
		
        return false;
	}
	
	public static function change_home_page($db) {
	    
		if ($home_page = self::find_home_page($db)){
		    $sql  = "UPDATE pages SET ";
			$sql .= "home_page = 'false' ";
			$sql .= "WHERE page_id = {$home_page} ";
			
			@ $db->query($sql);

		}

	
	}
	
	public static function find_all_pages($db) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM pages ";
		$sql .= "ORDER BY page_name ASC";
		$page_set = $db->query($sql);
		
		return $page_set;
	}
	
	public static function get_all_blogs($db) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM pages ";
		$sql .= "Where page_type = 'blog_page' ";
		$page_set = $db->query($sql);
		
		return $page_set;
	}
	
	public static function latest_page_id($db) {
	    $sql  = "SELECT page_id ";
		$sql .= "FROM pages ";
		$sql .= "ORDER BY page_id DESC ";
		$sql .= "LIMIT 1 ";
		
		@ $page_set = $db->query($sql);
		
		if($page = $db->fetch_assoc_array($page_set)) {
		    return $page["page_id"];	
		}
		else {
		   return false;
		}
	}
	
	public static function get_page($db, $id) {
	
	    $sql  = "SELECT * ";
		$sql .= "FROM pages ";
		$sql .= "Where page_id = {$id} ";
		$sql .= "LIMIT 1 ";
		
		try {
		
			$result = $db->query($sql);
		
			if (!$result) {
			    throw new database_exception ( 	"Database query failed: " );
			} else {
				// Create and return user object using the database result
				return $result->fetch_object('Page', array($id));
				
			}
		}
		
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}

	}
	
	public static function total_blogs($db) {
	
	    $sql  = "SELECT count(*) ";
		$sql .= "FROM pages ";
		$sql .= "Where page_type = 'blog_page' ";
		
		$result_set = $db->query($sql);
		$row = $db->fetch_assoc_array($result_set);
		return array_shift($row);
		
	    
	}
    
	public static function total_products($db) {
	
	    $sql  = "SELECT count(*) ";
		$sql .= "FROM pages ";
		$sql .= "Where page_type = 'product_page' ";
		
		$result_set = $db->query($sql);
		$row = $db->fetch_assoc_array($result_set);
		return array_shift($row);
		
	    
	}
	
	public static function total_products_by_cat($db,$cat_id) {
	
	    $sql  = "SELECT count(*) ";
		$sql .= "FROM pages ";
		$sql .= "Where cat_id = {$cat_id} ";
		
		$result_set = $db->query($sql);
		$row = $db->fetch_assoc_array($result_set);
		return array_shift($row);
		
	    
	}
	
	public static function get_pages_by_cat($db,$cat_id) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM pages ";
		$sql .= "Where cat_id = {$cat_id} ";
		$page_set = $db->query($sql);
		
		return $page_set;
	}
}
?>