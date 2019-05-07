<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/templates/404.php');exit;}

// $data['maps'] 변수에 배열로 구역 정보가 건너옴

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
                                <a href='/admin/updatecard/{$item['map_id']}/' class='btn btn-primary btn-sm'>수정</a>
                                <button type='button' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#modal{$item['map_id']}'>삭제</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class='modal fade' id='modal{$item['map_id']}' tabindex='-1' role='dialog' aria-labelledby='modal{$item['map_id']}Label' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>{$item['map_number']} {$item['map_name']}</h5>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>
                        <div class='modal-body'>
                            <p>삭제하시겠습니까?</p>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>취소</button>
                            <a href='/admin/deletecard/{$item['map_id']}/' class='btn btn-danger'>삭제</a>
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