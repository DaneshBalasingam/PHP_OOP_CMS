<?php

class MySql_database {

	//attributes
	private $mysqli;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;


	public function __construct() {
		
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );

		
	}
	
	public function open_connection() {
	
		try {
		
			@ $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
			
			if($this->mysqli->connect_errno) {
				throw new database_exception("Database connection failed: " . 
									 $this->mysqli->connect_error . 
									 " (" . $this->mysqli->connect_errno . ")" );
			}	

           			
		}
  
		catch ( database_exception $e) {
			echo $e . "<br/>";
			echo $e->clean_up();
				
		}

	}
	
	public function escape_value( $value ) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string( $this->mysqli, $value );
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}



	//execute the passed in query and return result
	public function query($sql) {

		$this->last_query = $sql;
		//execute query
		$result = $this->mysqli->query($sql);

		return $result;
	}
	
	public function stmt_init() {
	    return $this->mysqli->stmt_init();
	}
	
	//throw exception if no query result
    public function confirm_query($result_set) {
	    try {
			if (!$result_set) {
				throw new database_exception( 	"Database query failed: " .
												$this->mysqli->error . " " .
												$this->mysqli->errno . " " .
												$this->mysqli->sqlstate);
			}
		}
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}
	}
	
	public function confirm_insert() {
	    try {
			if (!$this->affected_rows()) {
				throw new database_exception( 	"Database query failed: " .
												$this->mysqli->error . " " .
												$this->mysqli->errno . " " .
												$this->mysqli->sqlstate);
			}
		}
		catch ( database_exception $e) {
		    echo $e . "<br/>";
			echo $e->clean_up();
		}
	    return $this->inserted_id();
	}


	// fetch a row from result_set as an associative array
	public function fetch_assoc_array($result_set) {
		return $result_set->fetch_assoc();
	}
	
    public function fetch_num_array($result_set) {
		return $result_set->fetch_row();
	}
	
	//fetch number of rows
	 public function num_rows($result_set) {
	    return $result_set->num_rows; 
	}
	
	// get the last id inserted over the current db connection
	public function inserted_id() {
    
		return $this->mysqli->insert_id;
	}
  
	public function affected_rows() {
		return $this->mysqli->affected_rows;
	}
	
	public function result_rewind($result_set, $row=0) {
	    $result_set->data_seek($row);
	}
	
	public function fetch_all($result_set) {
		return $result_set->fetch_all();
	}
	
	public function free_result($result_set) {
		$result_set->free_result();
	}
	
	public function close_connection() {
		
		$this->mysqli->close();
		
	}


}



?>