<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}


class Members
{

    public $data = [];
    public $Model;

    public function __construct()
    {
        $Model = new Members_model();

        $results = $Model->getUsers();

        // view 에서 사용할 data 준비
        $this->data['title'] = '회중성원';
        $this->data['members'] = $results;

        // view 경로 지정
        $this->data['view'] = './views/membersHome.php';
    }
}
