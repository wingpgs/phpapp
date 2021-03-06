<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

// $data['members'] 변수에 배열로 사람들 정보가 건너옴
// 초기 변수 설정 넘어온 번호가 무슨 의미인지 확인
$male = array(0=>'자매',1=>'형제');
$position = array(0=>'',1=>'장로',2=>'봉종');
$pioneer = array(0=>'',1=>'파이오니아');

include('./views/templates/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class='container'>
<?php
include('./views/templates/navbar.php');
?>

        <!-- 여기부터는 구성원 목록입니다.-->
        <div class='container py-3'><div class='row'>

<?php
(is_array($this->data['members']) ? $outputHtml = array_reduce($this->data['members'],
    function ($carry, $item) use ($male,$position,$pioneer) 
    {
        $carry .= "
            <!-- Card -->
            <div class='col-md-6 col-lg-4 mb-3'>
                <div class='card border-primary rounded' id='{$item['user_id']}'>
                    <div class='card-body'>
                        <h5 class='card-title'>
                            {$item['user_name']} {$male[$item['user_male']]}
                        </h5>
                        <div class='d-flex justify-content-between'>
                            <h6 class='card-subtitle mb-0 text-muted'>{$item['user_phone_number']}</h6>
                            <div class=''>
                                <a href='/admin/updatemember/{$item['user_id']}/' class='btn btn-primary btn-sm'>수정</a>
                                <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modal{$item['user_id']}'>삭제</button>
                            </div>
                            <!-- <p>{$position[$item['user_position']]} {$pioneer[$item['user_pioneer']]}</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class='modal fade' id='modal{$item['user_id']}' tabindex='-1' role='dialog' aria-labelledby='modal{$item['user_id']}Label' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>{$item['user_name']} <small>{$male[$item['user_male']]}</small></h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <p>삭제하시겠습니까?</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>취소</button>
                            <a href='/admin/deletemember/{$item['user_id']}/' class='btn btn-danger'>삭제</a>
                        </div>
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
include('./views/templates/footer.php');  // html 문서 끝부분 추가
?>
    </body>
</html>