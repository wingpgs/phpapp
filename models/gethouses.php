<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

require_once('dbConnection.php');        
$query = 'select a.map_id,a.building_id,a.building_address,b.house_name,b.house_status,'.
    'b.house_date,b.house_date2,b.house_date3,a.building_latitude,a.building_longitude,b.house_id '.
    'from buildings a inner join houses b on a.building_id = b.building_id '.
    'where a.map_id = '.$_POST['map_id'].' order by b.building_id asc;';

$dbh = dbConnection();
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