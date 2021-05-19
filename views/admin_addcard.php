<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

// $data['members'] 변수에 배열로 사람들 정보가 건너옴
// 초기 변수 설정 넘어온 번호가 무슨 의미인지 확인

include('./views/templates/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class='container'>
<?php
include('./views/templates/navbar.php');
?>

        <!-- 여기부터는 내용입니다.-->
        <div class='container py-3'>
            <p class='h6 mb-3'>아래 <span style='color:#dc3545'>빨간색</span> 칸들을 모두 입력하고 <span class='text-primary'>확인</span>을 누르세요...</p>
            <form class='was-validated' action='/admin/addCardSubmit/' method='post' autocomplete='off'>
                <div class='form-group'>
                    <input id='map_number' class='form-control' name='number' type='text' placeholder='구역번호' required>
                    <div class='valid-feedback'>구역번호</div>
                    <div class='invalid-feedback'>구역번호을 입력하세요...</div>
                </div>
                <div class='form-group'>
                    <input id='map_name' class='form-control' name='name' type='text' placeholder='구역명' required>
                    <div class='valid-feedback'>구역명</div>
                    <div class='invalid-feedback'>구역명을 입력하세요...</div>
                </div>
                <button type='submit' class='btn btn-primary'>확인</button>
            </form>
        </div>
<?php
include('./views/templates/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>