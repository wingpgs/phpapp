<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

class Admin_model
{
    public function __construct() 
    {
        include_once("dbConnection.php");
    }

    public function addUser($data)
    {
        $dbh = dbConnection();

        (isset($data['position']) ? :$data['position'] = 0);
        (isset($data['pioneer']) ? :$data['pioneer'] = 0);

        $query = 'insert into users (user_name, user_password, user_phone_number, '
            .'user_male, user_position, user_pioneer, user_privileges) '
            .'values (:name,password(:password),:phone_number,:male,:position,:pioneer,:privileges);';
        $sth = $dbh->prepare($query);
        $state = $sth->bindParam(':name', $data['name']);
        $state = $sth->bindParam(':password', $data['password']);
        $state = $sth->bindParam(':phone_number', $data['phone_number']);
        $state = $sth->bindParam(':male', $data['male']);
        $state = $sth->bindParam(':position', $data['position']);
        $state = $sth->bindParam(':pioneer', $data['pioneer']);
        $state = $sth->bindParam(':privileges', $data['privileges']);
        $state = $sth->execute();
        if ( $state ) {
            return true;
        } else {
            return false;
        }

    }

    public function getUsers() 
    {
        $dbh = dbConnection();
        $sth = $dbh->query('select * from users order by user_name asc;');
        $count = $sth->rowCount();
        if ($count) {
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } else {
            return false;
        }
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
