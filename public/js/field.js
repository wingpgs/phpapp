//
// 가구(가정? 집?) 객체 정의 시작
//

function house (building,data,order,last_visit_date) {
	if (data.house_name === '') { data.house_name = '' }
	if (data.house_status === '') { data.house_status = 0 }
	this.id = data.house_id;
	this.building_id = data.building_id;
	this.name = data.house_name;
	this.date = data.house_date;
	this.dateb = data.house_date2;
	this.datec = data.house_date3;
	this.count = order;
	this.checked = data.house_status; // -1 방문금지, 0 해야함, 1 만남, 2 못만남
	// 리스트에 추가하기
    $( "#list").append( "<li id='list" + this.id + "'><a href='#' class='my-link' id='house"
        + this.id + "'><div class='house-num'>" + this.id + "</div><div class='house-name'>"
        + this.name + "</div><div class='house-addr'>"+building.address+"</div>" + "</a>" + 
		"<div class='list-checkbox-gray'></div>" + 
        "<div class='list-checkbox'></div>" +  
		"<div class='list-check-layer'>" +
        "<div class='button-checked list-checkbox-checked'></div>" + 
        "<div class='button-indeterminate list-checkbox-indeterminate'></div>" + 
        "<div class='button-null list-checkbox-null'></div></div>" +
		"</li>" );
	this.list_item = $( '#list'+this.id+'>a' );
    this.checkbox_gray = $( '#list'+this.id+'>.list-checkbox-gray' );
	this.checkbox = $( '#list'+this.id+'>.list-checkbox' );
	if (this.checked == 0) {
		this.checkbox.addClass('list-checkbox-null');
		//null_house_count++;
	} else if (this.checked == 1) { 
		this.checkbox.addClass('list-checkbox-checked');
	} else if (this.checked == -1) {
		this.checkbox.addClass('list-checkbox-no-visit');
	} else {
        (function (thishouse) { var today = getDate();
          if ( thishouse.datec == today ) {
            thishouse.checkbox.addClass('list-checkbox-indeterminate');
          } else if ( thishouse.datec == last_visit_date ) {
            thishouse.checkbox.addClass('list-checkbox-null');
            thishouse.checkbox_gray.css('display','block');
          } else {
            thishouse.checkbox.addClass('list-checkbox-null');
          }
        })(this);
    }

	this.check_layer = $( '#list'+this.id+'>.list-check-layer');
	this.checked_button = $( '#list'+this.id+'>div>.button-checked');
	this.indeterminate_button = $( '#list'+this.id+'>div>.button-indeterminate');
	this.null_button = $( '#list'+this.id+'>div>.button-null');

	// 목록 클릭 리스너 등록
	this.setListClickListener(building,this);
	this.setCheckboxClickListener(this);
	this.setCheckedButtonClickListener(this);
	this.setIndeterminateButtonClickListener(this);
	this.setNullButtonClickListener(this);
}

house.prototype.setCheckedButtonClickListener = function (house) {
	house.checked_button.click( function() {
		if (house.checked != 1) {
			//if ( house.checked == 0 ) {
				//null_house_count--;
				//checkNullHouseCount();
			//}
			visitRecord(house, 1);
		}
		house.check_layer.css('display','none');
		return false;
	});
}

house.prototype.setIndeterminateButtonClickListener = function (house) {
	house.indeterminate_button.click( function () {
		if ( !house.checkbox.hasClass('list-checkbox-indeterminate') ) {

			//if ( house.checked == 0 ) {
				//null_house_count--;
				//checkNullHouseCount();
			//}
			visitRecord(house, 2);
		}
		house.check_layer.css('display','none');
		return false;
	});
}

house.prototype.setNullButtonClickListener = function (house) {
	house.null_button.click( function() {
		if (house.checked != 0) {
			//null_house_count++;
			visitRecord(house, 0);
		}
		house.check_layer.css('display','none');
		return false;
	});
}

house.prototype.setCheckboxClickListener = function (house) {
	house.checkbox.click(
		function () {
			var today = getDate();
			if ((house.checked == 1 & house.date != today) || house.checked == -1) {
			} else {
				$('.list-check-layer').css('display','none');
				house.check_layer.css('display','block');
			}
		}
	);
}

house.prototype.setListClickListener = function (building, house) { // 리스트 클릭 리스너 정의
	house.list_item.click(
		function () { // window.alert( $( "#main-screen" ).css("left") );
			if ( $( "#modification" ).prop( "checked" ) ) {  // 수정 체크 상태
				selected[1] = building; // 선택된 건물 임시 저장
				//$( '#input-latlng' ).text(e.coord);
				$("#input-submit").css('display','none');
				$("#update-submit").css("display","inline").val('수정');
				$("#delete-submit").css("display","inline").val('삭제');
				
				var option = '<option value="' + house.count + '" selected></option>';
				$("#house-select").css("display","none").html(option);
				$("#input-name").val(house.name).attr('disabled',null);
				$("#input-addr").val(building.address).attr('disabled','');

				viewInput();
			} else { // 수정 체크 안된 상태
				if (building.info_window.getMap()) { // 이전에 선택했던 건물 선택
					for (var i = 0; i < selected[0].houses.length; i++) {
						var list_item = selected[0].houses[i].list_item;
						list_item.css('color','#05a');
					}
                    selected[0] = null;
					building.info_window.close();
				} else {
					if (selected[0] !== null & selected[0] !== undefined) {
						for (var i = 0; i < selected[0].houses.length; i++) {
							var list_item = selected[0].houses[i].list_item;
							list_item.css('color','#05a');
						}
                        selected[0].info_window.close(); // 이전 선택한 마커 인포 윈도우 닫기
					}
					for (var i = 0; i < building.houses.length; i++) {
						var list_item = building.houses[i].list_item;
						list_item.css('color','#c22');
					}
					selected[0] =  building;
                    //building.info_window.open(NAVER_MAP, building.marker);
                    DAUM_MAP.setCenter(building.marker.getPosition());
                    building.info_window.open(DAUM_MAP, building.marker);
				}
                var val = $(":input:radio[name=markers-visibility]:checked").val();
                if ( val == "one" ) { // 선택된 마커 하나만 표시하기 옵션 상태일 때 보이는 마커 변경.
                  myCard.setMarkersVisibility();
                }
                    
			}
			return false;
		}
	);
}

house.prototype.updateListItem =function (building) {
	var list_item_html = "<div class='house-num'>" + this.id +  
		"</div><div class='house-name'>"+this.name+"</div><div class='house-addr'>"+building.address+"</div>" ;
	this.list_item.html(list_item_html);
}

//
// 가구(가정? 집?) 객체 정의 완료
//


