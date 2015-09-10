<?php
    defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
	defined('DB_USER')   ? null : define("DB_USER", "root");
	defined('DB_PASS')   ? null : define("DB_PASSWORD", "");
	defined('DB_NAME')   ? null : define("DB_NAME", "basic_cms");
	
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	
	
	require_once("models/session.php");
    require_once("functions.php");
	require_once("models/validator.php");
	require_once("defined_exceptions.php");
	require_once("models/database.php");
	require_once("models/pagination.php");
	require_once("models/user.php");
	require_once("models/image.php");
	require_once("models/page.php");
	require_once("models/category.php");
	require_once("models/comment.php");
	
?>