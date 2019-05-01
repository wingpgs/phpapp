<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

class Admin_model
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

    public function logout()
    {
        if (array_key_exists('token',$_COOKIE)) {
            $query = 'delete from token where token_id = :tokenId;';
            $dbh = dbConnection();
            $sth = $dbh->prepare($query);
            $sth->bindParam(':tokenId', $_SESSION['token_id'], PDO::PARAM_INT);
            $sth->execute();
        }
        session_destroy();
    }
}
