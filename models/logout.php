<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

if ($_COOKIE['token']) {
    require_once("dbConnection.php");
    $query = 'delete from token where token_id = :tokenId;';
    $dbh = dbConnection();
    $sth = $dbh->prepare($query);
    $sth->bindParam(':tokenId', $_SESSION['token_id'], PDO::PARAM_INT);
    $sth->execute();
}
session_destroy();
?>

<meta http-equiv="refresh" content="0;url=/" />

