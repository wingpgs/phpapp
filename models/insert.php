<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

require_once('dbConnection.php');        
$dbh = dbConnection();
 
if ( isset($_POST['building_id']) ) { // 기존 건물이 있을 때
    $query = 'insert into houses (map_id,building_id,house_name,house_status) '
        .'values (:map_id,:building_id,:house_name,:house_status);';
    $sth = $dbh->prepare($query);
    $state = $sth->bindParam(':map_id', $_POST['map_id']);
    $state = $sth->bindParam(':building_id', $_POST['building_id']);
    $state = $sth->bindParam(':house_name', $_POST['house_name']);
    $state = $sth->bindParam(':house_status', $_POST['house_status']);
    $state = $sth->execute();
    if ( $state ) {
        $house_id = $dbh->lastInsertId();
    } else {
        echo 'false';
        exit;
    }
} else { // 기존 건물이 없을 때
    $query = 'insert into buildings (map_id,building_address,building_latitude,building_longitude) '
        .'values (:map_id,:building_address,:building_latitude,:building_longitude);';
    $sth = $dbh->prepare($query);
    $state = $sth->bindParam(':map_id', $_POST['map_id']);
    $state = $sth->bindParam(':building_address', $_POST['building_address']);
    $state = $sth->bindParam(':building_latitude', $_POST['building_latitude']);
    $state = $sth->bindParam(':building_longitude', $_POST['building_longitude']);
    $state = $sth->execute();
    if ( $state ) {
        $building_id = $dbh->lastInsertId();
    } else {
        echo 'false';
        exit;
    }
    
    $query = 'insert into houses (map_id,building_id,house_name,house_status) '
        .'values (:map_id,:building_id,:house_name,:house_status);';
    $sth = $dbh->prepare($query);
    $state = $sth->bindParam(':map_id', $_POST['map_id']);
    $state = $sth->bindParam(':building_id', $building_id);
    $state = $sth->bindParam(':house_name', $_POST['house_name']);
    $state = $sth->bindParam(':house_status', $_POST['house_status']);
    $state = $sth->execute();
    if ( $state ) {
        $house_id = $dbh->lastInsertId();
    } else {
        echo 'false';
        exit;
    }
}


$query = 'select a.map_id,a.building_id,a.building_address,b.house_name,b.house_status,'.
    'b.house_date,b.house_date2,b.house_date3,a.building_latitude,a.building_longitude,b.house_id '.
    'from buildings a inner join houses b on a.building_id = b.building_id '.
    'where b.house_id = '.$house_id.';';

$sth = $dbh->query($query);
$count = $sth->rowCount();
if ($count) {
    $results = $sth->fetchAll(PDO::FETCH_ASSOC);
    $i = json_encode($results);
    print_r($i);
} else {
    echo 'false';
}
?>