<?php
// 에러 로그 web으로 출력하기 출처: http://jhrun.tistory.com/198 [JHRunning]
error_reporting(E_ALL);
ini_set("display_errors", 1);

/** 여기에 DB 관련 환경설정 값이 입력됨 */
define('DATABASENAME','php');
define('DATABASEUSERNAME','php');
define('DATABASEUSERPASSWORD','php');
