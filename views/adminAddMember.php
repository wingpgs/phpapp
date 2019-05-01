<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

// $data['members'] 변수에 배열로 사람들 정보가 건너옴
// 초기 변수 설정 넘어온 번호가 무슨 의미인지 확인

include('./views/header.php');  // html 문서 시작부분 추가
?>
    </head>
    <body class='container'>
<?php
include('./views/navbar.php');
?>

        <!-- 여기부터는 내용입니다.-->
        <div class='container py-3'>
            <p class='h6 mb-3'>아래 <span style='color:#dc3545'>빨간색</span> 칸들을 모두 입력하고 확인을 누르세요...</p>
            <form class='was-validated' action='/admin/addMemberSubmit/' method='post'>
                <div class='form-group'>
                    <input id='user_name' class='form-control' name='name' type='text' placeholder='이름' required>
                    <div class='valid-feedback'>이름</div>
                    <div class='invalid-feedback'>이름을 입력하세요...</div>
                </div>
                
                <div class='form-group'>
                    <input id='user_password' class='form-control' name='password' type='text' placeholder='비밀번호' required>
                    <div class='valid-feedback'>비밀번호</div>
                    <div class='invalid-feedback'>초기비밀번호는 휴대전화번호 뒷 4자리로 설정하세요...</div>
                </div>
                
                <div class='form-group'>
                    <input id='user_phone_number' class='form-control' name='phone' type='text' placeholder='휴대전화번호' required>
                    <div class='valid-feedback'>휴대전화번호</div>
                    <div class='invalid-feedback'>휴대전화번호을 입력하세요...</div>
                </div>
                
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="brother" name="gender" value='brother' required>
                    <label class="custom-control-label" for="brother">형제</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" class="custom-control-input" id="sister" name="gender" value='sister' required>
                    <label class="custom-control-label" for="sister">자매</label>
                    <div class="invalid-feedback">형제/자매 선택하세요...</div>
                </div>
                
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="position1" name="position" value='elder' disabled>
                    <label class="custom-control-label" for="position1">장로</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" class="custom-control-input" id="position2" name="position" value='servent' disabled>
                    <label class="custom-control-label" for="position2">봉사의 종</label>
                </div>
                
                <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" class="custom-control-input" id="pioneer" name='pioneer' value='pioneer'>
                    <label class="custom-control-label" for="pioneer">파이오니아</label>
                </div>
                
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="privilege1" name="privilege" value='1' required>
                    <label class="custom-control-label" for="privilege1">수정/관리/야외봉사</label>
                </div>
                <div class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" id="privilege2" name="privilege" value='2' required>
                    <label class="custom-control-label" for="privilege2">관리/야외봉사</label>
                </div>
                <div class="custom-control custom-radio mb-3">
                    <input type="radio" class="custom-control-input" id="privilege3" name="privilege" value='0' required>
                    <label class="custom-control-label" for="privilege3">야외봉사</label>
                    <div class="invalid-feedback">어떤 권한을 가질지 선택하세요...</div>
                </div>

                <button type='submit' class='btn btn-primary'>확인</button>
            </form>
        </div>
<?php
include('./views/footer.php');  // html 문서 끝부분 추가
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