//
// 건물 객체 정의 시작
//

function building (card,data,order) {  // 각 건물 객체
	this.houses = [];
	this.id = data[0].building_id;
	this.map_id = data[0].map_id;
	this.address = data[0].building_address;
	this.lat = data[0].building_latitude;
	this.lng = data[0].building_longitude;
	this.count = order;
	this.info_window = null;
	this.html_for_house_select = null;
	// 모든 변수 할당 끝... ㅎㅎ
	
	// 이제 건물 마커 찍고 인포 윈도우 만들고...
    this.coord = new daum.maps.LatLng(Number(this.lat),Number(this.lng));
    this.marker = new daum.maps.Marker({
      map: DAUM_MAP,
      position: this.coord,
      image: marker_icon_daum.red,
    });
    
	for (var i = 0; i < data.length; i++) { // 아 어렵다.. 가구(집) 객체 등록
		this.addHouse(data[i],card.last_visit_date);
	}

    for ( var j = 0; j < this.houses.length; j ++ ) {  // 마커 색상 선택 만난 곳 못만난곳 등등..
      // checked = -1 방문금지, 0 해야함, 1 만남, 2 못만남
      if ( this.houses[j].checked == 0 ) {
        this.marker.setImage(marker_icon_daum.blue);
        break;
      } else if ( this.houses[j].checked == 2 ) {
        this.marker.setImage(marker_icon_daum.yellow);
      }
    }
    
	// 마커 클릭 리스너 등록
	this.setMarkerClickListener(card,this);
}

building.prototype.setMarkerClickListener = function (card, building) { // 건물 클릭 리스너 정의 ** 클로저 관련 내용 숙지
	daum.maps.event.addListener(building.marker, 'click', function(e) {
		if ( $( "#modification" ).prop( "checked" ) ) {  // 수정 체크 상태
			selected[1] = building; // 선택된 건물 임시 저장
			//$( '#input-latlng' ).text(e.coord);
			$("#input-submit").val('추가').css('display','none');
			$("#update-submit").css("display","inline").val('수정');
			$("#delete-submit").css("display","none").val('삭제');
			
			// select 설정
			building.makeSelect();
			$("#house-select").css("display","inline").html(building.html_for_house_select);
			$("#input-name").val('').attr('disabled','');
			$("#input-addr").val(building.address).attr('disabled',null);

			viewInput();
		} else { // 수정 체크 안된 상태
			if ( building.info_window.getMap() ) { // 이전에 선택했던 건물 선택
				for (var i = 0; i < selected[0].houses.length; i++) {
					var list_item = selected[0].houses[i].list_item;
					list_item.css('color','#05a');
				}
                selected[0] = null;
				building.info_window.close(); // 이전에 있던 인포 윈도우 닫기
			} else {
				var list_offset = []; // 선택한 건물에 포함된 목록으로 스크롤하기 위해 필요한 좌표 저장하기 위한 변수 0 목록의 가장 위 오프셋 1 선택된 가구 오프셋
                if (selected[0] !== null & selected[0] !== undefined) { // 이전에 선택된 건물이 있다면 그 건물 선택 취소
					for (var i = 0; i < selected[0].houses.length; i++) {
						var list_item = selected[0].houses[i].list_item;
						list_item.css('color','#05a');
					}
                    selected[0].info_window.close(); // 이전 선택한 마커 인포 윈도우 닫기
				}
				for (var i = 0; i < building.houses.length; i++) { // 선택된 건물 목록에서 표시하기
					var list_item = building.houses[i].list_item;
					list_item.css('color','#c22');
                    if ( i === 0 ) { // 선택된 건물 목록에서의 오프셋 구하기
                      list_offset[0] = list_item.parent().parent().offset().top;
                      list_offset[1] = list_item.parent().offset().top;
                    }
                    //console.log(list_item.parent().parent().offset().top);
                    //console.log(list_item.parent().position().top);
                    //console.log(list_item.parent().offset().top);
				}
                $( "#houses-list" ).animate({scrollTop:list_offset[1] - list_offset[0]}, 500); // 선택된 건물로 목록 스크롤..
				selected[0] =  building; // 선택된 건물 저장 다음 번 클릭 이벤트 위해서.
				building.info_window.open(DAUM_MAP, building.marker); // 인포 윈도우 띄우기
			}
            var val = $(":input:radio[name=markers-visibility]:checked").val();
            if ( val == "one" ) { // 선택된 마커 하나만 표시하기 옵션 상태일 때 보이는 마커 변경.
              myCard.setMarkersVisibility();
            }
		}
	});
}

building.prototype.setContentString = function () {  // 인포 윈도우 텍스트
	this.content_string = '<div class="iw_inner">'+
		'주소 : '+this.address+'<br />'+
		'가구수 : ' + this.houses.length + ' 가구 <br />' +
		'</div>';
}

building.prototype.setInfoWindow = function () {// 인포 윈도우 수정
	this.setContentString();
	if (this.info_window === null) {
		//this.info_window = new naver.maps.InfoWindow({content: this.content_string,color: "black"});
        this.info_window = new daum.maps.InfoWindow({
          content: this.content_string,
        });
        
	} else {
		this.info_window.setContent(this.content_string);
	}
}

building.prototype.makeSelect = function () { // 입력창 select 들어갈 item text에 html string 추가
	this.html_for_house_select = '<option value="-1">'+this.address+'</option>';
	for (var i = 0; i < this.houses.length; i++) {
		this.html_for_house_select += '<option value="' + (this.houses[i].count) + '">' + (this.houses[i].count+1) + ' ' + this.houses[i].name + '</option>';
	}
	this.html_for_house_select += '<option value="-2">추가</option>';
}

building.prototype.addHouse = function (data, last_visit_date) { // 가구(집) 추가하는 메소드
	if (this.houses.length) {var order = this.houses.length} else {var order = 0}	
	var thouse = new house(this, data, order, last_visit_date);
	this.houses.push(thouse);
	this.setInfoWindow();  // 인포 윈도우 등록
	if (selected[0] === this) { // 선택된 상태면 색상도 변경
		thouse.list_item.css('color','#c22');
	}
}

building.prototype.updateHouse = function (building, house, data) {
	house.name = data['name'];
	house.updateListItem(building);
}

building.prototype.deleteHouse = function (house) { // 가구(집) 삭제하기
	house.list_item.parent().remove();
	this.houses.splice(house.count,1);
	for (var i = house.count; i < this.houses.length; i++) {
		this.houses[i].count--;
	}
	this.setInfoWindow();
}

//
// 건물 객체 정의 완료
//

//
// 구역 카드 객체(생성, 관련 리스너 등록)
//

