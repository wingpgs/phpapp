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
            <p class='h6 mb-3'>내용들을 수정하고 <span class='text-primary'>확인</span>을 누르세요...</p>
            <form class='was-validated' action='/admin/updateMemberSubmit/<?=$user_id?>' method='post' autocomplete='off'>
                <div class='form-group'>
                    <input id='user_name' class='form-control' value='<?=$this->data['member']['user_name']?>'
                        name='name' type='text' placeholder='이름' required>
                    <div class='valid-feedback'>이름</div>
                    <div class='invalid-feedback'>이름을 입력하세요...</div>
                </div>
                
                <div class='form-group'>
                    <input id='user_password' class='form-control' name='password' type='text' placeholder='비밀번호'>
                    <div class='valid-feedback'>임시비밀번호는 휴대전화번호 뒷 4자리로 설정하세요...</div>
                </div>
                
                <div class='form-group'>
                    <input id='user_phone_number' class='form-control' value='<?=$this->data['member']['user_phone_number']?>'
                        name='phone_number' type='text' placeholder='휴대전화번호' required>
                    <div class='valid-feedback'>휴대전화번호</div>
                    <div class='invalid-feedback'>휴대전화번호을 입력하세요...</div>
                </div>
                
                <div class="custom-control custom-radio">
                    <input type="radio" <?=$this->data['member']['user_male']==1 ? 'checked' : ''?>
                        class="custom-control-input" id="brother" name="male" value='1' required>
                    <label class="custom-control-label" for="brother">형제</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" <?=$this->data['member']['user_male']==0 ? 'checked' : ''?>
                        class="custom-control-input" id="sister" name="male" value='0' required>
                    <label class="custom-control-label" for="sister">자매</label>
                    <div class="invalid-feedback">형제/자매 선택하세요...</div>
                </div>
                
                <div class="custom-control custom-radio">
                    <input type="radio" <?=$this->data['member']['user_position']==1 ? 'checked' : ''?>
                        class="custom-control-input" id="position1" name="position" value='1'
                        <?=$this->data['member']['user_male']==1 ? '' : 'disabled'?>>
                    <label class="custom-control-label" for="position1">장로</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" <?=$this->data['member']['user_position']==2 ? 'checked' : ''?>
                        class="custom-control-input" id="position2" name="position" value='2' 
                        <?=$this->data['member']['user_male']==1 ? '' : 'disabled'?>>
                    <label class="custom-control-label" for="position2">봉사의 종</label>
                </div>
                
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" <?=$this->data['member']['user_pioneer']==1 ? 'checked' : ''?>
                        class="custom-control-input" id="pioneer" name='pioneer' value='1'>
                    <label class="custom-control-label" for="pioneer">파이오니아</label>
                </div>
                
                <div class="custom-control custom-radio">
                    <input type="radio" <?=$this->data['member']['user_privileges']==1 ? 'checked' : ''?>
                        class="custom-control-input" id="privilege1" name="privileges" value='1' required>
                    <label class="custom-control-label" for="privilege1">수정/관리/야외봉사</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" <?=$this->data['member']['user_privileges']==2 ? 'checked' : ''?>
                        class="custom-control-input" id="privilege2" name="privileges" value='2' required>
                    <label class="custom-control-label" for="privilege2">관리/야외봉사</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" <?=$this->data['member']['user_privileges']==0 ? 'checked' : ''?>
                        class="custom-control-input" id="privilege3" name="privileges" value='0' required>
                    <label class="custom-control-label" for="privilege3">야외봉사</label>
                    <div class="invalid-feedback">어떤 권한을 가질지 선택하세요...</div>
                </div>

                <button type='submit' class='btn btn-primary'>확인</button>
                <a href='/admin/memberlist/' class='btn btn-secondary'>취소</a>
            </form>
        </div>
<?php
include('./views/templates/footer.php');  // html 문서 끝부분 추가
?>
    <script>
        $('#brother').click(function(){
            $('#position1').removeAttr('disabled');
            $('#position2').removeAttr('disabled');
        });
        $('#sister').click(function(){
            $('#position1').prop('checked',false).attr({disabled:'true'});
            $('#position2').prop('checked',false).attr({disabled:'true'});
        });
    </script>
    </body>
</html>