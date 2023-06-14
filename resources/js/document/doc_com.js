function viewDocData(){
	try {
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
					spread2.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  serializationOption);

					var sheet = spread2.getActiveSheet();
				printInfo = sheet.printInfo();
				printInfo.showColumnHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
				printInfo.showRowHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
				printInfo.showBorder(false);


					lodingModal('hide', 'T');
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
	} catch (e) {
		console.log('코드의 실행 흐름이 catch 블록으로 옮겨집니다.');
		alert(`다음과 같은 에러가 발생했습니다: ${e.name}: ${e.message}`);
	}
}

function viewsDocData(){
	try {
	lodingModal('show');
	$.ajax({
		url: "/Doc/get_doc_share_detail_prc",
		type: "POST",
		data: {
			doc_id: $("#doc_id").val(),
			share_id: $("#share_id").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				if(rlt.type == 'M'){
					$('#save_btn').html('<button type="submit" class="btn btn-green mb-2 btn-sm" onclick="modifyDocData()"><i class="bi bi-save"></i> 저장</button>');
					var she_txt = "";
					if(rlt.data.shd.stype == 'part'){
						$.each(rlt.data.shd.list, function (index, entry) {
							if(entry[1] == 'M'){
								she_txt += '<div class="p-3"><span class="authority-possible"><i class="bi bi-unlock-fill"></i> [편집가능]</span> '+rlt.data.shd.sh_name[entry[0]]+'</div>';
							}
							else {
								she_txt += '<div class="p-3"><span class="authority-impossible"><i class="bi bi-lock-fill"></i> [편집불가능]</span> '+rlt.data.shd.sh_name[entry[0]]+'</div>'
							}
						});
						$('#shd_list').prepend(she_txt);						
					}
					else {
						$('#share_info_txt').html('<i class="bi bi-exclamation-circle"></i> 본 파일은 편집이 가능한 파일입니다. <br>편집 저장시 공유한 원본파일이 수정되므로 저장에 유의하시기 바랍니다.');
						$('#shd_list').prepend('<div class="p-3"><span class="authority-possible"><i class="bi bi-unlock-fill"></i> [편집가능]</span> 전체 </div>');
					}
					$('body').addClass('toggle-file-authority');
				} else {
					$('#share_info_txt').html('<i class="bi bi-exclamation-circle"></i> 본 파일은 보기 전용파일로 편집권한이 없습니다. 편집을 해도 원본파일에 저장이 되지 않습니다.');
					$('#shd_list').prepend('<div class="p-3"><span class="authority-possible"><i class="bi bi-eye"></i> [보기전용]</span></div>');
				}

				$('#doc_title_txt').html(rlt.data.doc_title);
				$('#doc_title').val(rlt.data.doc_title);
				$('#doc_memo').val(rlt.data.doc_memo);
				$("#doc_act_color").attr("class", "color-label "+rlt.data.doc_color_dt);
				

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
				spread2.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  serializationOption);
				var sheet = spread2.getActiveSheet();
				printInfo = sheet.printInfo();
				printInfo.showColumnHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
				printInfo.showRowHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
				printInfo.showBorder(false);

				lodingModal('hide', 'T');
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
	} catch (e) {
	  console.log('코드의 실행 흐름이 catch 블록으로 옮겨집니다.');
	  alert(`다음과 같은 에러가 발생했습니다: ${e.name}: ${e.message}`);
	}
}

function upDocMemo(){
	lodingModal('show');
	$.ajax({
		url: "/Doc/up_doc_memo_prc",
		type: "POST",
		data: {
			doc_id: $("#doc_id").val(),
			doc_memo: $("#doc_memo").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", "메모가 수정 되었습니다.", "top", "center", "", "");
				lodingModal('hide', 'T');
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");				
				setTimeout(function() {
					location.replace('/Doc/view/'+doc_id);
				}, 1000);
			}; 
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			lodingModal('hide', 'T');
		}
	});
}