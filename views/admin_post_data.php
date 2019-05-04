<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}


    // alert 색상 설정
    $alert_style = [];
    $alert_style['red'] = 'alert-danger';
    $alert_style['blue'] = 'alert-primary';
    $alert_style['grey'] = 'alert-secondary';
    $alert_style['green'] = 'alert-success';
    $alert_style['yellow'] = 'alert-warning';


    /*  사용 예제 ㅎㅎ
        $this->data['post_data_uri'] = '/admin/';
        if ($result) {
            $this->data['post_data_style'] = 'blue';
            $this->data['post_data_message'] = '<strong>'.$_POST['name'].'</strong> 입력했습니다.';
        } else {
            $this->data['post_data_style'] = 'red';
            $this->data['post_data_message'] = '<strong>'.$_POST['name'].'</strong> 입력에 실패했습니다..';
        }
        include('./views/adminPostData.php');

    */

?>

<form name='postmessage' action='<?=$this->data['post_data_uri']?>' method='POST'>
    <input type='hidden' name='style' value='<?=$alert_style[$this->data['post_data_style']]?>'>
    <input type='hidden' name='message' value='<?=$this->data['post_data_message']?>'>
</form>
<script type='text/javascript'>
    document.postmessage.submit();
</script>