<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

require_once('dbConnection.php');        
$query = 'select map_id, map_name from maps where map_use = 1;';
$dbh = dbConnection();
$sth = $dbh->query($query);
$count = $sth->rowCount();
if ($count) {
    $results = $sth->fetchAll(PDO::FETCH_ASSOC);
    $i = json_encode($results);
    print_r($i);
}
?>
