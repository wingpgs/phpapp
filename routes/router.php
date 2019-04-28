<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

// favicon.ico 요청 처리 우선 해야 함..
if ($_SERVER['REQUEST_URI'] == '/favicon.ico') {
    include('./views/204.php');
    exit;
}
/*
 * 여기부터 시험을 위한 요청 처리
 */


// 여기까지 시험을 위한 요청 처리

/*
 * 여기부터 라우팅 테이블 입력
 */
$routingTable = [
    '테스트'                 => './test/test.php',  // 이거 테스트 목적임 나중에 삭제 해야함
    'field'                 => './views/field.php',
    'getmaps'               => './models/getmaps.php',
    'gethouses'             => './models/gethouses.php',
    'update'                => './models/update.php',
    'insert'                => './models/insert.php',
    'delete'                => './models/delete.php',
    'logout'                => './models/logout.php',
    'mcfield'               => './controllers/Mcfield.php',
    'home'                  => './controllers/Home.php',
    'members'               => './controllers/Members.php',
    'admin'                 => './controllers/Admin.php'
];
// 여기까지 라우팅 테이블 입력

// 자동 로그인 체크 함수 include
session_start();
require_once('./models/autoLoginCheck.php');
$loginChecked = autoLoginCheck();

if ($loginChecked) { // 자동 로그인 체크 성공
    switch ($_SERVER['REQUEST_URI'])
    {
        case '/': 
            header('location: /Home/', true, 301); break;
        default :
            $uri0 = URI[0];
            $class = new $uri0();
            if (!isset(URI[1])) { // function 호출이 없을 때
                // view 가져오기
                if(array_key_exists('view',$class->data)) {
                    include($class->data['view']);  // html 문서 본문부분 추가
                }
            } else {
                $uri1 = URI[1];
                if (isset(URI[2])) {
                    $uri2 = URI[2];
                    $uri1($uri2);
                } else {
                    $uri1();
                }
            }
        
            //echo URI[0];

            // // 요청 uri와 라우팅 테이블 비교, 일치하는 값이 있으면 가져옴
            // $route = array_filter($routingTable, function ($key) {
            //     return $key == URI[0];
            // }, ARRAY_FILTER_USE_KEY);
            
            // // 받아온 위치가 있으면 글로 보내고 없으면 404 메세지 출력 
            // if ($route) {
            //     include($route[URI[0]]);
            // } else {
            //     include('./views/404.php');
            // }
    }
} else { // 자동 로그인 체크 실패
    switch ($_SERVER['REQUEST_URI']) 
    {
        case '/': // login 실패 했으므로 login 페이지로
            include('./views/login.php');
            break;
        case '/test/': // test
            include('./test/test.php');
            break;
        case '/logincheck/': // logincheck
            include('./models/logincheck.php');
            break;
        default:
            // // 요청 uri와 라우팅 테이블 비교, 일치하는 값이 있으면 가져옴
            // $route = array_filter($routingTable, function ($key) {
            //     return $key == URI[0];
            // }, ARRAY_FILTER_USE_KEY);

            // // 받아온 위치가 있으면 로그인 페이지로 보내고 없으면 404 메세지 출력
            // if ($route) {  
            //     header('location: /', true, 301);
            // } else {
            //     include('./views/404.php');
            // }
    }
}
?>