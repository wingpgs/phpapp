<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

require_once("dbConnection.php");

$name=$_POST['name'];
$password=$_POST['password'];
$dbh = dbConnection();
$query = 'select * from users where user_name = :name and user_password = password(:password);';
$sth = $dbh->prepare($query);
$sth->bindParam(':name', $name, PDO::PARAM_STR);
$sth->bindParam(':password', $password, PDO::PARAM_STR);
$sth->execute();

$count = $sth->rowCount();
print_r( $count );
if ( $count ) 
{
    session_start();
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user_name'] = $row['user_name'];
    $_SESSION['user_privileges'] = $row['user_privileges'];
    if ( isset($_POST['autologin']) ) { // 자동 로그인 데이터 입력 user_id, identifier, token, user_agent
        // 먼저 이전에 자동로그인 되어 있던 기기에서 자동로그인 취소
        $query = 'delete from token where user_id = :user_id';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':user_id', $row['user_id']);
        $sth->execute();
        // 이제 토큰 생성 토큰 입력
        $token = bin2hex(random_bytes(64)); $identifier = bin2hex(random_bytes(64)); // token 생성
        $i = strpos($_SERVER['HTTP_USER_AGENT'],'(') + 1;
        $y = strpos($_SERVER['HTTP_USER_AGENT'],')');
        $agent = substr($_SERVER['HTTP_USER_AGENT'], $i , $y - $i);
        $query = "insert into token (user_id, identifier, token, user_agent) values (:id, :identifier, :token, :agent);";
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $row['user_id']);
        $sth->bindParam(':identifier', $identifier);
        $sth->bindParam(':token', $token);
        $sth->bindParam(':agent', $agent);
        $sth->execute();
        $_SESSION['token_id'] = $dbh->lastInsertId();
        // 쿠키에 토큰 저장
        $i = implode(',',array($identifier,$token));
        setcookie('token', $i, time()+30*24*60*60, '/');
    }
    header("Location: /home/", true, 301);
    exit();
} else {
    echo "<script>alert('등록된 이름이 아니거나 비밀번호가 다릅니다.');";
    echo "document.location.href='/';</script>";
}
?>