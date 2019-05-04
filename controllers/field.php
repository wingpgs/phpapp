<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}


class Field
{
    public $data = [];
    public $Model;

    public function __construct()
    {
        $this->Model = new Field_model();

        // view 에서 사용할 data 준비
        $this->data['title'] = '구역 카드';
    }

    public function home($card_id)
    {
        include('./views/field_home.php');  // html 문서 본문부분 추가
    }

    public function getHouses()
    {
        echo $this->Model->getHouses();
    }

    public function insert()
    {
        echo $this->Model->insert();
    }

    public function update()
    {
        echo $this->Model->update();
    }

    public function delete()
    {
        echo $this->Model->delete();
    }
}