<?php
header("Access-Control-Allow-Origin: *");
@session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
class Database{
	public static function getConnection(){
		include 'db.php';
		try {
			$conn_str = "pgsql:host=localhost;port=5432; dbname={$database['db']};user={$database['user']};password={$database['password']}";
    		$db = new PDO($conn_str);
    		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    		return $db;
		 } catch (PDOException  $e) {
		    echo $e->getMessage();
		 }

	}
}

