<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title><?php echo $this->data['title']?></title>
        <!-- 안드로이드 홈화면추가시 상단 주소창 제거 -->
    	<meta name="mobile-web-app-capable" content="yes">
	    <!-- ios홈화면추가시 상단 주소창 제거 -->
	    <meta name="apple-mobile-web-app-capable" content="yes">
        
        <link rel="shortcut icon" href="/public/img/img.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/public/img/img.png" />
        <link rel="icon" href="/public/img/img.png" />

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
