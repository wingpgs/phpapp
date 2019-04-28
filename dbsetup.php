<?php
// 데이터 베이스를 완전히 초기화 합니다. 기존의 데이터가 모두 삭제될 수 있습니다.


require_once('./config.php');

$dbh = new PDO('mysql:host=localhost;dbname='.DATABASENAME, DATABASEUSERNAME, DATABASEUSERPASSWORD);

$query = "CREATE TABLE IF NOT EXISTS `users` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_name` varchar(10) NOT NULL,
        `user_password` varchar(45) NOT NULL,
        `user_privileges` tinyint(4) DEFAULT '0',
        `user_phone_number` varchar(15) NOT NULL,
        `user_pioneer` tinyint(4) DEFAULT '0',
        `user_male` tinyint(4) DEFAULT '0',
        `user_position` tinyint(4) DEFAULT '0',
        PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$sth = $dbh->exec($query);

$query = "CREATE TABLE IF NOT EXISTS `token` (
        `user_id` int(11) NOT NULL,
        `identifier` varchar(100) NOT NULL,
        `token` varchar(100) NOT NULL,
        `user_agent` varchar(256) DEFAULT NULL,
        `token_id` bigint(20) NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (`token_id`),
        KEY `user_id` (`user_id`),
        CONSTRAINT `token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$sth = $dbh->exec($query);

$query = "CREATE TABLE IF NOT EXISTS `maps` (
        `map_id` int(11) NOT NULL AUTO_INCREMENT,
        `map_number` smallint(6) DEFAULT NULL,
        `map_name` varchar(100) NOT NULL,
        `map_use` tinyint(4) DEFAULT '0',
        PRIMARY KEY (`map_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$sth = $dbh->exec($query);

$query = "CREATE TABLE IF NOT EXISTS `buildings` (
        `building_id` int(11) NOT NULL AUTO_INCREMENT,
        `building_address` varchar(1000) NOT NULL,
        `building_latitude` varchar(30) DEFAULT NULL,
        `building_longitude` varchar(30) DEFAULT NULL,
        `map_id` int(11) NOT NULL,
        PRIMARY KEY (`building_id`),
        KEY `map_id` (`map_id`),
        CONSTRAINT `buildings_ibfk_1` FOREIGN KEY (`map_id`) REFERENCES `maps` (`map_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$sth = $dbh->exec($query);

$query = "CREATE TABLE IF NOT EXISTS `houses` (
        `house_id` int(11) NOT NULL AUTO_INCREMENT,
        `house_name` varchar(255) DEFAULT NULL,
        `house_status` tinyint(4) DEFAULT '0',
        `house_date` date DEFAULT NULL,
        `house_date2` date DEFAULT NULL,
        `house_date3` date DEFAULT NULL,
        `building_id` int(11) NOT NULL,
        PRIMARY KEY (`house_id`),
        KEY `building_id` (`building_id`),
        CONSTRAINT `houses_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$sth = $dbh->exec($query);

$query = "select count(*) as cnt from users";
$sth = $dbh->query($query);
$count = $sth->fetch(PDO::FETCH_BOTH);
if (!$count[0]) {
    $query = "insert into users (user_name, user_password, user_phone_number, user_male)"
        ." values ('김형제',password('0000'),'010-0000-0000', 1)";
    $sth = $dbh->exec($query);
}
echo '데이터 베이스 설정을 마쳤습니다.';
?>