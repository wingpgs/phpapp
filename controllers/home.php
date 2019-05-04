<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}


class Home
{
    public $data = [];
    public $Model;

    public function __construct()
    {
        $this->Model = new Home_model();

        // view 에서 사용할 data 준비
        $this->data['title'] = '야외봉사';
        $this->data['maps'] = $this->Model->getMaps();
    }

    public function home()
    {
        // view 가져오기
        include('./views/home.php');
    }

}