<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

class Admin
{
    public function __construct() 
    {
        include_once("dbConnection.php");
    }

    public function getUsers() 
    {
        $dbh = dbConnection();
        $sth = $dbh->query('select * from users;');
        $count = $sth->rowCount();
        if ($count) {
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } else {
            return false;
        }
    }

    public function addUser($data)
    {
        print_r($data);
        return 0; 
    }
}
