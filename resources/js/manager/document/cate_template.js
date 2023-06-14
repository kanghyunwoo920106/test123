// 대분류 카테고리 이름 변경
function changeCate(idx){
	var cate_name = $("#ch_name_"+idx).val();
	$.ajax({
		url: "/TC_Manager/change_category_name_prc",
		type: "POST",
		dataType: "json",		
		data: {
			idx : idx,
			cateName : cate_name
		},
		success: function (rlt) {
			if (rlt.code == 200) {
				$("#heading_" + rlt.data.idx + " .panel-title").html(rlt.data.cate_name);
				$("#v-pills-"+rlt.data.active_code+"-tab").html(rlt.data.cate_name);
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

// 
function subCateChangeNamePop(idx, cate_name){
	$("#ch_category_idx").val(idx);
	$("#ch_category_name").attr("placeholder", cate_name);
}

function subCateChanageName(){
	var idx = $("#ch_category_idx").val();
	var cate_name = $("#ch_category_name").val();
	$.ajax({
		url: "/TC_Manager/change_category_name_prc",
		type: "POST",
		dataType: "json",		
		data: {
			idx : idx,
			cateName : cate_name
		},
		success: function (rlt) {
			if (rlt.code == 200) {
				$("#sub_cate_name_"+rlt.data.idx).html(rlt.data.cate_name);
				$("#modifySubCate").modal('hide');
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

function delSubCate(idx){
	if(confirm($("#sub_cate_name_"+idx).html() + " 카테고리를 삭제 하시겠습니까?")) {
		$.ajax({
			url: "/TC_Manager/del_category_prc",
			type: "POST",
			dataType: "json",		
			data: {
				idx: idx
			},
			success: function (rlt) {
				if (rlt.code == 200) {
					$("#sub_cate_li_"+idx).remove();
				}
			},
			error: function (request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			},
		});
	}
}
function delCate(idx){	
	if(confirm($("#heading_"+idx+" .panel-title").html() + " 카테고리를 삭제 하시겠습니까?")) {
		$.ajax({
			url: "/TC_Manager/del_category_prc",
			type: "POST",
			dataType: "json",		
			data: {
				idx: idx
			},
			success: function (rlt) {
				if (rlt.code == 200) {
					$("#panel_" + rlt.data.idx ).remove();
					$("#v-pills-"+rlt.data.active_code+"-tab").remove();
				}
			},
			error: function (request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			},
		});
	}
}

// 대분류 카테고리 추가
function addMainCategory(){
	var reg_cate_name = /^[가-힣a-zA-Z0-9 ]{2,}$/;

	var category_name = $("#category-name").val().trim();
	if(!reg_cate_name.test(category_name)) {
		showNotification("alert-warning", "카테고리명을 영문, 한글, 숫자로 2자이상 입력해 주세요.", "top", "center", "", "");
		return false;
	}
	$.ajax({
		url: "/TC_Manager/add_category_prc",
		type: "POST",
		dataType: "json",		
		data: {
			cate_idx: 0,
			cate_type: "L",
			cate_name: category_name
		},
		success: function (rlt) {
			if (rlt.code == 200) {
				var l_txt = "";
				var m_txt = "";
				$("#addMainCate").modal('hide');
				l_txt = "<a class='nav-link' id='v-pills-"+rlt.data.active_code+"-tab' data-toggle='pill' href='#v-pills-"+rlt.data.active_code+"' role='tab' aria-controls='v-pills-"+rlt.data.active_code+"' aria-selected='false' onclick='setMiddleCate(\""+rlt.data.idx+"\")'>";
				l_txt += rlt.data.cate_name;
				l_txt += "</a>";
				$("#v-pills-tab").append(l_txt);


				m_txt = "<div class='tab-pane fade' id='v-pills-"+rlt.data.active_code+"' role='tabpanel' aria-labelledby='v-pills-"+rlt.data.active_code+"-tab'>";
				m_txt += "	<ul class='nav navbar-right'>";
				m_txt += "		<li style='height:45px;width:30px;text-align:center;cursor:pointer;'>";
				m_txt += "			<a class='' data-toggle='modal' data-target='#addMiddleCate'><i class='fa fa-plus'></i></a>";
				m_txt += "		</li>";
				m_txt += "	</ul>";
				m_txt += "	<ul class='to_do middle_cate_list' id='sub_cate_"+rlt.data.idx+"'>";
				m_txt += "		<li id='no_middle_cate_"+rlt.data.idx+"'>하위메뉴추가필요</li>";
				m_txt += "	</ul>";
				m_txt += "</div>";
				$("#v-pills-tabContent").append(m_txt)
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

function mainReorder(callback) {
	$(".panel").each(function(i, box) {
		$.ajax({
			url: "/TC_Manager/up_category_sort_prc",
			type: "post",
			data: {
				cate_idx : $(box).find(".cate_idx").val(),
				sort_num : i + 1,
			},
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {					
				}
				else {
					alert(result.msg);
				}
			}			
		});
	});
	callback();
}

// 중분류 카테고리 추가
function addMiddleCatagory(){
	var mcate_idx = $("#main_cate_idx").val();
	var reg_cate_name = /^[가-힣a-zA-Z0-9 ]{2,}$/;

	var sub_category_name = $("#sub-category-name").val().trim();
	if(!reg_cate_name.test(sub_category_name)) {
		showNotification("alert-warning", "카테고리명을 영문, 한글, 숫자로 2자이상 입력해 주세요.", "top", "center", "", "");
		return false;
	}

	$.ajax({
		url: "/TC_Manager/add_category_prc",
		type: "POST",
		dataType: "json",		
		data: {
			cate_idx: mcate_idx,
			cate_type: "M",
			cate_name: sub_category_name
		},
		success: function (rlt) {
			if (rlt.code == 200) {
				$("#no_middle_cate_"+mcate_idx).remove();
				var s_txt = "<li data-toggle='tab' href='#v-pills-small-"+rlt.data.active_code+"' id='sub_cate_li_"+rlt.data.idx+"'>";
				s_txt +="	<input type='hidden' class='sub_cate_idx' value='"+rlt.data.idx+"'>";
				s_txt +="	<div onclick='setSmallleCate(\""+rlt.data.idx+"\")'><a style='cursor:pointer;' id='sub_cate_name_"+rlt.data.idx+"'>"+rlt.data.cate_name+"</a></div>";
				s_txt +="	<div style='text-align:right;'>";
				s_txt +="		<a style='cursor:pointer;' data-toggle='modal' data-target='#modifySubCate' onclick='subCateChangeNamePop(\""+rlt.data.idx+"\", \""+rlt.data.cate_name+"\")'><i class='fa fa-wrench' style='width:25px;'></i></a>";
				s_txt +="		<a style='cursor:pointer;' onclick='delSubCate(\""+rlt.data.idx+"\")'><i class='fa fa-close' style='width:25px;'></i></a>";
				s_txt +="	</div>";									
				s_txt +="</li>";
				
				$('#sub_cate_'+mcate_idx).append(s_txt);

				$("#addMiddleCate").modal('hide');
			}
			else {
				alert("ERROR");
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

function mainCateList(){
	var m_txt = "";
	var s_txt = "";
	$.ajax({
		url: "/TC_Manager/get_category_list_prc",
		type: "post",
		data: {
			cate_idx: '0'
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {
				$.each(rlt.data, function(index, entry) {
					m_txt +="<a class='nav-link' id='v-pills-"+entry["active_code"]+"-tab' data-toggle='pill' href='#v-pills-"+entry["active_code"]+"' role='tab' aria-controls='v-pills-"+entry["active_code"]+"' aria-selected='false' onclick='setMiddleCate(\""+entry["idx"]+"\")'>"
					m_txt += 	entry["cate_name"];
					m_txt +="</a>";

					s_txt += "<div class='tab-pane fade' id='v-pills-"+entry["active_code"]+"' role='tabpanel' aria-labelledby='v-pills-"+entry["active_code"]+"-tab'>";
					s_txt += "	<ul class='nav navbar-right'>";
					s_txt += "		<li style='height:45px;width:30px;text-align:center;cursor:pointer;'>";
					s_txt += "			<a data-toggle='modal' data-target='#addMiddleCate'><i class='fa fa-plus'></i></a>";
					s_txt += "		</li>";
					s_txt += "	</ul>";
					s_txt += "	<ul class='to_do middle_cate_list' id='sub_cate_"+entry["idx"]+"'></ul>";
					s_txt += "</div>";
				})
				$("#v-pills-tab").html("");
				$("#v-pills-tab").html(m_txt);

				$("#v-pills-tabContent").html("");
				$("#v-pills-tabContent").html(s_txt);
				$("#v-pills-tabContent-sub").html("");
			}
			else {
				showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
				//alert(rlt.msg);
			}
		}			
	});
}

// 중분류 관리
function setMiddleCate(idx){
	$.ajax({
		url: "/TC_Manager/get_category_dt_prc",
		type: "post",
		data: {
			idx: idx
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {
				$("#main_cate_idx").val(rlt.data.idx);
				$("#main_active_code").val(rlt.data.active_code);
				middleCateList(rlt.data.idx);
			}
			else {
				$("#sub_cate_"+idx).html("<li id='no_middle_cate_"+idx+">하위 메뉴 없음</li>");
			}
		}			
	});
}

function middleCateList(idx){
	var s_txt = "";
	var f_txt = "";
	$.ajax({
		url: "/TC_Manager/get_category_list_prc",
		type: "post",
		data: {
			cate_idx: idx
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {
				$.each(rlt.data, function(index, entry) {
					s_txt +="<li data-toggle='tab' href='#v-pills-small-"+entry["active_code"]+"' id='sub_cate_li_"+entry["idx"]+"'>";
					s_txt +="	<input type='hidden' class='sub_cate_idx' value='"+entry["idx"]+"'>";
					s_txt +="	<div onclick='setSmallleCate(\""+entry["idx"]+"\")'><a style='cursor:pointer;' id='sub_cate_name_"+entry["idx"]+"'>"+entry["cate_name"]+"</a></div>";
					s_txt +="	<div style='text-align:right;'>";
					s_txt +="		<a style='cursor:pointer;' data-toggle='modal' data-target='#modifySubCate' onclick='subCateChangeNamePop(\""+entry["idx"]+"\", \""+entry["cate_name"]+"\")'><i class='fa fa-wrench' style='width:25px;'></i></a>";
					s_txt +="		<a style='cursor:pointer;' onclick='delSubCate(\""+entry["idx"]+"\")'><i class='fa fa-close' style='width:25px;'></i></a>";
					s_txt +="	</div>";									
					s_txt +="</li>";

					f_txt += "<div class='tab-pane fade' id='v-pills-small-"+entry["active_code"]+"'>";
					f_txt += "	<ul class='nav navbar-right'>";
					f_txt += "		<li style='height:45px;width:30px;text-align:center;'>";
					f_txt += "			<a style='cursor:pointer;' data-toggle='modal' data-target='#addSmallCate'><i class='fa fa-plus'></i></a>";
					f_txt += "		</li>";
					f_txt += "	</ul>";
					f_txt += "	<ul class='to_do small_cate_list' id='small_cate_"+entry["idx"]+"'>";
					f_txt += "	</ul>";
					f_txt += "</div>";
				})
				$("#sub_cate_"+idx).html("");			
				$("#v-pills-tabContent-sub").html("");

				$("#sub_cate_"+idx).html(s_txt);

				$("#v-pills-tabContent-sub").html(f_txt);
				$("#sub_cate_"+idx).sortable({
					stop: function(event, ui) {			
						middleReorder($("#main_active_code").val());
					}
				});
			}
			else {
				$("#sub_cate_"+idx).html("<li id='no_middle_cate_"+idx+"'>하위 메뉴 없음</li>");
				$("#v-pills-tabContent-sub").html("");
			}
		}			
	});
}

function middleReorder(act_code) {
	$("#v-pills-"+act_code+" .to_do li").each(function(i, box) {
		$.ajax({
			url: "/TC_Manager/up_category_sort_prc",
			type: "post",
			data: {
				cate_idx : $(box).find(".sub_cate_idx").val(),
				sort_num : i + 1,
			},
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {					
				}
				else {
					alert(result.msg);
				}
			}			
		});
	});
}

//# 소분류
function addSmallCatagory(){
	var mcate_idx = $("#sub_cate_idx").val();
	var reg_cate_name = /^[가-힣a-zA-Z0-9 ]{2,}$/;
	var s_txt = "";

	var small_category_name = $("#small_category_name").val().trim();
	if(!reg_cate_name.test(small_category_name)) {
		showNotification("alert-warning", "카테고리명을 영문, 한글, 숫자로 2자이상 입력해 주세요.", "top", "center", "", "");
		return false;
	}

	$.ajax({
		url: "/TC_Manager/add_category_prc",
		type: "POST",
		dataType: "json",		
		data: {
			cate_idx: mcate_idx,
			cate_type: "S",
			cate_name: small_category_name
		},
		success: function (rlt) {
			if (rlt.code == 200) {
					$('#no_small_cate_'+mcate_idx).remove();
					s_txt +="<li data-toggle='tab' id='sub_cate_li_"+rlt.data.idx+"'>";
					s_txt +="	<input type='hidden' class='small_cate_idx' value='"+rlt.data.idx+"'>";
					s_txt +="	<div><p id='sub_cate_name_"+rlt.data.idx+"'>"+rlt.data.cate_name+"</p></div>";
					s_txt +="	<div style='text-align:right;'>";
					s_txt +="		<a style='cursor:pointer;' data-toggle='modal' data-target='#modifySubCate' onclick='subCateChangeNamePop(\""+rlt.data.idx+"\", \""+rlt.data.cate_name+"\")'><i class='fa fa-wrench' style='width:25px;'></i></a>";
					s_txt +="		<a style='cursor:pointer;' onclick='delSubCate(\""+rlt.data.idx+"\")'><i class='fa fa-close' style='width:25px;'></i></a>";
					s_txt +="	</div>";
					s_txt +="</li>";
				
				$('#small_cate_'+mcate_idx).append(s_txt);
				$("#addSmallCate").modal('hide');
			}
			else {
				alert("ERROR");
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});

}

function smallCateList(idx){
	var s_txt = "";	
	$.ajax({
		url: "/TC_Manager/get_category_list_prc",
		type: "post",
		data: {
			cate_idx: idx
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {
				$.each(rlt.data, function(index, entry) {
					s_txt +="<li data-toggle='tab' id='sub_cate_li_"+entry["idx"]+"'>";
					s_txt +="	<input type='hidden' class='small_cate_idx' value='"+entry["idx"]+"'>";
					s_txt +="	<div><p id='sub_cate_name_"+entry["idx"]+"'>"+entry["cate_name"]+"</p></div>";
					s_txt +="	<div style='text-align:right;'>";
					s_txt +="		<a style='cursor:pointer;' data-toggle='modal' data-target='#modifySubCate' onclick='subCateChangeNamePop(\""+entry["idx"]+"\", \""+entry["cate_name"]+"\")'><i class='fa fa-wrench' style='width:25px;'></i></a>";
					s_txt +="		<a style='cursor:pointer;' onclick='delSubCate(\""+entry["idx"]+"\")'><i class='fa fa-close' style='width:25px;'></i></a>";
					s_txt +="	</div>";
					s_txt +="</li>";						
				})
				$("#small_cate_"+idx).html("");
				$("#small_cate_"+idx).html(s_txt);

				$("#small_cate_"+idx).sortable({
					stop: function(event, ui) {			
						smallReorder($("#sub_active_code").val());
					}
				});
			}
			else {
				$("#small_cate_"+idx).html("<li id='no_small_cate_"+idx+"'>하위 메뉴 없음</li>");
			}
		}			
	});
}

function setSmallleCate(idx){
	$.ajax({
		url: "/TC_Manager/get_category_dt_prc",
		type: "post",
		data: {
			idx: idx
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {
				$("#sub_cate_idx").val(rlt.data.idx);
				$("#sub_active_code").val(rlt.data.active_code);
				smallCateList(rlt.data.idx);
			}
			else {
				$("#small_cate_"+idx).html("<li id='no_small_cate_"+idx+"'>하위 메뉴 없음</li>");
			}
		}			
	});
}

function smallReorder(act_code) {
	$("#v-pills-small-"+act_code+" .to_do li").each(function(i, box) {
		$.ajax({
			url: "/TC_Manager/up_category_sort_prc",
			type: "post",
			data: {
				cate_idx : $(box).find(".small_cate_idx").val(),
				sort_num : i + 1,
			},
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {					
				}
				else {
					alert(result.msg);
				}
			}			
		});
	});
}

$(document).ready(function () {
	$('.modal').on('hidden.bs.modal', function (e) {
		$(this).find('form')[0].reset();
	});

	$("#accordion").sortable({
		start: function(event, ui) {
			
		},		
		stop: function(event, ui) {			
			mainReorder(
				function(){
					mainCateList();
				}
			);			
        }
	});	
});