function addCategoryPop(idx){	
	$("#btnAdd").show();
	$("#btnModify").hide();
	$("#catogoryModalTitle").html('템플릿 분류 추가');
}

function setCategoryPop(idx){
	$("#category_idx").val(idx);
	$("#btnAdd").hide();
	$("#btnModify").show();
	$("#catogoryModalTitle").html('템플릿 분류 수정');
	templateCategory(idx);
}

function templateCategory(idx){
	$.ajax({
		url: "/TC_Manager/get_category_by_idx_prc",
		type: "POST",
		data: {
			idx: idx
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				$("#l_cate").val(rlt.data.l_cate).prop("selected", true);				
				var m_txt = '';
				var m_sel = '';
				var s_txt = '';
				var s_sel = '';
				$.each(rlt.data.m_cate_list, function(index, entry) {
					if(entry["idx"] == rlt.data.m_cate){m_sel = 'selected'} else {m_sel = ''};
					m_txt += "<option value='" + entry["idx"] + "' "+m_sel+">" + entry["cate_name"] + "</option>";
				});
				$("#m_cate").html("<option value=''>중분류</option>" + m_txt);
				$.each(rlt.data.s_cate_list, function(index, entry) {
					if(entry["idx"] == rlt.data.s_cate){s_sel = 'selected'} else {s_sel = ''};
					s_txt += "<option value='" + entry["idx"] + "' "+s_sel+">" + entry["cate_name"] + "</option>";
				});
				$("#s_cate").html("<option value=''>소분류</option>" + s_txt);
			}
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

// 템플릿 카테고리 정보 
function templateCategoryData(){
	$.ajax({
		url: "/TC_Manager/get_doc_template_category_prc",
		type: "POST",
		data: {
			idx: $("#template_idx").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				$("#category_area").html('');
				$.each(rlt.data, function(index, entry) {
					var c_txt = '<div id="doc_tem_cate_'+entry['idx']+'">';
					c_txt += '	<span style="font-size:20px">'+entry['l_cate_name']+' </span> ';
					if(entry['m_cate_name']){
						c_txt += '<span style="font-size:25px"> > </span><span style="font-size:20px"> '+entry['m_cate_name']+ ' </span>';
					}
					if(entry['s_cate_name']){
						c_txt += '<span style="font-size:25px"> > </span><span style="font-size:20px"> '+entry['s_cate_name']+ ' </span> ';
					}				
					c_txt += '	<a style="cursor:pointer;text-align:right" data-toggle="modal" data-target="#modifyCategory" onclick="setCategoryPop(\''+entry['idx']+ '\')">';
					c_txt += '		<i class="fa fa-wrench" style="width:30px;"></i>';
					c_txt += '	</a>';
					c_txt += '	<a style="cursor:pointer;text-align:right"  onclick="delCategory(\''+entry['idx']+ '\')">';
					c_txt += '		<i class="fa fa-close" style="width:30px;"></i>';
					c_txt += '	</a>';
					c_txt += '</div>';
					$("#category_area").append(c_txt);
				});
			}
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

function delCategory(val){
	$.ajax({
		url: "/TC_Manager/del_doc_template_category_prc",
		type: "POST",
		data: {
			tem_cate_idx: val,		
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {	
				$('#doc_tem_cate_'+val).remove();
			} else {
				//alert(rlt.msg);				
				return;
			}
		},
		error: function(request, status, error) {
			alert("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
		}
	});
}


function templateDetailData(){
	$.ajax({
		url: "/TC_Manager/get_template_detail_prc",
		type: "POST",
		data: {
			idx: $("#template_idx").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){				
				templateCategoryData();

				$('#tem_title').val(rlt.data.tem_title);
				$('#tem_memo').val(rlt.data.tem_memo);
				if(rlt.data.img_path != '' && rlt.data.img_path != null && rlt.data.img_name != '' && rlt.data.img_name != null){
					$("#viewImg").attr("src", rlt.data.img_path+'/'+rlt.data.img_name);
				}
				var spread = GC.Spread.Sheets.findControl(document.getElementById('ss')); 
				var serializationOption = {					
					ignoreStyle: false,
					ignoreFormula: false,
					saveAsView: false,
					rowHeadersAsFrozenColumns: false,
					columnHeadersAsFrozenRows: false,
					includeAutoMergedCells: false,
					includeBindingSource: true,
				};
				var spread2 = GC.Spread.Sheets.findControl(document.getElementById('excel_area')); 
				
				spread2.suspendPaint();
				spread2.suspendCalcService();
				spread2.suspendEvent();
				spread2.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  serializationOption);
				spread2.resumePaint();
				spread2.resumeEvent();
				spread2.resumeCalcService();

				$('#View').attr("src",rlt.data.img_path+"/"+rlt.data.img_name);
			}
			else alert("ERROR");
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

function getCategoryIdx(cate_type){
	var cateIdx = "";
	var selIdx = "";
	switch(cate_type){
		case 'L': 
			cateIdx = $("#l_cate_idx").val();
			selIdx = $("#m_cate_idx").val();
			if(cateIdx == ''){
				$("#m_cate").html("<option value=''>중분류</option>");
				$("#s_cate").html("<option value=''>소분류</option>");
			}
		break;
		case 'M': 
			cateIdx = $("#m_cate_idx").val();
			selIdx = $("#s_cate_idx").val();
		break;		
	}

	$.ajax({
		url: "/TC_Manager/get_category_list_prc",
		type: "POST",
		data: {
			cate_idx: cateIdx,		
		},
		dataType: "json",
		success: function(rlt) {
			if (rlt.code == 200) {
				var m_txt = "";
				var selected = "";
				$.each(rlt.data, function(index, entry) {
					selected = "";
					if(selIdx == entry["idx"]){
						selected = "selected";
					} 					
					m_txt += "<option value='" + entry["idx"] + "' "+selected+">"+entry["cate_name"]+"</option>";										
				});
				switch(cate_type){
					case 'L': 
						$("#m_cate").html("<option value=''>중분류</option>"+m_txt);
						$("#s_cate").html("<option value=''>소분류</option>");
					break;
					case 'M': 
						$("#s_cate").html("<option value=''>소분류</option>"+m_txt);
					break;	
				}
			} else {
				//alert(rlt.msg);				
				return;
			}
		},
		error: function(request, status, error) {
			alert("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
		}
	});
}

function templatModifySubmit(frm) {	
	var titleCheck = frm.tem_title.value;
	var memoCheck = frm.tem_memo.value;
	
	// 제목
	if(!titleCheck) {
		showNotification("alert-warning", "제목을 입력해 주세요.", "top", "center", "", "");
		return false;
	}
	// 메모
	if(!memoCheck) {
		showNotification("alert-warning", "메모를 입력해 주세요.", "top", "center", "", "");
		return false;
	}	
	var jsonOptions = {
			ignoreFormula: false,
			ignoreStyle: false,
			frozenColumnsAsRowHeaders: false,
			frozenRowsAsColumnHeaders: false,
			doNotRecalculateAfterLoad: false,
			incrementalLoading: true,
			includeBindingSource: true 
	};
	var spread1 = GC.Spread.Sheets.findControl(document.getElementById('excel_area'));
	var jsonString = JSON.stringify(spread1.toJSON(jsonOptions));

	var formData = new FormData(frm);
	formData.append("tem_data", jsonString)

	$.ajax({
		url: "/TC_Manager/modify_template_prc",
		type: "POST",
		dataType: 'json',
		enctype: 'multipart/form-data',
		processData:false,
		contentType:false,
		data: formData,
		success: function(rlt) {
			if (rlt.code == 200) {
				showNotification("alert-success", "등록 되었습니다.", "top", "center", "", "");
				location.replace('/TC_Manager/document/template');
			}
			else {
				alert('AA');
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

// 카테 고리 추가 
function addDocTemCate(){
	var tem_idx = $("#template_idx").val();
	var l_cate = $("#l_cate").val();
	var m_cate = $("#m_cate").val();
	var s_cate = $("#s_cate").val();


	$.ajax({
		url: "/TC_Manager/add_doc_templay_category_prc",
		type: "POST",
		data: {
			tem_idx: tem_idx,
			l_cate: l_cate,
			m_cate: m_cate,
			s_cate: s_cate
		},
		dataType: "json",
		success: function (rlt) {
			if (rlt.code == 200) {
				templateCategoryData();
				showNotification("alert-success", "등록 되었습니다.", "top", "center", "", "");
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

// 템플릿 문서 기존 캬테고리 수정 
function modifyDocTemCate(){
	var cate_idx = $("#category_idx").val();
	var l_cate = $("#l_cate").val();
	var m_cate = $("#m_cate").val();
	var s_cate = $("#s_cate").val();
	$.ajax({
		url: "/TC_Manager/modify_doc_templay_category_prc",
		type: "POST",		
		data: {
			cate_idx: cate_idx,
			l_cate: l_cate,
			m_cate: m_cate,
			s_cate: s_cate
		},
		dataType: "json",
		success: function (rlt) {
			if (rlt.code == 200) {
				templateCategoryData();
				showNotification("alert-success", "등록 되었습니다.", "top", "center", "", "");				
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#View').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), {calcOnDemand: true});
	var excelIo = new GC.Spread.Excel.IO();
	GC.Spread.Common.CultureManager.culture("ko-kr");
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);
	templateDetailData();

	$("#tem_img").on('change', function(){
		readURL(this);
	});
}