<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

/*
 *  model 로드
 */
require_once('./models/Home.php');
$Home = new Home();
/*
 *  model 로드 끝
 */

if (!isset(URI[1])) { // function 호출이 없을 때
    // view 에서 사용할 data 준비
    $data['title'] = '야외봉사';
    $data['maps'] = $Home->getMaps();

    // view 가져오기
    include('./views/home.php');  // html 문서 본문부분 추가
} else {
    if (isset(URI[2])) {
        URI[1](URI[2]);
    } else {
        URI[1]();
    }
}