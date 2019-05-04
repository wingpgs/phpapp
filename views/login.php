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
        
        <title>야외봉사</title>
        <!-- 안드로이드 홈화면추가시 상단 주소창 제거 -->
    	<meta name="mobile-web-app-capable" content="yes">
	    <!-- ios홈화면추가시 상단 주소창 제거 -->
	    <meta name="apple-mobile-web-app-capable" content="yes">
        
        <link rel="shortcut icon" href="/public/img/img.png" />
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/public/img/img.png" />
        <link rel="icon" href="/public/img/img.png" />

        <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <!-- Custom styles for this template -->
        <link href="/public/css/login.css" rel="stylesheet">
    </head>
    <body class="text-center">
        <form class="form-signin" method="POST" action="/logincheck/">
            <!-- <img class="mb-4" src="/public/img/img.png" alt="" width="72" height="72"> -->
            <h1 class="h3 mb-5 font-weight-normal text-primary">천안 목천</h1>
            <label for="inputEmail" class="sr-only">이름</label>
            <input autocomplete="off" type="name" name="name" id="inputName" class="form-control" placeholder="이름" required autofocus>
            <label for="inputPassword" class="sr-only">암호</label>
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="암호" required>
            <div class="checkbox mb-3">
                <label>
                <input type="checkbox" name="autologin" value="remember-me"> 기억해주세요.
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">로그인</button>
            <!-- <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p> -->
        </form>
    
        <!-- jquery, popper, bootstrap -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>