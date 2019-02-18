<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

/*
 *  model 로드
 */

/*
 *  model 로드 끝
 */

if (!isset(URI[1])) { // function 호출이 없을 때
    // view 에서 사용할 data 준비
    $data['title'] = '목천 구역 경계';

    // view 가져오기
    include('./views/mcfield.php');  // html 문서 본문부분 추가
} else {
    switch (URI[1]) 
    {
        case 'insert':
            break;
        case 'update':
            break;
        case 'delete':
            break;
        default :
    }
}
