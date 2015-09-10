<?php

class Category {
    
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

    public static function create_category($db, $cat_name ) {
		
		$cat_name = $db->escape_value($cat_name);
		
		if (self::check_unique_cat($db,$cat_name)) {

			$sql  = "INSERT INTO categories (";
			$sql .= "  cat_name ";
			$sql .= ") VALUES (";
			$sql .= " '{$cat_name}' ";
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
	
	public static function check_unique_cat($db, $cat_name) {
	    $current_categories = self::find_all_cat($db);
		
		while($cat = $db->fetch_assoc_array($current_categories)) {
		    if ($cat["cat_name"] == $cat_name) {
			    return false;
			}
		}
		
		return true;
	    
	}

	public static function find_all_cat($db) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM categories ";
		$sql .= "ORDER BY cat_name ASC";
		$category_set = $db->query($sql);
		
		return $category_set;
	}
	

	
	public static function latest_cat_id($db) {
	    $sql  = "SELECT cat_id ";
		$sql .= "FROM categories ";
		$sql .= "ORDER BY cat_id DESC ";
		$sql .= "LIMIT 1 ";
		
		@ $category_set = $db->query($sql);
		
		if($cat = $db->fetch_assoc_array($category_set)) {
		    return $cat["cat_id"];	
		}
		else {
		   return false;
		}
	}
	
	public static function get_cat($db, $id) {
	
	    $sql  = "SELECT * ";
		$sql .= "FROM categories ";
		$sql .= "Where cat_id = {$id} ";
		$sql .= "LIMIT 1 ";
		
		try {
		
			$result = $db->query($sql);
		
			if (!$result) {
			    throw new database_exception ( 	"Database query failed: "  );
			} else {
				// Create and return user object using the database result
				return $result->fetch_object('Category', array($id));
				
			}
		}
		
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}

	}
	    
}
?>