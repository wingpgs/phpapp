<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

// favicon.ico 요청 처리 우선 해야 함..
if ($_SERVER['REQUEST_URI'] == '/favicon.ico') {
    include('./views/templates/204.php');
    exit;
}

// 자동 로그인 체크 함수 include
session_start();
require_once('./models/autoLoginCheck.php');
$loginChecked = autoLoginCheck();

if ($loginChecked) { // 자동 로그인 체크 성공
    switch ($_SERVER['REQUEST_URI'])
    {
        case '/':
            header('location: /Home/', true, 301); break;
        case '/try/': // test
            include('./test/test.php');
            break;
        default :
            $uri0 = URI[0];
            $class = new $uri0();
            if (!isset(URI[1])) { // function 호출이 없을 때
                // view 가져오기
                $class->home();
            } else {
                $uri1 = URI[1];
                if (isset(URI[2])) {
                    $uri2 = URI[2];
                    $class->$uri1($uri2);
                } else {
                    $class->$uri1();
                }
            }
    }
} else { // 자동 로그인 체크 실패
    switch ($_SERVER['REQUEST_URI']) 
    {
        case '/': // login 실패 했으므로 login 페이지로
            include('./views/templates/login.php');
            break;
        case '/try/': // test
            include('./test/test.php');
            break;
        case '/logincheck/': // logincheck
            include('./models/logincheck.php');
            break;
        default:
            header('location: /', true, 301);
    }
}
?>