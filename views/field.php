<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}
?>
<!DOCTYPE html>
<html style="height:100%; overflow:hidden">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>야외봉사</title>
    <!-- 안드로이드 홈화면추가시 상단 주소창 제거 -->
    <meta name="mobile-web-app-capable" content="yes">
    <!-- ios홈화면추가시 상단 주소창 제거 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
        
    <link rel="shortcut icon" href="/public/img/img.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/public/img/img.png" />
    <link rel="icon" href="/public/img/img.png" />

    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
    <link href="/public/css/field.css?ver=6" rel="stylesheet">

  </head>
  <body>
    <div id="main-screen"> <!-- main screen -->
      <nav class="navbar"> <!-- Static navbar -->
        <!--<div id="list-button" class="list-icon">
          <div class="css-bar"></div>
          <div class="css-bar"></div>
          <div class="css-bar"></div>
        </div>-->
        <div id="navbar-logo"><a href="/home/"><img src="/public/img/img.png" alt="Home" height="35" width="35"></a></div>
        <div id="navbar-title"><a href='#' id='card-selection'></a></div>
        <div id="setting-menu-button" class="setting-menu-icon">
          <div class="css-dot"></div>
          <div class="css-dot"></div>
          <div class="css-dot"></div>
        </div>
        <ul id="navbar-menu">
          <li class="navbar-menu-list"><a href="#" id="list-screen-button">목록 보기</a></li>
          <li class="navbar-menu-list"><a href="#" id="map-screen-button">지도 보기</a></li>
        </ul>
      </nav> <!-- Static navbar -->
      <div id="toggle-map-and-list"> <!-- house-list & map-container -->
        <div class="map-container"> <!-- /map-container -->
          <div id="map"></div>
          <div class="custom_typecontrol radius_border">
            <span id="btnRoadmap" class="selected_btn" onclick="setMapType('roadmap')">지도</span>
            <span id="btnSkyview" class="btn" onclick="setMapType('skyview')">스카이뷰</span>
          </div>
          <!-- 지도 확대, 축소 컨트롤 div 입니다 -->
          <div class="custom_zoomcontrol radius_border"> 
            <span onclick="zoomIn()"><img src="https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/ico_plus.png" alt="확대"></span>  
            <span onclick="zoomOut()"><img src="https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/ico_minus.png" alt="축소"></span>
          </div>
        </div> <!-- /map-container -->
        <div id="houses-list-container">
          <div id="houses-list">
            <ul id="list">
            </ul> 
          </div> <!-- 리스트 버튼 -->
        </div>
      </div>
      <div id='menu-layer'>
        <div id="menu"> <!-- 메뉴 -->
          <input type="radio" name="markers-visibility" id="markers-visibility-all" value="all" checked="checked"><label for="markers-visibility-all">건물 모두 표시</label><br>
          <input type="radio" name="markers-visibility" id="markers-visibility-one" value="one"><label for="markers-visibility-one">선택된 건물만 표시</label><br>
          <!--<input type="radio" name="markers-visibility" id="markers-visibility-none" value="none"><label for="markers-visibility-none">건물 모두 표시하지 않기</label><br>-->
          <hr><input type="checkbox" id="modification"><label for="modification">수정하기</label>
        </div>
      </div>
    </div> <!-- main screen -->
      
    <div id="input-layer" class='layer' style="text-align: center"> <!-- 입력창 -->
      <div id="input-window" class='window'><div>
        <select id='house-select' style="white-space: nowrap"></select><br><br>
        <span style="white-space: nowrap">이름: <input type='text' id='input-name' name='name' autocomplete='off'></span><br>
        <span style="white-space: nowrap">주소: <input type='text' id='input-addr' name='addr' autocomplete='off'></span><br>
        <input type='submit' id="update-submit" value="수정"><input type='submit' id="delete-submit" value="삭제"><input type='submit' id="input-submit" value="입력"><br>
        <p id='input-latlng'></p><br><br>
        <p style="font-size: 3; color:white" onclick='closeInput()'>닫기</p>
      </div></div>
    </div> <!-- 입력창 -->
      
    <div id="select-layer" class='layer' style="text-align: center"> <!-- 카드 선택창 -->
      <div id="select-window" class='window'><div>
        <span style="white-space: nowrap"><select id='card-select'></select></span><br><br>
        <input type='submit' id="select-this" value="선택"><br><br>
        <p style="font-size: 3; color:white" onclick='closeSelectLayer()'>닫기</p>
      </div></div>
    </div> <!-- 카드 선택창 -->
    
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- naver.map api -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=bf8dd2e625e382146562b0d80d14059e&libraries=services,clusterer,drawing"></script>
    <script src="/public/js/field.js?var=1" type="text/javascript"></script>
  </body>
</html>