function card (data) { // 카드 객체 정의
	this.buildings = []; // 이 카드에 있는 빌딩들 객체 생성해서 넣는 배열
	this.id = data['id'];
	this.name = data['name'];
	this.buildings_coord =[];
	this.buildings_marker = [];
	this.last_visit_date = (function () {  // 지난 방문 날짜 구하기.. ㅎㅎ 즉시실행함수 사용 ㅋㅋ
      var return_date = "2000-01-01";
      var today = getDate();
      for ( var i = 0; i < dbbuildings.length; i++ ) {
        for ( var j = 0; j < dbbuildings[i].length; j++ ) {
          if ( return_date < dbbuildings[i][j].house_date3 && dbbuildings[i][j].house_date3 < today ) {
            return_date = dbbuildings[i][j].house_date3;
          }
        }
      }
      return return_date;
    })();
    
	for (var i = 0; i < dbbuildings.length; i++) { // 집들 마꺼찍는 함수 불러서 마커 찍기
		this.addBuilding(dbbuildings[i]); // 건물 추가하기
	}
	
	if (this.buildings_coord.length != 0) { // 지도 위치 옮기기 건물 마커가 화면에 모두 들어오는 크기로 이동
      var map_bound = new daum.maps.LatLngBounds();
      for ( var i = 0; i < this.buildings_coord.length; i++ ) {
        map_bound.extend(this.buildings_coord[i]);
      }
      DAUM_MAP.setBounds(map_bound);
	}
	
	daum.maps.event.addListener(DAUM_MAP, 'click',function(e) { // 맵 클릭 리스너
		if ( $( "#modification" ).prop( "checked" ) ) {
			getAddress(e.latLng);
			selected[1] = null;
			//$( '#input-latlng' ).text(e.coord);
			select_location['lat'] = e.latLng.getLat();
			select_location['lng'] = e.latLng.getLng();
			$("#input-name").val('').attr('disabled',null).focus();
			$("#input-submit").val('입력').css("display","inline");
			$("#update-submit").css("display","none");
			$("#delete-submit").css("display","none");
			$("#house-select").css("display","none").text('');

				
			viewInput();
		} else {
			//var zoom = NAVER_MAP.getZoom();
			//var center = NAVER_MAP.getCenter();
			//alert(zoom + ' ' + center);
			//console.log(zoom);
			//console.log(center);
		}
	});
	this.setMarkerClusterer(); // 마커 클러스터링 셋팅 함수 호출
    this.setMarkersVisibility();
}

card.prototype.addBuilding = function (data) { // 건물 추가하는 메소드
	if (this.buildings.length) {var order = this.buildings.length} else {var order = 0}
	var tbuilding = new building(this,data,order); // 건물 객체 생성
	this.buildings.push(tbuilding); // 건물 객체 배열에 저장
	this.buildings_coord.push(tbuilding.coord);
	this.buildings_marker.push(tbuilding.marker);
    if ( this.markerClusterer ) {
      this.markerClusterer.addMarker(tbuilding.marker);
    }
}

card.prototype.updateBuilding = function (building, data) {
	building.address = data['address'];
	for (var i = 0; i < building.houses.length; i++) {
		building.houses[i].updateListItem(building);
	}
	building.setInfoWindow();
}

card.prototype.deleteBuilding = function (building) {
	building.marker.setVisible(false);
    building.info_window.close();
	for (var i = 0; i < building.houses.length; i++) {
		$(building.houses[i].list_item).parent().remove();
	}
	this.buildings.splice(building.count,1);
	this.buildings_coord.splice(building.count,1);
	this.buildings_marker.splice(building.count,1);
    this.markerClusterer.removeMarker(building.marker);

	for (var i = building.count; i < this.buildings.length; i++) {
		this.buildings[i].count--;
	}
}

card.prototype.setMarkerIcon = function () {
    var marker_icon_state = [];
    for ( var i = 0; i < this.buildings.length; i++ ) {
        marker_icon_state[i] = 1;
        console.log(1);
        for ( var j = 0; j < this.buildings[i].houses.length; j ++ ) {
            if ( this.buildings[i].houses[j].checked == 0 ) {
                console.log(2);
                marker_icon_state[i] = 0;
                break;
            } else if ( this.buildings[i].houses[j].checked == 2 ) {
                console.log(3);
                marker_icon_state[i] = 2
            }
        }
        if ( marker_icon_state[i] == 1 ) {
            this.buildings[i].marker.setImage(marker_icon_daum.red);
        } else if ( marker_icon_state[i] == 2 ) {
            this.buildings[i].marker.setImage(marker_icon_daum.yellow);
        } else {
            this.buildings[i].marker.setImage(marker_icon_daum.blue);
        }
    }
}

card.prototype.setMarkerClusterer = function () { // 마커 클러스터링 세팅
    this.markerClusterer = new daum.maps.MarkerClusterer({
        map: DAUM_MAP, // 마커들을 클러스터로 관리하고 표시할 지도 객체 
        averageCenter: true, // 클러스터에 포함된 마커들의 평균 위치를 클러스터 마커 위치로 설정 
        minLevel: 2, // 클러스터 할 최소 지도 레벨 
        markers: this.buildings_marker,
        calculator: [5, 10, 20, 40, 80],
        gridSize: 40,
        minClusterSize: 2,
        
    });
}

card.prototype.setMarkersVisibility = function () {
    var val = $(":input:radio[name=markers-visibility]:checked").val();console.log(val);
    this.visible_markers = []; // 마커클러스터러에 넣을 마커 모음
    if ( val == "all" ) {
        for ( var i = 0; i < this.buildings_marker.length; i++ ) {
        this.buildings_marker[i].setMap(DAUM_MAP);
        this.visible_markers.push(this.buildings_marker[i]);
        }
    } else if ( val == "one" ) {
        for ( var i = 0; i < this.buildings_marker.length; i++ ) {
        if ( this.buildings[i] == selected[0] ) {
            this.buildings_marker[i].setMap(DAUM_MAP);
            this.visible_markers.push(this.buildings_marker[i]);
        } else {
            this.buildings_marker[i].setMap(null);
        }
        }
    } else {
        for ( var i = 0; i < this.buildings_marker.length; i++ ) {
        this.buildings_marker[i].setMap(null);
        if ( this.buildings[i] == selected[0] ) {
            this.visible_markers.push(this.buildings_marker[i]);
        }
        }
    }
    this.markerClusterer.clear();
    this.markerClusterer.addMarkers(this.visible_markers);
}



function cardSimple (data, order) { // 카드 기본 데이터 저장용 객체
	this.id = data.map_id;
	this.name = data.map_name;
	this.count = order;
}

//
// 구역 카드 객체(생성, 관련 리스너 등록)
//

