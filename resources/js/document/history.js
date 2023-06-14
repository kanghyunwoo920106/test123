function viewDocData(){
	lodingModal('show');
	$.ajax({
		url: "/Doc/get_doc_detail_prc",
		type: "POST",
		data: {
			doc_id: $("#doc_id").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				$('#doc_title').val(rlt.data.doc_title);
				$('#doc_memo').val(rlt.data.doc_memo);
				$("#act-color").attr("class", "color-label "+rlt.data.doc_color_dt);
				$("#act-color").attr("data-color", rlt.data.doc_color_dt);
				if(rlt.data.url_share != '' && rlt.data.url_share != false){
					$('#share_url_val').val($('#web_url').val()+'/Share/doc/'+rlt.data.url_share);
					$('#share_url_html').html($('#web_url').val()+'/Share/doc/'+rlt.data.url_share);
				}
                var spread = GC.Spread.Sheets.findControl(document.getElementById('excel_area')); 
				spread.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  { ignoreFormula: true });
				setTimeout(function() {
					lodingModal('hide');
				}, 1000);
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");
				setTimeout(function() {
					location.replace('/TCmain');
				}, 1000);
			}; 
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {
				location.replace('/');
			}, 1000);
		}
	});
}

function getDocHistoryList(){
	lodingModal('show');
	var docId = $('#doc_id').val();
	$.ajax({
		url: "/Doc/get_doc_history_list_prc",
		type: "POST",
		data: {
			doc_id: docId
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code==200){
				var str_txt = '';
				$.each(rlt.data, function(index, entry) {
					str_txt += '<input type="radio" class="btn-check" name="options-outlined" id="history_list'+entry['idx']+'" autocomplete="off">';
					str_txt += '<label class="btn btn-outline-secondary myfile-writer" for="history_list'+entry['idx']+'" onclick="getDocHistoryData(\''+entry['idx']+'\')">';
					str_txt += '	'+entry['reg_date']+'	';
					str_txt += '	<p><span>편집자</span>'+entry['his_info']+'</p>';
					str_txt += '</label>';
				});
				$("#history_list").append(str_txt);
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");			
			}
			$('#history_list_loading').hide();
			setTimeout(function() {
					lodingModal('hide');
				}, 1000);
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {
				location.replace('/');
			}, 1000);
		}
	});	
}

function getDocHistoryData(id){
	lodingModal('show');
	$('#sel_his_id').val(id);
	var hisId = id;
	var docId = $('#doc_id').val();	
	$.ajax({
		url: "/Doc/get_doc_history_data_prc",
		type: "POST",
		data: {
			doc_id: docId,
			his_id: hisId
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code==200){
				var spread = GC.Spread.Sheets.findControl(document.getElementById('excel_area')); 
				spread.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  { ignoreFormula: true });
				$('#doc_ht').val('S');
				
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
			setTimeout(function() {
					lodingModal('hide');
				}, 1000);
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {
				location.replace('/');
			}, 1000);
		}
	});	
}


// 선택한 문서로 복원 처리 
function selDocHistoryData(id){		
	var docId = $('#doc_id').val();
	var hisId = $('#sel_his_id').val();
	if(hisId == ''){
		showNotification("alert-warning", '복구 시점을 선택해 주세요', "top", "center", "", "");		
		return;
	}
	lodingModal('show');
	$.ajax({
		url: "/Doc/restore_doc_prc",
		type: "POST",
		data: {
			doc_id: docId,
			his_id: hisId
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code==200){
				showNotification("alert-success", "변경 되었습니다.", "top", "center", "", "");
				setTimeout(function() {
					location.replace('/Doc/view/'+docId);
				}, 1000);
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");
				setTimeout(function() {
					lodingModal('hide');
				}, 1000);
			}
		},
		error: function(request, status, error) {			
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {
				location.replace('/');
			}, 1000);			
		}
	});	
}
window.onload = function(){
	basicOption = {
		showHorizontalScrollbar:true,
		showVerticalScrollbar:true,
		scrollbarMaxAlign:true,
		scrollbarShowMax:true,
		calcOnDemand: true
	};
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), basicOption);
	var theme = new GC.Spread.Sheets.Theme("koCustomTheme", GC.Spread.Sheets.ThemeColors.Office, "맑은 고딕", "맑은 고딕");
	spread.sheets.forEach(function (item) {item.currentTheme(theme);});
	const body = document.querySelector('body');
	body.classList.add('toggle-history');
	document.getElementById("go-back").addEventListener("click", () => {
		history.back();
	});
	viewDocData();
	getDocHistoryList()
};