<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

require_once('dbConnection.php');

if ( isset($_POST['house_id']) ) {
    $query = 'delete from houses where house_id = '.$_POST['house_id'].';';
} elseif ( isset($_POST['building_id']) ) {
    $query = 'delete from buildings where building_id = '.$_POST['building_id'].';';
} else {
   echo false;
   exit;
}

$dbh = dbConnection();
$state = $dbh->exec($query);
if ( $state ) {
    echo true;
} else {
    echo false;
}

?>