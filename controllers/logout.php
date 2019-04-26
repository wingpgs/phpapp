<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}


class Logout
{
    public $data = [];
    public $Model;

    public function __construct()
    {
        $Model = new Logout_model();
        $Model->logout();

        echo '<meta http-equiv="refresh" content="0;url=/" />';
    }
}