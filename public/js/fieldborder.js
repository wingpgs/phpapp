$( function () { // 최초 실행 함수  모두 로딩되면 바로 실행됨.

    console.log(location.hostname);

    KAKAO_MAP = initKakaoMap(); // 다음맵 시작
    
    var zoomStart = 10;
    var polygons = [];

    kakao.maps.event.addListener(KAKAO_MAP, 'click', function(mouseEvent) {
        console.log(mouseEvent.latLng);
    });

    // 줌 레벨이 7-8 사이에 변하면 지도 구역 표시 바꾸기
    kakao.maps.event.addListener(KAKAO_MAP, 'zoom_changed', function() {        
        if (zoomStart >= 8 && KAKAO_MAP.getLevel() <= 7) {
            polygons.map(function (polygon) {
                polygon.setMap(null);
            });
            $.getJSON( "/public/json/fieldborder_li.json", function ( geojson ) {
                // console.log(geojson);var polygons = [];
                var geometries = geojson.geometries;
                var options = {
                    map: KAKAO_MAP,
                    strokeWeight: 2,
                    strokeColor: '#006eff',
                    strokeOpacity: 0.8,
                    strokeStyle: 'solid',
                    fillColor: '#00EEEE',
                    fillOpacity: 0
                };
                polygons = emdLoop( options, geometries, 0, geometries.length - 1 );
            } );
        } else if (zoomStart <= 7 && KAKAO_MAP.getLevel() >= 8) {
            polygons.map(function (polygon) {
                polygon.setMap(null);
            });
            $.getJSON( "/public/json/fieldborder_emd.json", function ( geojson ) {
                // console.log(geojson);
                var geometries = geojson.geometries;
                var options = {
                    map: KAKAO_MAP,
                    strokeWeight: 2,
                    strokeColor: '#006eff',
                    strokeOpacity: 0.8,
                    strokeStyle: 'solid',
                    fillColor: '#00EEEE',
                    fillOpacity: 0
                };
                polygons = emdLoop( options, geometries, 0, geometries.length - 1 );
            } );
        }
        zoomStart = KAKAO_MAP.getLevel();
    });

    // 구역 경계 읍면 좌표 가져오기
    $.getJSON( "/public/json/fieldborder_emd.json", function ( geojson ) {
        // console.log(geojson);
        var geometries = geojson.geometries;
        var options = {
            map: KAKAO_MAP,
            strokeWeight: 2,
            strokeColor: '#006eff',
            strokeOpacity: 0.8,
            strokeStyle: 'solid',
            fillColor: '#00EEEE',
            fillOpacity: 0
        };
        polygons = emdLoop( options, geometries, 0, geometries.length - 1 );
    } );
} );

// 다음 LatLng 만드는 함수 배열로 있는 위치 정보를 다음LatLng 객체로 모두 변환
function makeKakaoCoordinate( coordinates, start, end ) {
    if ( start == end ) {
        var results = new Array(); 
        results.push( new kakao.maps.LatLng( coordinates[end][1], coordinates[end][0]) );
        return results;
    } else {
        var results = makeKakaoCoordinate( coordinates, start, end -1 ); 
        results.push( new kakao.maps.LatLng( coordinates[end][1], coordinates[end][0]) );
        return results;
    }
}

// 읍면동 루프 함수(폴리곤 그리기 작업 명령)
function emdLoop( options, data, start, end ) {
    if ( start == end ) {
        var coordinates = data[end].coordinates[0];
        var path = makeKakaoCoordinate( coordinates, 0, coordinates.length - 1 );
        var results = new Array();
        options.path = path;
        results.push( drawPolygon( options ) );
        return results;
    } else {
        var coordinates = data[end].coordinates[0];
        var path = makeKakaoCoordinate( coordinates, 0, coordinates.length - 1 );
        var results = emdLoop( options, data, start, end - 1 );
        options.path = path;
        results.push( drawPolygon( options ) );
        return results;
    }
}



{ // 다음 지도 관련 함수들 //
    function initKakaoMap () {   // 다음 지도 시작
        var container = document.getElementById('map');
        var options = {
            //center: new kakao.maps.LatLng(36.8181456, 127.2413294),
            center: new kakao.maps.LatLng(36.71659985578935, 127.11460590440998),
            level: 9
        };
            
        var map = new kakao.maps.Map(container, options);
        //KAKAO_MAP.addOverlayMapTypeId(kakao.maps.MapTypeId.OVERLAY);
        //KAKAO_MAP.removeOverlayMapTypeId(kakao.maps.MapTypeId.OVERLAY);
        // 오버레이 종류 OVERLAY TERRAIN TRAFFIC BICYCLE BICYCLE_HYBRID USE_DISTRICT
        return map;
    }

    function setMapType(maptype) { 
        var roadmapControl = document.getElementById('btnRoadmap');
        var skyviewControl = document.getElementById('btnSkyview'); 
        if (maptype === 'roadmap') {
            KAKAO_MAP.setMapTypeId(kakao.maps.MapTypeId.ROADMAP);    
            roadmapControl.className = 'selected_btn';
            skyviewControl.className = 'unselected_btn';
        } else {
            KAKAO_MAP.setMapTypeId(kakao.maps.MapTypeId.HYBRID);    
            skyviewControl.className = 'selected_btn';
            roadmapControl.className = 'unselected_btn';
        }
    }
    
    // 지도 확대, 축소 컨트롤에서 확대 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
    function zoomIn() {
        KAKAO_MAP.setLevel(KAKAO_MAP.getLevel() - 1,{animate: {duration: 300}});
    }
    
    // 지도 확대, 축소 컨트롤에서 축소 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
    function zoomOut() {
        KAKAO_MAP.setLevel(KAKAO_MAP.getLevel() + 1,{animate: {duration: 300}});
    }

    // 폴리곤 그리기
    function drawPolygon(options) {
        var polygon = new kakao.maps.Polygon(options);
        return polygon;
    }
} // 다음 지도 관련 함수들 //
