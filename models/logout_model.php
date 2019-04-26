<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

class Logout_model
{

    public function __construct()
    {
        require_once("dbConnection.php");
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
?>


