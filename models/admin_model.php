<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

class Admin_model
{
    public function __construct() 
    {
        include_once("dbConnection.php");
    }

    public function addMap($data)
    {
        $dbh = dbConnection();


        $query = 'insert into maps (map_name, map_number, map_use) values (:name,:number,1);';
        $sth = $dbh->prepare($query);
        $state = $sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $state = $sth->bindParam(':number', $data['number'], PDO::PARAM_STR);
        $state = $sth->execute();
        if ( $state ) {
            return true;
        } else {
            return false;
        }
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
        $state = $sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $state = $sth->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $state = $sth->bindParam(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $state = $sth->bindParam(':male', $data['male'], PDO::PARAM_INT);
        $state = $sth->bindParam(':position', $data['position'], PDO::PARAM_INT);
        $state = $sth->bindParam(':pioneer', $data['pioneer'], PDO::PARAM_INT);
        $state = $sth->bindParam(':privileges', $data['privileges'], PDO::PARAM_INT);
        $state = $sth->execute();
        if ( $state ) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteMap($map_id)
    {
        $query = 'delete from maps where map_id = '.$map_id.';';

        $dbh = dbConnection();
        $state = $dbh->exec($query);
        if ( $state ) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($user_id)
    {
        $query = 'delete from users where user_id = '.$user_id.';';

        $dbh = dbConnection();
        $state = $dbh->exec($query);
        if ( $state ) {
            return true;
        } else {
            return false;
        }
    }

    public function getMap($map_id) 
    {
        $dbh = dbConnection();
        $sth = $dbh->query('select * from maps where map_id = '.$map_id.';');
        $count = $sth->rowCount();
        if ($count) {
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $results[0];
        } else {
            return false;
        }
    }

    public function getMaps() 
    {
        $dbh = dbConnection();
        $sth = $dbh->query('select * from maps order by map_number asc;');
        $count = $sth->rowCount();
        if ($count) {
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } else {
            return false;
        }
    }

    public function getUser($user_id) 
    {
        $dbh = dbConnection();
        $sth = $dbh->query('select * from users where user_id = '.$user_id.';');
        $count = $sth->rowCount();
        if ($count) {
            $results = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $results[0];
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

    public function updateMap($data, $map_id)
    {
        $dbh = dbConnection();

        $query = 'update maps set map_name = :name, map_number = :number where map_id = :id';
        $sth = $dbh->prepare($query);
        $state = $sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
        $state = $sth->bindParam(':number', $data['number'], PDO::PARAM_STR);
        $state = $sth->bindParam(':id', $map_id, PDO::PARAM_INT);
        $state = $sth->execute();
        if ( $state ) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUser($data, $user_id)
    {
        $dbh = dbConnection();
        
        (isset($data['position']) ? :$data['position'] = 0);
        (isset($data['pioneer']) ? :$data['pioneer'] = 0);
        $password_query = strlen($data['password']) > 3 ? ', user_password = password(:password) ' : ' ';

        $query = 'update users set user_name = :name, user_phone_number = :phone_number, '
            .'user_male = :male, user_position = :position, user_pioneer = :pioneer, '
            .'user_privileges = :privileges'.$password_query.'where user_id = :id';
        $sth = $dbh->prepare($query);
        $state = $sth->bindParam(':name', $data['name'], PDO::PARAM_STR);
        if (strlen($data['password']) > 3) $state = $sth->bindParam(':password', $data['password'], PDO::PARAM_STR);
        $state = $sth->bindParam(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $state = $sth->bindParam(':male', $data['male'], PDO::PARAM_INT);
        $state = $sth->bindParam(':position', $data['position'], PDO::PARAM_INT);
        $state = $sth->bindParam(':pioneer', $data['pioneer'], PDO::PARAM_INT);
        $state = $sth->bindParam(':privileges', $data['privileges'], PDO::PARAM_INT);
        $state = $sth->bindParam(':id', $user_id, PDO::PARAM_INT);
        $state = $sth->execute();
        if ( $state ) {
            return true;
        } else {
            return false;
        }
    }
}
