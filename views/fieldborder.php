<?php
if(!defined('URI')){include($_SERVER['DOCUMENT_ROOT'].'/views/404.php');exit;}

include('./views/header.php');
?>
        <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
        <link href="/public/css/fieldborder.css?ver=1" rel="stylesheet">
    </head>
    <body class="h-100">
        <div class="h-100"> <!-- main screen -->

<?php
include('./views/navbar.php');
?>

            <div class="map-container"> <!-- /map-container -->
                <div id="map" class="h-100"></div>
                <div class="custom_typecontrol radius_border">
                    <span id="btnRoadmap" class="selected_btn" onclick="setMapType('roadmap')">지도</span>
                    <span id="btnSkyview" class="unselected_btn" onclick="setMapType('skyview')">스카이뷰</span>
                </div>
                <!-- 지도 확대, 축소 컨트롤 div 입니다 -->
                <div class="custom_zoomcontrol radius_border"> 
                    <span onclick="zoomIn()"><img src="https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/ico_plus.png" alt="확대"></span>  
                    <span onclick="zoomOut()"><img src="https://t1.daumcdn.net/localimg/localimages/07/mapapidoc/ico_minus.png" alt="축소"></span>
                </div>
            </div> <!-- /map-container -->
        </div> <!-- main screen -->
<?php
include('./views/footer.php');
?>
        <!-- Placed at the end of the document so the pages load faster -->
        <!-- daum.map api -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=bf8dd2e625e382146562b0d80d14059e&libraries=drawing"></script>
        <script src="/public/js/fieldborder.js?var=7" type="text/javascript"></script>
    </body>
</html>