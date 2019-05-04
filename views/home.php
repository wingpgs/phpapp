<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

// $data['maps'] 변수에 배열로 구역 정보가 건너옴
// 초기 변수 설정 넘어온 번호가 무슨 의미인지 확인
$male = array(0=>'자매',1=>'형제');
$position = array(0=>'',1=>'장로',2=>'봉종');
$pioneer = array(0=>'',1=>'파이오니아');

include('./views/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class="container">

<?php
include('./views/navbar.php');


?>

        <div class='container py-3'><div class='row'>

<?php
(is_array($this->data['maps']) ? $outputHtml = array_reduce($this->data['maps'],
    function ($carry, $item) use ($male)
    {
        $carry .= "
            <div class='col-md-6 col-lg-4 mb-3'>
                <div class='card border-primary rounded' id='{$item['map_id']}'>
                    <h5 class='card-header'>
                        {$item['map_name']}
                    </h5>
                    <div class='card-body text-right'>
                        <a href='/field/home/{$item['map_id']}/{$item['map_name']}/' class='card-link'>
                            이동
                        </a>
                    </div>
                </div>
            </div>";
        return $carry;
    }
) : $outputHtml = '');
echo $outputHtml;
//print_r($data['maps']);
?>

        </div></div>
<?php
include('./views/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>