//
// 상단바 버튼 클릭 리스너
//

//$( "#list-button" ).click(  // 집 목록 버튼 토글
//	function () { // window.alert( $( "#main-screen" ).css("left") );
//		if ( $( "#toggle-map-and-list" ).css("left") === "0px" & typeof(myCard) != 'function' ) { 
//			$( "#toggle-map-and-list" ).animate({left:"-100%"},0);
//		} else {
//			$( "#toggle-map-and-list" ).animate({left:"0px"},0);
//		}
//	}
//);

$( '#list-screen-button' ).click(
    function () {
        if ( $( "#toggle-map-and-list" ).css("left") !== "0px" & typeof(myCard) != 'function' ) { 
        $( "#toggle-map-and-list" ).animate({left:"0px"},0);
        }
        return false;
    }
);

$( '#map-screen-button' ).click(
    function () {
        if ( $( "#toggle-map-and-list" ).css("left") === "0px" & typeof(myCard) != 'function' ) { 
        $( "#toggle-map-and-list" ).animate({left:"-100%"},0);
        }
        return false;
    }
);
//map-screen-button

$( '#card-selection' ).click( function () { // 네비바 타이틀 클릭(카드 선택)
	makeCardSelect(card_simple);
	$("#card-select").css("display","inline");
	$("#select-this").css("display","inline");
	viewSelectLayer();

	return false;
});

$( "#setting-menu-button" ).click( function () {   // 메뉴 버튼 토글
	if ( $( "#menu-layer" ).css("display") === "none"  & typeof(myCard) != 'function' ) {
		$( "#menu-layer" ).css( "display", "block" );
	} else {
		$( "#menu-layer" ).css( "display", "none" );
	}
});

//
// 상단바 버튼 클릭 리스너
//


//
// 메뉴  항목들 리스너
//

$('input[type=radio][name=markers-visibility]').change(function() {
  myCard.setMarkersVisibility();
});

$("#markers-visibility").click(function() { // 지도가 안보여 마커 안보이게 하기. 메뉴에서 마커숨김 체크하면 뿅~
	var j = myCard.buildings.length;
	if ( $(this).prop('checked') ) {
		for ( var i = 0; i < j; i++) {
			myCard.buildings[i].marker.setVisible(false);
		}
	} else {
		for ( var i = 0; i < j; i++) {
			myCard.buildings[i].marker.setVisible(true);
		}		
	}
	event.stopPropagation();
});

$("#modification").on('click', function() { // 수정 메뉴 이벤트 전파 방지
	event.stopPropagation();
});

$('#menu-layer').click( function () {
	$( "#menu-layer" ).css( "display", "none" );
});

$('#menu').click( function () {
	event.stopPropagation();
});

//
// 메뉴 관련 리스너
//

//
// 서버와의 통신
//

//function getMoreNullHouse() {
//	
//    var sql = '=query({houses!A2:J, arrayformula(row(houses!A2:J))}, "select Col11 where Col1 = ' 
//      + myCard.id + ' and Col5 = 2 and Col8 <> ' + "'" + getDate() + "'" + ' order by Col1 asc")';
//    var data = []; data[0] = []; data[0][0] = 5; data[0][1] = 0;
//    google.script.run.withSuccessHandler(function (h) {
//      var today = getDate();
//      for ( var i = 0; i < myCard.buildings.length; i++ ) {
//        for ( var j = 0; j < myCard.buildings[i].houses.length; j++ ) {
//          if ( myCard.buildings[i].houses[j].checked == 2 & myCard.buildings[i].houses[j].datec != today ) {
//            myCard.buildings[i].houses[j].checked = 0;
//            myCard.buildings[i].houses[j].checkbox.attr('class','list-checkbox list-checkbox-null');
//          }
//        }
//      }
//      myCard.setMarkerIcon();
//    }).update(sql, data);
//    
//}

function visitRecord(house,checkstate) {
    var today_date = getDate();
    var data = {}; data.house_status = checkstate; data.house_id = house.id;
    
    // 5 checkstate(house_status)(-1 방문금지,0 방문안함,1 만남,2 못만남),
    // 6 만난날짜, 7 만난날짜백업, 8 방문상태변경날짜
    if ( checkstate == 1 ) {
        if ( house.date == '' && house.dateb == '') {
            data.house_date = today_date; data.house_date2 = today_date;
        } else if ( house.date != '' ) {
            data.house_date = today_date; data.house_date2 = house.date;
        } else {
            data.house_date = today_date;
        }
    } else {
        if ( house.date == house.dateb ) {
            data.house_date = ''; data.house_date2 = ''; data.house_date3 = today_date;
        } else {
            data.house_date = ''; data.house_date3 = today_date;
        }
    }
    console.log(data);

    $.ajax({
        method: 'POST',
        dataType: 'text',
        url: '/update/',
        data: data
    }).done(function (data) {
        console.log(data);
        var today = getDate();
        if (data && checkstate == 1) {
        
            house.date = today;
            if (house.dateb == '') {
                house.dateb = today;
            }
            house.checkbox.attr('class','list-checkbox list-checkbox-checked');
            house.checked = 1;
        } else if (data) {
            house.datec = today;
            if (house.date == house.dateb) {
                house.dateb = '';
            }
            house.date = '';
            if (checkstate == 2) {
                house.checkbox_gray.css('display','none');
                house.checkbox.attr('class','list-checkbox list-checkbox-indeterminate');
                house.checked = 2;
            } else {
                house.checkbox_gray.css('display','none');
                house.checkbox.attr('class','list-checkbox list-checkbox-null');
                house.checked = 0;
            }
        }
        myCard.setMarkerIcon();
    });
}

$('#input-submit').click(function() {  // 추가 입력

    // 1 map_id, 2 building_id, 3 building_address, 4 house_name, 5 house_status,
    // 9 building_latitude, 10 building_longitude
    var data = {}; data.house_status = 0; data.map_id = myCard.id;
    var input_name = $('#input-name').val(); var input_address = $('#input-addr').val();
    data.house_name = input_name;data.building_address = input_address;

    if (selected[1] === null) {
        for ( var i = 0; i < myCard.buildings.length; i++ ) {
            if ( myCard.buildings[i].address == input_address ) {
            alert("이 카드에 '" + input_address + "'이(가) 이미 있습니다. 이름을 변경하세요.");
            return;
            }
        }
        data.building_latitude = select_location['lat']; data.building_longitude = select_location['lng'];
    } else {
        for ( var i = 0; i < selected[1].houses.length; i++ ) {
            if ( selected[1].houses[i].name == input_name ) {
            alert("이 건물에 '" + input_name + "'이(가) 이미 있습니다. 이름을 변경하세요.");
            return;
            }
        }
        data.building_id = selected[1].id;
    }
    console.log(data);

    // 입력창 닫기
	closeInput();
    
    setTimeout(function() {
        $.ajax({
            method: 'POST',
            dataType: 'text',
            url: '/insert/',
            data: data
        }).done(function (data) {
            if (data != 'false') { 
                var returnValue = JSON.parse(data);
                var setdata = returnValue[0];
                if (selected[1] === null) {
                    myCard.addBuilding(returnValue);
                } else {
                    selected[1].addHouse(setdata,myCard.last_visit_date);
                }
            }
        });    
    }, 1000);
    
});

