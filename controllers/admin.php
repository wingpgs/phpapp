<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

class Admin
{
    public $data = [];
    public $Model;

    public function __construct()
    {
        $this->Model = new Admin_model();
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

    public function deleteMember ($user_id)
    {
        // data 준비
        $this->data['title'] = '구성원삭제';

        $result = $this->Model->deleteUser($user_id);

        $this->data['post_data_uri'] = '/admin/';
        if ($result) {
            $this->data['post_data_style'] = 'blue';
            $this->data['post_data_message'] = '삭제했습니다.';
        } else {
            $this->data['post_data_style'] = 'red';
            $this->data['post_data_message'] = '삭제에 실패했습니다..';
        }
        include('./views/admin_post_data.php');
    }

    public function home()
    {
        // view 에서 사용할 data 준비
        $this->data['title'] = '관리';

        // view 가져오기
        include('./views/admin_home.php');
    }

    public function logout ()
    {
        $this->Model->logout();

        echo '<meta http-equiv="refresh" content="0;url=/" />';
    }

    public function memberList ()
    {
        // data 준비
        $this->data['title'] = '구성원목록';

        $results = $this->Model->getUsers();
        $this->data['members'] = $results;

        // view 가져오기
        include('./views/admin_member_list.php');
    }

    public function updateMember ($user_id)
    {
        // data 준비
        $this->data['title'] = '구성원수정';

        $result = $this->Model->getUser($user_id);
        $this->data['member'] = $result;

        // view 가져오기
        include('./views/admin_update_member.php');
    }
    
    public function updateMemberSubmit ($user_id)
    {
        $result = $this->Model->updateUser($_POST,$user_id);
        $this->data['post_data_uri'] = '/admin/';
        if ($result) {
            $this->data['post_data_style'] = 'blue';
            $this->data['post_data_message'] = '<strong>'.$_POST['name'].'</strong> 수정했습니다.';
        } else {
            $this->data['post_data_style'] = 'red';
            $this->data['post_data_message'] = '<strong>'.$_POST['name'].'</strong> 수정에 실패했습니다..';
        }
        include('./views/admin_post_data.php');
    }
}