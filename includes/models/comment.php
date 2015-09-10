<?php
class Comment {

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
	
	public static function create_comment($db, $page_id, $username, $content) {

		$content = $db->escape_value($content);
        $created = strftime("%Y-%m-%d %H:%M:%S", time());
		
		$sql  = "INSERT INTO comments (";
		$sql .= "  page_id, created, username, content ";
		$sql .= ") VALUES (";
		$sql .= " '{$page_id}', '{$created}', '{$username}', '{$content}' ";
		$sql .= ")";
		
		@ $db->query($sql);
		
		$new_id = $db->confirm_insert();
		
		return $new_id;
			
	}
	
	public static function find_page_comments($db, $page_id) {
		
		$sql  = "SELECT * ";
		$sql .= "FROM comments ";
		$sql .= "WHERE page_id = '{$page_id}' ";
		$sql .= "ORDER BY created DESC";
		$page_set = $db->query($sql);
		
		return $page_set;
	}

	public static function delete_comment($db, $comment_id) {
	
		$sql = "DELETE FROM comments WHERE comment_id = {$comment_id} LIMIT 1";
		
		@ $db->query($sql);
		
		if ($db->affected_rows()) {
			return true;
		}
		else {
			return false;
		}
	}

}
?>