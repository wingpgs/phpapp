<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

/*
 *  model 로드
 */
require_once('./models/Admin.php');
$Admin = new Admin();
/*
 *  model 로드 끝
 */

if (!isset(URI[1])) { // function 호출이 없을 때
    // view 에서 사용할 data 준비
    $data['title'] = '관리';
    
    // view 가져오기
    include('./views/adminHome.php');  // html 문서 본문부분 추가
} else {
    if (isset(URI[2])) {
        URI[1](URI[2]);
    } else {
        URI[1]();
    }
}

function addMember ()
{
    // data 준비
    $data['title'] = '구성원추가';

    // view 가져오기
    include('./views/addMember.php');
}

function updateMember ()
{
    // data 준비
    $data['title'] = '구성원수정';

    // view 가져오기
    include('./views/updateMember.php');
}

function addMemberSubmit ()
{
    //global $Admin;
    $result = $GLOBALS['Admin']->addUser($_POST);
}