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
    }

    public function addMember ()
    {
        // data 준비
        $this->data['title'] = '구성원추가';

        // view 가져오기
        include('./views/admin_add_member.php');
    }

    public function addMemberSubmit ()
    {
        $result = $this->Model->addUser($_POST);
        $this->data['post_data_uri'] = '/admin/';
        if ($result) {
            $this->data['post_data_style'] = 'blue';
            $this->data['post_data_message'] = '<strong>'.$_POST['name'].'</strong> 입력했습니다.';
        } else {
            $this->data['post_data_style'] = 'red';
            $this->data['post_data_message'] = '<strong>'.$_POST['name'].'</strong> 입력에 실패했습니다..';
        }
        include('./views/admin_post_data.php');
    }

    public function home()
    {
        // view 가져오기
        include('./views/admin_home.php');
    }

    public function logout ()
    {
        $this->Model->logout();

        echo '<meta http-equiv="refresh" content="0;url=/" />';
    }

    public function updateMember ()
    {
        // data 준비
        $this->data['title'] = '구성원수정';

        // view 가져오기
        include('./views/admin_update_member.php');
    }

}