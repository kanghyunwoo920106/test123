function viewDocData(){
	lodingModal('show');
	$.ajax({
		url: "/Share/get_documet_prc",
		type: "POST",
		data: {
			shcd_en: $("#shcd_en").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				var title_txt = '';
				var info_txt = '';
				if(rlt.type == 'M'){
					$('#save_btn').html('<button type="submit" class="btn btn-green mb-2 btn-sm" onclick="modifyDocData()"><i class="bi bi-save"></i> 저장</button>');
					$('#share_info_txt').html('<i class="bi bi-exclamation-circle"></i> 본 파일의 사용권한을 확인해주세요. <br>편집권한이 없을경우 편집을 해도 저장이 되지 않습니다.<br><br><i class="bi bi-exclamation-circle"></i> 시트명 순서와 시트추가는 변경할 수 없으며 편집하여도 원본파일에 저장이 되지 않습니다.');
					var she_txt = "";
					if(rlt.data.shd.stype == 'part'){
						$('#dtype_dom').addClass('text-bg-warning');
						$('#dtype_dom').html('<i class="bi bi-lock-fill"></i> 일부편집가능');
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
						$('#dtype_dom').addClass('text-bg-green');
						$('#dtype_dom').html('<i class="bi bi-unlock-fill"></i> 편집가능');						
						$('#share_info_txt').html('<i class="bi bi-exclamation-circle"></i> 본 파일은 편집이 가능한 파일입니다. <br>편집 저장시 공유한 원본파일이 수정되므로 저장에 유의하시기 바랍니다.');
						$('#shd_list').prepend('<div class="p-3"><span class="authority-possible"><i class="bi bi-unlock-fill"></i> [편집가능]</span> 전체</div>');						
					}
					$('body').addClass('toggle-file-authority');
				}
				else {
					$('#dtype_dom').addClass('text-bg-primary');
					$('#dtype_dom').html('<i class="bi bi-eye"></i> 보기전용');
					$('#share_info_txt').html('<i class="bi bi-exclamation-circle"></i> 본 파일은 보기 전용파일로 편집권한이 없습니다. <br> 편집을 해도 원본파일에 저장이 되지 않습니다.');					
				}
				$('#doc_title').html(rlt.data.doc_title);
				$('#doc_memo').val(rlt.data.doc_memo);

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
				setTimeout(function() {
					lodingModal('hide');
				}, 1000);
			}
			else {
				location.replace('/Share/error_prc');				
			}
		},
		error: function(request, status, error) {
			location.replace('/Share/error_prc');
		}
	});
}