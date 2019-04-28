<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}


class FieldBorder
{
    public $data = [];
    public $Model;

    public function __construct()
    {

        // view 에서 사용할 data 준비
        $this->data['title'] = '구역 경계';

        // view 경로 지정
        $this->data['view'] = './views/fieldborder.php';
    }
}