$('#update-submit').click(function() { // 수정 입력
	// 1 map_id, 2 building_id, 3 building_address, 4 house_name, 5 house_status, 
    // 9 building_latitude, 10 building_longitude
    var count = $( '#house-select' ).val(); var data = {}; var data_for_callback = {};
    var input_name = $('#input-name').val(); var input_address = $('#input-addr').val();
    data_for_callback['name'] = input_name; data_for_callback['address'] = input_address;
    
    // count -1 건물 주소 수정, -2 새로운 가구 입력, 그외..
    if ( count != -1 & count != -2 ) {
        for ( var i = 0; i < selected[1].houses.length; i++ ) {
            if ( selected[1].houses[i].name == input_name ) {
            alert("이 건물에 '" + input_name + "'이(가) 이미 있습니다. 이름을 변경하세요.");
            return;
            }
        }
        data.house_name = input_name; 
        data.house_id = selected[1].houses[count].id;
        data_for_callback['code'] = 'house';
    } else if ( count == -1 ) {
        for ( var i = 0; i < myCard.buildings.length; i++ ) {
            if ( myCard.buildings[i].address == input_address ) {
            alert("이 카드에 '" + input_address + "'이(가) 이미 있습니다. 이름을 변경하세요.");
            return;
            }
        }
        data.building_address = input_address;
        data.building_id = selected[1].id;
        data_for_callback['code'] = 'building';
    } else {
        return;
    }
    
	// 입력창 닫기
	closeInput();

    setTimeout(function() {
        $.ajax({
            method: 'POST',
            dataType: 'text',
            url: '/update/',
            data: data
        }).done(function (data) {
            if (data) {
                if (data_for_callback['code'] === 'house') {
                    selected[1].updateHouse (selected[1],selected[1].houses[count], data_for_callback);
                } else if (data_for_callback['code'] === 'building') {
                    myCard.updateBuilding (selected[1], data_for_callback);
                }
            } else {
            }
        });
    },500);    
});

$('#delete-submit').click(function() { // 삭제
    var count = $( '#house-select' ).val(); var data = {};
    if ( selected[1].houses.length > 1 ) {
        data.house_id = selected[1].houses[count].id;
    } else {
        data.building_id = selected[1].id;
    }

    // 입력창 닫기
    closeInput();

    setTimeout( function () {
        $.ajax({
            method: 'POST',
            dataType: 'text',
            url: '/delete/',
            data: data
        } ).done( function ( data ) {
            if ( data ) {
                if ( selected[1].houses.length > 1 ) {
                    selected[1].deleteHouse( selected[1].houses[count] );
                } else {
                    myCard.deleteBuilding( selected[1] );
                }
            } else {
                console.log( 'false returned' );
            }
        } );
    }, 500 );
} );

$(document).ready( function() {  // 여기가 시작.
    
    var uriArray = decodeURI(window.location.pathname).split('/');

    initDaumMap();
    
    var data = {}; data.map_id = uriArray[2];
    $.ajax({
        method: 'POST',
        dataType: 'JSON',
        url: '/gethouses/',
        data: data
    }).done(function(data) {
        console.log(data);
        if (data != 'false') {
            arrangeBuildingData(data);
        } else {
            dbbuildings = [];
        }
        var simple_card = {}; simple_card.id = uriArray[2]; simple_card.name = uriArray[3];
        myCard = new card(simple_card);  // 카드 객체 생성 (카드 안에 다 있음. 건물, 리스트-아이템, 마커, 맵, 등등 필요한 변수들도 몽땅 들어 있음. 하나만 확인하면 됨 ㅋㅋ
        //checkNullHouseCount();  // null_house_count 확인하고 0이면 indeterminated 상태 null로 변경
        //myCard.setMarkerIcon();
        $('#navbar-title').text(uriArray[3]); // $('#card-selection').text(card_simple[count].name); // 헤더 구역카드 이름으로 변경
        localStorageData(); // 로컬스토리지에 데이터 저장
        console.log(localStorage);
    });
    // 시작
    

    // if ( compareTime() ) {  // 지정된 시간 안에 접속한 기록이 있으면 이전에 불러왔던 맵 다시 불러오기
    //     // var data = {}; data.map_id = localStorage.card_id;
    //     var data = {}; data.map_id = uriArray[2];
    //     $.ajax({
    //         method: 'POST',
    //         dataType: 'JSON',
    //         url: '/gethouses/',
    //         data: data
    //     }).done(function(data) {
    //         console.log(data);
    //         if (data != 'false') {
    //             arrangeBuildingData(data);
    //         } else {
    //             dbbuildings = [];
    //         }
    //         var simple_card = {}; simple_card.id = localStorage.card_id; simple_card.name = localStorage.card_name;
    //         myCard = new card(simple_card);  // 카드 객체 생성 (카드 안에 다 있음. 건물, 리스트-아이템, 마커, 맵, 등등 필요한 변수들도 몽땅 들어 있음. 하나만 확인하면 됨 ㅋㅋ
    //         //checkNullHouseCount();  // null_house_count 확인하고 0이면 indeterminated 상태 null로 변경
    //         //myCard.setMarkerIcon();
    //         $('#card-selection').text(localStorage.card_name); // $('#card-selection').text(card_simple[count].name); // 헤더 구역카드 이름으로 변경
    //         localStorageData(); // 로컬스토리지에 데이터 저장
    //         console.log(localStorage);
    //     });
        
    //     $.ajax({
    //         dataType: 'JSON',
    //         url: '/getmaps/'
    //     }).done(function(data) {
    //         if(data) {
    //             for (var i = 0; i < data.length; i++) {
    //                 card_simple[i] = new cardSimple(data[i],i);
    //             }
    //         } else {
    //         }
    //     });
    // } else {
    //     $.ajax({
    //         dataType: 'JSON',
    //         url: '/getmaps/'
    //     }).done(function(data) {
    //         if(data) {
    //             for (var i = 0; i < data.length; i++) {
    //                 card_simple[i] = new cardSimple(data[i],i);
    //             }
    //             $('#card-selection').append("여기를 누르세요...");
    //         } else {
    //             $('#navbar-title').empty().append("사용가능한 카드 없음");    
    //         }
    //     });
    // }
    // 시작
});

