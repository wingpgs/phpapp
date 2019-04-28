<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

$navLink = ['home','mcfield','members','admin'];

$active = array_map( function ($value) 
{
    if ( $value == URI[0] ) {
        return ' active';
    } else {
        return '';
    }
},$navLink);
?>
        <!-- 여기는 네비바 이다네요. -->
        <nav class="navbar sticky-top navbar-expand navbar-dark" style="background-color:#666">
            <a href="/home/" class="navbar-brand py-0"><img src="/public/img/img.png" alt="Home" height="35" width="35"></a>
            
            <button class="btn btn-link navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link<?php echo $active[0]?>" href="/home/">홈</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $active[1]?>" href="/fieldborder/">회중구역</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $active[2]?>" href="/members/">회중성원</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo $active[3]?>" href="/admin/">관리</a>
                    </li>
                </ul>
            </div>
        </nav>