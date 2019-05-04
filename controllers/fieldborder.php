<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}


class FieldBorder
{
    public $data = [];
    public $Model;

    public function __construct()
    {
        // view 에서 사용할 data 준비
        $this->data['title'] = '구역 경계';
    }

    public function home()
    {
        // view 가져오기
        include('./views/fieldborder_home.php');
    }
}