// $('#select-this').click(function() {   // 구역카드 선택 버튼 클릭
//     closeSelectLayer(); // 선택 레이어 내리기
    
//     // 지도와 리스트 초기화 (다른 구역 선택할 때를 대비..)
//     $( '#map' ).empty();
//     $( "#list" ).empty();

//     initDaumMap();

//     var count = $('#card-select').val();
//     var data = {}; data.map_id = card_simple[count].id;

//     setTimeout(function() {
//         $.ajax({
//             method: 'POST',
//             dataType: 'JSON',
//             url: '/gethouses/',
//             data: data
//         }).done(function(data) {
//             console.log(data);
//             if (data != 'false') {
//                 arrangeBuildingData(data);
//             } else {
//                 dbbuildings = [];
//             }
//             myCard = new card(card_simple[count]);  // 카드 객체 생성 (카드 안에 다 있음. 건물, 리스트-아이템, 마커, 맵, 등등 필요한 변수들도 몽땅 들어 있음. 하나만 확인하면 됨 ㅋㅋ
//             //checkNullHouseCount();  // null_house_count 확인하고 0이면 indeterminated 상태 null로 변경
//             //myCard.setMarkerIcon();
//             $('#card-selection').text(card_simple[count].name); // $('#card-selection').text(card_simple[count].name); // 헤더 구역카드 이름으로 변경
//             localStorageData(); // 로컬스토리지에 데이터 저장
//             console.log(localStorage);
//         });
//     }, 1000);

// });  // 구역카드 선택버튼 클릭

//
// 서버와의 통신
//


//
// 기타 함수들 혹은 리스너
//

//function checkNullHouseCount () {
//	if ( null_house_count === 0 ) {
//		getMoreNullHouse();
//	}
//}

function getDate() { // 오늘 날짜 가져오기
	var date = new Date(); 
	var year = date.getFullYear(); 
	var month = new String(date.getMonth()+1); 
	var day = new String(date.getDate()); 
	// 한자리수일 경우 0을 채워준다. 
	if(month.length == 1){ 
		month = "0" + month; 
	} 

	if(day.length == 1){ 
		day = "0" + day; 
	} 

	return year + "-" + month + "-" + day;
}

function makeCardSelect(data) { // 입력창 select 들어갈 item text에 html string 추가
	var html_for_card_select = '<option value="">선택</option>';
	for (var i = 0; i < data.length; i++) {
		html_for_card_select += '<option value="' + (data[i].count) + '">' + (data[i].id) + ' ' + data[i].name + '</option>';
	}
	//html_for_card_select += '<option value="-1">추가</option>';
	$("#card-select").html(html_for_card_select);
}

$('#house-select').on('change', function() { // 입력창 select 선택시 fire ㅎㅎ
	var count = $('#house-select').val(); var building = selected[1];
	if (count == -1) {
		$("#input-addr").val(building.address).attr('disabled',null);
		$("#input-name").val('').attr('disabled','');
		$("#input-submit").css('display','none');
		$("#update-submit").css("display","inline");
		$("#delete-submit").css("display","none");
	} else if (count == -2) {
		$("#input-addr").val(building.address).attr('disabled','');
		$("#input-name").val('').attr('disabled',null).focus();
		$("#input-submit").css('display','inline');
		$("#update-submit").css("display","none");
		$("#delete-submit").css("display","none");
	} else {
		$("#input-addr").val(building.address).attr('disabled','');
		$("#input-name").val(building.houses[count].name).attr('disabled',null);
		$("#input-submit").css('display','none');
		$("#update-submit").css("display","inline");
		$("#delete-submit").css("display","inline");
	}
});

function viewInput(){ // 입력창 열기 함수
	$( "#input-layer" ).animate({top:"0px"},400);
}

function closeInput(){  // 입력창 닫기 함수
	$("#input-name").val('');
	$("#input-addr").val('');
	$( "#input-layer" ).animate({top:"100%"},400);
}

function viewSelectLayer(){ // 카드 선택창 열기 함수
	$( "#select-layer" ).animate({top:"0px"},400);
}

function closeSelectLayer(){  // 카드 선택창 닫기 함수
	$( "#select-layer" ).animate({top:"100%"},400);
}

function getAddress(e) { // 좌표에서 주소 가져와서 입력창에 주소에 넣어주기.
    var geocoder = new daum.maps.services.Geocoder();
    var callback = function(result, status) {
        if (status === daum.maps.services.Status.OK) {
            if ( result[0].road_address == null ) {
                var address = result[0].address.region_3depth_name + ' ' + result[0].address.main_address_no;
                if ( result[0].address.sub_address_no != '' ) {
                address += '- ' + result[0].address.sub_address_no;
                }
                $("#input-addr").val(address).attr('disabled',null);
            } else {
                var address = result[0].road_address.road_name + ' ' + result[0].road_address.main_building_no;
                if ( result[0].road_address.sub_building_no != '' ) {
                address += '-' + result[0].road_address.sub_building_no;
                }
                //if ( result[0].road_address.building_name != '' ) {address += ' ' + result[0].road_address.building_name;}
                
                $("#input-addr").val(address).attr('disabled',null);
            }
        }
    };
    geocoder.coord2Address(e.getLng(), e.getLat(), callback);
}

function arrangeBuildingData(data) {
    dbbuildings = [];
	for (var i = 0; i < data.length; i++) {
		var building_id;
		if (i === 0) {
			building_id = data[0].building_id;dbbuildings[0] = [];
			dbbuildings[0][0] = data[i];var j = 0;var k = 1;
		} else if (building_id === data[i].building_id) {
			dbbuildings[j][k] = data[i];k++;
		} else {
			building_id = data[i].building_id; k = 0; j++;dbbuildings[j] = [];
			dbbuildings[j][k] = data[i]; k++;
		}
	}
}

function localStorageData() { // 로컬 스토리지에 정보 저장
    localStorage.time = new Date().getTime();
    localStorage.card_id = myCard.id;
    localStorage.card_name = myCard.name;
}

function compareTime() {  // 로컬 스토리지에서 시간 불러와서 지금 시간과 비교해서 일정 시간 이내이면 true 반환 아니면 false 반환
    if ( localStorage.time == undefined ) { localStorage.time = 0 }
    
    var time_now = new Date().getTime();
    var interval = time_now - localStorage.time;
    console.log(Math.floor(interval/1000/60/60/24) + ' ' + Math.floor(interval/1000/60/60) % 24 + ' ' + Math.floor(interval/1000/60) % 60 + ' ' + Math.floor(interval/1000) % 60);
    var two_hours = 1000 * 60 * 60 * 2;
    
    if ( interval < two_hours ) {
        return true;
    } else {
        return false;
    }
}

