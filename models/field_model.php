<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}


class Field_model
{
    public function __construct() 
    {
        include_once("dbConnection.php");
    }

    public function getHouses()
    {
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
            return $i;
        } else {
            return json_encode(false);
        }
    }

    public function insert()
    {
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
                return json_encode(false);
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
                return json_encode(false);
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
                return json_encode(false);
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
            return $i;
        } else {
            return json_encode(false);
        }
        
    }

    public function update()
    {
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

        $dbh = dbConnection();
        $sth = $dbh->prepare($query);
        for ( $i = 0; $i < count($keys); $i++ ) {
            $state = $sth->bindParam(':'.$keys[$i], $_POST[$keys[$i]]);
        }
        $state = $sth->execute();
        if ( $state ) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }

    public function delete()
    {
        if ( isset($_POST['house_id']) ) {
            $query = 'delete from houses where house_id = '.$_POST['house_id'].';';
        } elseif ( isset($_POST['building_id']) ) {
            $query = 'delete from buildings where building_id = '.$_POST['building_id'].';';
        } else {
            return json_encode(false);
            exit;
        }

        $dbh = dbConnection();
        $state = $dbh->exec($query);
        if ( $state ) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
}