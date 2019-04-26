<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

// $data['members'] 변수에 배열로 사람들 정보가 건너옴
// 초기 변수 설정 넘어온 번호가 무슨 의미인지 확인
$male = array(0=>'자매',1=>'형제');
$position = array(0=>'',1=>'장로',2=>'봉종');
$pioneer = array(0=>'',1=>'파이오니아');

include('./views/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class='container'>
<?php
include('./views/navbar.php');
?>

        <!-- 여기부터는 구성원 목록입니다.-->
        <div class='container py-3'><div class='row'>

<?php
(is_array($class->data['members']) ? $outputHtml = array_reduce($class->data['members'],
    function ($carry, $item) use ($male,$position,$pioneer) 
    {
        $carry .= "
            <div class='col-md-6 col-lg-4 mb-3'>
                <div class='card border-primary rounded' id='{$item['user_id']}'>
                    <div class='card-body'>
                        <h5 class='card-title'>
                            {$item['user_name']} {$male[$item['user_male']]}
                        </h5>
                        <h6 class='card-subtitle mb-2 text-muted'>{$item['user_phone_number']}</h6>
                        <!-- <p>{$position[$item['user_position']]} {$pioneer[$item['user_pioneer']]}</p> -->
                    </div>
                </div>
            </div>";
        return $carry;
    }
) : $outputHtml = '');
echo $outputHtml;
?>
        </div></div>
<?php
include('./views/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>