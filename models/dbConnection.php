<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

function dbConnection () {
	try {
		$dbh = new PDO('mysql:host=localhost;dbname='.DATABASENAME, DATABASEUSERNAME, DATABASEUSERPASSWORD);
		return $dbh;
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}

?>