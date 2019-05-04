<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}


class Members
{

    public $data = [];
    public $Model;

    public function __construct()
    {
        $this->Model = new Members_model();

        // view 에서 사용할 data 준비
        $this->data['title'] = '회중성원';
    }

    public function home()
    {
        $results = $this->Model->getUsers();
        $this->data['members'] = $results;

        // view 가져오기
        include('./views/members_home.php');
    }

}
