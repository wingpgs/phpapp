<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

class Home
{
    public function __construct() 
    {
        include_once("dbConnection.php");
    }

    public function getMaps() 
    {
        $query = 'select * from maps where map_use = 1;';
        $dbh = dbConnection();
        $sth = $dbh->query($query);
        $count = $sth->rowCount();
        if ($count) {
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } else {
            return false;
        }
    }
}
