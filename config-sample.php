<?php
// 에러 로그 web으로 출력하기 출처: http://jhrun.tistory.com/198 [JHRunning]
error_reporting(E_ALL);
ini_set("display_errors", 1);

/** 여기에 DB 관련 환경설정 값이 입력됨 */
define('DATABASENAME','php');
define('DATABASEUSERNAME','php');
define('DATABASEUSERPASSWORD','php');

// 여기는 URI 분리 저장 URI 상수
define('URI', explode('/', urldecode(trim($_SERVER['REQUEST_URI'], '/'))));

// Example to auto-load class files from multiple directories using the SPL_AUTOLOAD_REGISTER method.
// It auto-loads any file it finds starting with class.<classname>.php (LOWERCASE), eg: class.from.php, class.db.php
spl_autoload_register(function($class_name) {

    // Define an array of directories in the order of their priority to iterate through.
    $dirs = array(
        './controllers/',  // 컨트롤러 폴더
        './models/' // 모델 폴더
    );

    // Looping through each directory to load all the class files. It will only require a file once.
    // If it finds the same class in a directory later on, IT WILL IGNORE IT! Because of that require once!
    foreach( $dirs as $dir ) {
        if (file_exists($dir.strtolower($class_name).'.php')) {
            require_once($dir.strtolower($class_name).'.php');
            return;
        }
    }
    include('./views/404.php');exit;
});
