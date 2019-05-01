<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}


class Members
{

    public $data = [];
    public $Model;

    public function __construct()
    {
        $this->Model = new Members_model();

        $results = $this->Model->getUsers();

        // view 에서 사용할 data 준비
        $this->data['title'] = '회중성원';
        $this->data['members'] = $results;
    }

    public function home()
    {
        // view 가져오기
        include('./views/membersHome.php');
    }

}
