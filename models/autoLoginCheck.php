<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

function autoLoginCheck() {
    
    // 먼저 session 확인 해서 세션 존재하면 바로 로그인
    if ( isset($_SESSION['user_name']) ) {
        return true;
    }

    // session이 없으면 token 테이블에 토큰을 cookie에 토큰과 확인해서 일치하면 로그인
    if ( isset($_COOKIE['token']) ) {
        require_once("dbConnection.php");
        list($identifier, $token) = explode(',', $_COOKIE['token']);
        // 여기서 식별자 분리해서 데이터 베이스 검색함.
        $query = 'select * from token where identifier = :identifier;';
        $dbh = dbConnection();
        $sth = $dbh->prepare($query);
        $sth->bindParam(':identifier', $identifier);
        $sth->execute();

        while ($result = $sth->fetch(PDO::FETCH_ASSOC))
        {
            // 만약 토큰이 일치하면 아래의 작업 수행
            if ($token == $result['token']) {
                $tokenId = $result['token_id'];
                // 사용자 정보 가져와서 session 생성
                $sth = $dbh->query('select * from users where user_id = '.$result['user_id']);
                $result = $sth->fetch(PDO::FETCH_ASSOC);
                $_SESSION['token_id'] = $tokenId;
                $_SESSION['user_name'] = $result['user_name'];
                $_SESSION['user_privileges'] = $result['user_privileges'];
                // 새로운 토큰 생성, 데이터베이스에 입력
                $newToken = bin2hex(random_bytes(64)); // 새로운 token 생성
                $sth = $dbh->prepare('update token set token = :newToken where token_id = :tokenId;');
                $sth->bindParam(':newToken', $newToken);
                $sth->bindParam(':tokenId', $tokenId);
                $sth->execute();
                $i = implode(',',array($identifier,$newToken)); // cookie 재설정
                setcookie('token', $i, time()+30*24*60*60, '/');
                return true;
            }
        }
        // identifier 가 일치하고 token 이 일치하지 않으면 토큰 도난 당한 것임 하지만 그경우는 구현하지 않음.
    }
    return false;
}


?>