<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// 에러 로그 web으로 출력하기 출처: http://jhrun.tistory.com/198 [JHRunning]
define('URI', explode('/', urldecode(trim($_SERVER['REQUEST_URI'], '/'))));
require_once('./routes/router.php');
