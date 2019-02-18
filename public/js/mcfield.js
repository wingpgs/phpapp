$( function () { // 최초 실행 함수  모두 로딩되면 바로 실행됨.

    DAUM_MAP = initDaumMap(); // 다음맵 시작
    
    var zoomStart = 10;
    var polygons = [];

    // 이전 줌 레벨 저장
    daum.maps.event.addListener(DAUM_MAP, 'zoom_start', function() {
        zoomStart = DAUM_MAP.getLevel();
        console.log(zoomStart);
    });

    // 줌 레벨이 7-8 사이에 변하면 지도 구역 표시 바꾸기
    daum.maps.event.addListener(DAUM_MAP, 'zoom_changed', function() {        
        if (zoomStart == 8 && DAUM_MAP.getLevel() == 7) {
            polygons.map(function (polygon) {
                polygon.setMap(null);
            });
            $.getJSON( "/public/json/mcfieldli.json", function ( geojson ) {
                // console.log(geojson);var polygons = [];
                var features = geojson.features;
                var options = {
                    map: DAUM_MAP,
                    strokeWeight: 2,
                    strokeColor: '#006eff',
                    strokeOpacity: 0.8,
                    strokeStyle: 'solid',
                    fillColor: '#00EEEE',
                    fillOpacity: 0
                };
                polygons = emdLoop( options, features, 0, features.length - 1 );
                console.log( geojson );
            } );
        } else if (zoomStart == 7 && DAUM_MAP.getLevel() == 8) {
            polygons.map(function (polygon) {
                polygon.setMap(null);
            });
            $.getJSON( "/public/json/mcfieldemd.json", function ( geojson ) {
                // console.log(geojson);
                var features = geojson.features;
                var options = {
                    map: DAUM_MAP,
                    strokeWeight: 2,
                    strokeColor: '#006eff',
                    strokeOpacity: 0.8,
                    strokeStyle: 'solid',
                    fillColor: '#00EEEE',
                    fillOpacity: 0
                };
                polygons = emdLoop( options, features, 0, features.length - 1 );
                console.log( geojson );
            } );
        }
    });

    // 구역 경계 읍면 좌표 가져오기
    $.getJSON( "/public/json/mcfieldemd.json", function ( geojson ) {
        // console.log(geojson);
        var features = geojson.features;
        var options = {
            map: DAUM_MAP,
            strokeWeight: 2,
            strokeColor: '#006eff',
            strokeOpacity: 0.8,
            strokeStyle: 'solid',
            fillColor: '#00EEEE',
            fillOpacity: 0
        };
        polygons = emdLoop( options, features, 0, features.length - 1 );
        console.log( geojson );
    } );
} );

// 다음 LatLng 만드는 함수 배열로 있는 위치 정보를 다음LatLng 객체로 모두 변환
function makeDaumCoordinate( coordinates, start, end ) {
    if ( start == end ) {
        // 여기 해야 됩니다. 여기 작업중
        var results = new Array(); 
        results.push( new daum.maps.LatLng( coordinates[end][1], coordinates[end][0]) );
        return results;
    } else {
        var results = makeDaumCoordinate( coordinates, start, end -1 ); 
        results.push( new daum.maps.LatLng( coordinates[end][1], coordinates[end][0]) );
        return results;
    }
}

// 읍면동 루프 함수(폴리곤 그리기 작업 명령)
function emdLoop( options, data, start, end ) {
    if ( start == end ) {
        var coordinates = data[end].geometry.coordinates[0];
        var path = makeDaumCoordinate( coordinates, 0, coordinates.length - 1 );
        var results = new Array();
        options.path = path;
        results.push( drawPolygon( options ) );
        return results;
    } else {
        var coordinates = data[end].geometry.coordinates[0];
        var path = makeDaumCoordinate( coordinates, 0, coordinates.length - 1 );
        var results = emdLoop( options, data, start, end - 1 );
        options.path = path;
        results.push( drawPolygon( options ) );
        return results;
    }
}



{ // 다음 지도 관련 함수들 //
    function initDaumMap () {   // 다음 지도 시작
        var container = document.getElementById('map');
        var options = {
            //center: new daum.maps.LatLng(36.8181456, 127.2413294),
            center: new daum.maps.LatLng(36.7501456, 127.2413294),
            level: 10
        };
            
        var map = new daum.maps.Map(container, options);
        //DAUM_MAP.addOverlayMapTypeId(daum.maps.MapTypeId.OVERLAY);
        //DAUM_MAP.removeOverlayMapTypeId(daum.maps.MapTypeId.OVERLAY);
        // 오버레이 종류 OVERLAY TERRAIN TRAFFIC BICYCLE BICYCLE_HYBRID USE_DISTRICT
        return map;
    }

    function setMapType(maptype) {alert('Map is going to zoom!') 
        var roadmapControl = document.getElementById('btnRoadmap');
        var skyviewControl = document.getElementById('btnSkyview'); 
        if (maptype === 'roadmap') {
            DAUM_MAP.setMapTypeId(daum.maps.MapTypeId.ROADMAP);    
            roadmapControl.className = 'selected_btn';
            skyviewControl.className = 'unselected_btn';
        } else {
            DAUM_MAP.setMapTypeId(daum.maps.MapTypeId.HYBRID);    
            skyviewControl.className = 'selected_btn';
            roadmapControl.className = 'unselected_btn';
        }
    }
    
    // 지도 확대, 축소 컨트롤에서 확대 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
    function zoomIn() {
        DAUM_MAP.setLevel(DAUM_MAP.getLevel() - 1,{animate: {duration: 300}});
    }
    
    // 지도 확대, 축소 컨트롤에서 축소 버튼을 누르면 호출되어 지도를 확대하는 함수입니다
    function zoomOut() {
        DAUM_MAP.setLevel(DAUM_MAP.getLevel() + 1,{animate: {duration: 300}});
    }

    // 폴리곤 그리기
    function drawPolygon(options) {
        var polygon = new daum.maps.Polygon(options);
        return polygon;
    }
} // 다음 지도 관련 함수들 //
