<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

class Admin
{
    public $data = [];
    public $Model;

    public function __construct()
    {
        $this->Model = new Admin_model();

        // view 에서 사용할 data 준비
        $this->data['title'] = '관리';

        // view 경로 지정
        $this->data['view'] = './views/adminHome.php';
    }

    public function addMember ()
    {
        // data 준비
        $data['title'] = '구성원추가';

        // view 가져오기
        include('./views/adminAddMember.php');
    }

    public function updateMember ()
    {
        // data 준비
        $data['title'] = '구성원수정';

        // view 가져오기
        include('./views/adminUpdateMember.php');
    }

    public function addMemberSubmit ()
    {
        //global $Admin;
        $result = $this->Model->addUser($_POST);
    }

    public function logout ()
    {
        $this->Model->logout();

        echo '<meta http-equiv="refresh" content="0;url=/" />';
    }
}