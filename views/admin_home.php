<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

include('./views/templates/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class="container">

<?php
include('./views/templates/navbar.php');
?>
        <div class='py-2'>
            <div class="alert<?php echo isset($_POST['style']) ? ' '.$_POST['style']: '';
                echo isset($_POST['message']) ? '': ' d-none'?>" role="alert">
                <?=$_POST['message']?>
            </div>


            <div class="text-center">
                <a class="btn btn-primary" href="/admin/addmember/" role="button">구성원추가</a>
                <a class="btn btn-primary" href="/admin/listmember/" role="button">구성원관리</a>
                <a class="btn btn-primary" href="/admin/addcard/" role="button">구역추가</a>
                <a class="btn btn-primary" href="/admin/listcard/" role="button">구역관리</a>
                <a class="btn btn-primary" href="/try/" role="button">테스트코드</a>
                <a class="btn btn-primary" href="/admin/logout/" role="button">Logout</a>
            </div>
        </div>
<?php
include('./views/templates/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>