{ // 다음 지도 관련 함수들 //
    function initDaumMap () {   // 다음 지도 시작
        var container = document.getElementById('map');
        var options = {
        center: new daum.maps.LatLng(36.8181456, 127.2413294),
        level: 8
        };
            
        DAUM_MAP = new daum.maps.Map(container, options);
        //DAUM_MAP.addOverlayMapTypeId(daum.maps.MapTypeId.OVERLAY);
        //DAUM_MAP.removeOverlayMapTypeId(daum.maps.MapTypeId.OVERLAY);
        // 오버레이 종류 OVERLAY TERRAIN TRAFFIC BICYCLE BICYCLE_HYBRID USE_DISTRICT
    }

    function setMapType(maptype) { 
        var roadmapControl = document.getElementById('btnRoadmap');
        var skyviewControl = document.getElementById('btnSkyview'); 
        if (maptype === 'roadmap') {
            DAUM_MAP.setMapTypeId(daum.maps.MapTypeId.ROADMAP);    
            roadmapControl.className = 'selected_btn';
            skyviewControl.className = 'btn';
        } else {
            DAUM_MAP.setMapTypeId(daum.maps.MapTypeId.HYBRID);    
            skyviewControl.className = 'selected_btn';
            roadmapControl.className = 'btn';
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
} // 다음 지도 관련 함수들 //

//
// 기타 함수들
//

// 마커 아이콘 설정
var marker_color = {};
    marker_color.green = 'https://lh3.googleusercontent.com/CxmJlrBdqzcili1viW_BKkWwiA5wel8-dW9djJ3gH3ghlXMZ-fzFrL2IAQ3iWvMRbvplVXwpVVe788B5PTYhFgaPuNmza4F0PNBOXWrA1uA4FLtj1sGq-SGFE_vh2v-gXV6T9JghOwy4hZYPmPGy9NW8oVLnsReoeS-vxtzW-5NEGtO12DPg-zC8VosMnbwaMeA-3AFSq29uofsK1R0tmSt6MTag18_6dVhXlmvM9IboTRfY2BCiTGP9hOXZZbDEADWbIbmza94iCITLl9rHAq4vK03hLiiSdCcW-Ky6AAitRd_uIqYsuaOAEguDKXeI-WOUFOdzVtYKvoUq-oeXScsWCTqGgrNRutqWEbvD9dqrD-u1rnEhxCOxnU9SsLH8uVXAITyj3ccrLBmG1eTByX2hTzmsH0fdUBthkcuMgWRj6FTdFIulNiaGr2ixGLye7BTEM7c_UKMmsoYL84kFsAkr2_rNu3jv_6iaUXtIbmf-IpcdC-94ndlC8TSw8aNpBUXPEPBd6YPtK-juZo8E2yxJcz1zPYGYGYA-SlUqeKHRf21-yo4_luAUNvIiMlC0BGCovXLbOyEYD37Tp4FwxRQG_cl5Ziu-DWxQwSZY_URN91mqbJ4nW2CwVjvoAvQ8sFW5KJWtDCmXcjvN2pPgZR8vstN3milj4Q=s32-no';
    marker_color.yellow = 'https://lh3.googleusercontent.com/GLb7k6hRMmA-vNyRgq1rLYWMdV-oGRXAlMVVYetdTEZoBNY9PdsLpBW9TwbAGPwfK9VrHnzrQ-OKodCzbkBJ4A2Z8SjSjaKL66M1AfQwiNUm6QC1-aTUhi1r9nPtmeRXJ9hH3O-r9s9zMzIagND9lB0ByAmThCS9on0AWKJj3p0kbhPcjBANbAjhOanFyEKLGoFQVp9RfTAw87YG80IgCtZ2AstqCP2BUOVVtM8hFYaQHz7iyRhhv-cU8rZvGyhGd-v5_fQPmBuOayy9VMLXYkXZSyljdoeQTrjRtCGagfSCXEwvs-7MHaJV6h0F-7NtbCCgeDuOGeRYtUewzSaTt-SW1n9Q562WfFRgnuqnkNYrevygwM7qEAi7dSArdP-5QPVgSUqxbID8deXBYOzRJoDCxTqLewKV0gLqToY5aUi3bqPfTQ_ysEmsJ3RCtrw1bURn3S1zl0XfyIAQNCBuooPghIBOZn3GW4WjpLKD5d_okuZA-MPVu-M_skFBwQsVGYNN-KfILUaIsllqHd3Fuw9I4INHc3ctB5Hwx1hE5D2tFN_O3vVrE2VQaai0gtg7jtmOaDfqF-7mfLa6IzL7vl7C99zgPc-AeJqr081jKo_hAatzyFfTGs79fLYhEE-Q-paJ3CFxRJgo84iAaJpihTS2uk6Z8C1o9Q=s32-no';
    marker_color.blue = 'https://lh3.googleusercontent.com/YqogPmJvUS4gNCYRvd6Md9mmD-ifWYws9c7p89sahP_eRwBa-bCYXstr5sm-_KBuCRB_DTbq5lrcLZGqeCsTW1Ay516mjUmPogn13xn9KhXVd2lVTC5w58iKZlSjp3L6uRRLZZjMQlc_TK4KLnXub7TdU7AzCqAriu2hMPiaFa6JXZ5NiJ58q9nK26ZR_RzYA3IdKh95drhEe37uTbCgXcWghYhsiMYg6AU5aIb_LQl9LjSGFEJCqd4FHnyrBqNsGOZNrYjA_38QP7bd69bFoEUBrEYZnMQEIKxz8AcINsjWlMvpPtuvaOLGWRsHL5gRXZXExEJ-jIy_SFCj_j9ZPz0UqJyivlgNUa04y3dgsK85pM7FK1Tf9B6yvMEZSlw0twYuSlxs-YQTp7Os4TD9eM6qEiKKNd0LDrxfZaUbcCclaBwdlOf6HxJJ9gEBgS4Oq5s7Xj5FKrtRWVX7HYgIIvvAprXC7yJJowFQfVeJ6PZ7K7zF57RDWD5skiRf2m6HTHvyKn6evwSdxtBOhyf-hw0ZwYe2-5wvNANMGEm5F6BQFr7tDDyPiEZH1AobrGb4QytJXQyLESUvEzpfmljuNVePRmaCbYvR1iY3SJ-E2lzTV7ESUEf4vZn9GgBm6bLhyBFiyhToJQmj1kjGlw1wDPKB0tCmM0rumQ=s32-no';
    marker_color.black = 'https://lh3.googleusercontent.com/h69trUdvFNIqD334jfwxgdvr3jGQmoWOoAUIFFTSP7SvafUtZ-iZqdYGKLp4DQKTrnekyZWD8yy9TJbsSRpvt8jI_FuglWcT_uBZ_BPZTV2MSxmsUvjDB9GrVPC7_CuXyLr33W3K2rVtCsZDH-PUyaqVmsJzVe22PZDAOr5_yKgN0IRuLUi73fU6XS3N8ImlQako6WI-kKYHkVHvrjoZtnAKU9NDNR9MhU9RaUC5j6bTMcSQVKQYfrOg4okKz-lHl4G5Iytp_ri9oH12Huk80XDek3A0uSqjxIO7X1s4HxWDMrNP7sdniEV3LmgV4RUS2d7ddJMOss72sTqj_qVcr7osfd7g1h_08xX-R2S1UkChuyDV3-Tp1r5eKjav-HhdusevMrw3jhZqkomq1bJGSoMSDqS7eRI0bi5JkSDKRHCEb6OIXGsvfQKTB7AmV4ObZ1HuasQ73gFN4hsCCTLUThDSk6ciWlHR694oDQ_eHweU8GXv4oZ1KMH4R3Ys6iDL-JOYKUDuZ0chsBAZ00qOlNi8oDbUX9d7HpOVHU3g4yiwdZy_yaqf8aOS0FqvrE2vNVK9qgda0VmpLz88UWSLXoCqeT053RBScBQQds2QowGZlYgvUZeszAwqtOzMad7_HyrpDhN-kIDTYOpmcKYICFP_ekFXaOSs4A=s32-no';
    marker_color.red = 'https://lh3.googleusercontent.com/RrE01GyjA-A501f4in4H_pejn73_uOgNy7tfAA9RqeDKZqLNM_X7yjOWnPrO42wxr5SW_s3sjkC5FC6kSWoH9ZIAium0lYguwODFjUI0UjJD4GoiK3Bb8Z5xX8lXA7UC4vYjwDLI-qKdeyXVJ_4AefE9y5LtiWzptXY92GkTSCm39WHvvVOTBFY1cWdlqPCoyl-nGSDMPZMyR8Uwmkhq6Zoch8HaJ5Cyf6otn5B2UTdBx3aMZWUnrFtrunaZRcnEbK8RoO-7sYLimlCeRBvqXy7OkmL3SQVtKs8jK8IWINOT0Fb-ZEZ6utQd_fP1eQwHWkR-o5_FKbXKEZSfG8Ekr0zIucmNhXcjUUMdMw8XhF1z_zySkQ4Ts8hn4zQZafWeMNLdY3jd7r8HeLkykHyvK6Y2wzUrX-_CD7IHOolJw1BFLSWXDG25nl8LU42e8IYgXfNrRvF8RM4No_wlSKYuvb1YKGbkRVkGhamnStTvtUJqt7FSrWzrTgWQLnG1abhTK-vNbukHHEDx4yiPRx2zXVGEWJgssPUdjgpnQSnZndrMfR-IVqinkYRGEOaevRXrnRklJr-8vfjdQ7dlJQWDacxWYx_bbblpFREzj3k9G4437IdvLnpeYiLLkiTcAQIun8Uh5IWtpcPtwVDI1XLGgWLlwSJW58sWvg=s32-no';
    marker_color.purple = 'https://lh3.googleusercontent.com/rmFBn48XlbPVHS7YrrktUv_z90Pt9SpDZZe0DbC-p4hjDg6BVRkI4GH47VuY1hFXF9Ybm22U96p7dCT5A2QFXDj_FyMxjRQ6qmUQWOY1AmghdIevDWrnAjhGs5vYqxsd3YBV2au1dsDAPLc4-7VFs3vD-R6qwzRejP3aWaj18Yw38bjII-BPMGuJ-On6hLfsJQCY6hasuvAfn3mG5WHbJVz2WxswubYqJlDdYv7UMEbjDJAdFb0JIVaAL1lHrZ35DA06TEQIFeOSCm4PpFH7L1f4xHqgP-Eu_jdRuiIYVeC_SYJx8dcmBAkHURebc--R3AE5Rz_U1ho4j7w27NCLCO11P_3yG1u8fMiGrxKF3bPQSVglFMZzUKPpBa9x2xYoLba59j80YzSjH27mmnKhPuGStUt_mWSnCiTBwRM_FQbFIH9V9IUlMmSex0RCgNGnuh6uEqezadXtI0kVoMUekcR8L7xjf1PH-WXpI6OJEdytUid4GWUmU13tz9WibUrl4JUzDR6dNYt7TVEDns6i-blgqhMGp_XJOfBWqBaYfBa3jIKZv-QUuZ-w8gQkgn9JiJf_pspzHKc-dJ0gE5FsIygdadMNWpMyIeSeAD4nocZlnKN0MLdOQTQcH_Y8vJ-lyqkwdY5GqXqgSDzhnxqlDFqfu6SeG9CeMw=s32-no';

var marker_icon_daum = {};
    marker_icon_daum.green = new daum.maps.MarkerImage(marker_color.green, new daum.maps.Size(32,32), {offset: new daum.maps.Point(16,32)});
    marker_icon_daum.red = new daum.maps.MarkerImage(marker_color.red, new daum.maps.Size(32,32), {offset: new daum.maps.Point(16,32)});
    marker_icon_daum.blue = new daum.maps.MarkerImage(marker_color.blue, new daum.maps.Size(32,32), {offset: new daum.maps.Point(16,32)});
    marker_icon_daum.black = new daum.maps.MarkerImage(marker_color.black, new daum.maps.Size(32,32), {offset: new daum.maps.Point(16,32)});
    marker_icon_daum.purple = new daum.maps.MarkerImage(marker_color.purple, new daum.maps.Size(32,32), {offset: new daum.maps.Point(16,32)});
    marker_icon_daum.yellow = new daum.maps.MarkerImage(marker_color.yellow, new daum.maps.Size(32,32), {offset: new daum.maps.Point(16,32)});

// 초기 설정. 배열, 변수 선언.

console.log(location.hostname);
var selected = [];  // 선택한 건물 저장용 임시 배열(0 수정 상태 아닐 때 건물 선택, 1 수정 상태일 때 건물 선택,)
var select_location = {}; // 서버와 통신할 때 사용할 JSON 객체(어디서 사용하는지 모름.. 항상 사용하는건 아니고 가끔 사용하는거 같은 ...... ?? )
var dbbuildings = []; // 초기 건물 데이터 가공해서 저장할 배열
var card_simple = []; // 초기 카드 데이터 저장하는 배열
//var null_house_count = 0;
