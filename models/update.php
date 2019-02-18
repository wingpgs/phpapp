<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

require_once('dbConnection.php');        

// 여기부터 query 생성 작업중.
if ( isset($_POST['house_id']) ) {
    $queryhead = 'update houses set '; $querytail = ' where house_id = '.$_POST['house_id'];
    unset($_POST['house_id']);
} elseif ( isset($_POST['building_id']) ) {
    $queryhead = 'update buildings set '; $querytail = ' where building_id = '.$_POST['building_id'];
    unset($_POST['building_id']);
} elseif ( isset($_POST['map_id']) ) {
    $queryhead = 'update maps set '; $querytail = ' where map_id = '.$_POST['map_id'];
    unset($_POST['map_id']);
} else {
   exit;
}

// query 가운데 부분 'key = :key' 형태로 가공
$querybody = '';
$keys = array_keys($_POST);
for ( $i = 0; $i < count($keys); $i++ ) {
    $queryparts = $keys[$i].' = :'.$keys[$i];
    if ( $i == 0 ) {
         $querybody = $queryparts;
    } else {
         $querybody = $querybody.','.$queryparts;
    }
}

$query = $queryhead.$querybody.$querytail;
// query 생성 완료

//$i = json_encode($query);
//print_r($query);


$dbh = dbConnection();
$sth = $dbh->prepare($query);
for ( $i = 0; $i < count($keys); $i++ ) {
    $state = $sth->bindParam(':'.$keys[$i], $_POST[$keys[$i]]);
}
$state = $sth->execute();
if ( $state ) {
    echo true;
} else {
    echo false;
}
?>