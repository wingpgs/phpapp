<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

include('./views/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class="container">

<?php
include('./views/navbar.php');
?>
        <div class='py-2'>
            <div class="alert alert-success" role="alert">
                A simple success alert—check it out!
            </div>
            <div class="text-center">
                <a class="btn btn-primary" href="/admin/addmember/" role="button">구성원추가</a>
                <a class="btn btn-primary" href="/admin/updatemember/" role="button">구성원수정</a>
                <a class="btn btn-primary" href="/try/" role="button">테스트코드</a>
                <a class="btn btn-primary" href="/admin/logout/" role="button">Logout</a>
            </div>
        </div>
<?php
include('./views/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>