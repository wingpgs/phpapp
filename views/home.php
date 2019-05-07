<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

// $data['maps'] 변수에 배열로 구역 정보가 건너옴
// 초기 변수 설정 넘어온 번호가 무슨 의미인지 확인

include('./views/templates/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class="container">

<?php
include('./views/templates/navbar.php');


?>

        <div class='container py-3'><div class='row'>

<?php
(is_array($this->data['maps']) ? $outputHtml = array_reduce($this->data['maps'],
    function ($carry, $item)
    {
        $carry .= "
            <div class='col-md-6 col-lg-4 mb-3'>
                <div class='card border-primary rounded' id='{$item['map_id']}'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$item['map_number']}</h5>
                        <h6 class='card-subtitle mb-2 text-muted'>{$item['map_name']}</h6>
                        <div class='d-flex justify-content-end'>
                            <div class=''>
                                <a href='/field/home/{$item['map_id']}/{$item['map_name']}/' class='btn btn-primary btn-sm'>이동</a>
                            </div>
                        </div>
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
include('./views/templates/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>