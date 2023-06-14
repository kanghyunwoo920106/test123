function modifyDocData(){
	lodingModal('show');
	var docId = $('#doc_id').val();
	var titleValue = $('#doc_title').val();	
	var colorValue = $('#act-color').attr("data-color");
	
	// 제목
	if(titleValue == ''){
		titleValue = "내 문서 타이틀 명";
	}

	var jsonOptions = {
			ignoreFormula: false,
			ignoreStyle: false,
			frozenColumnsAsRowHeaders: false,
			frozenRowsAsColumnHeaders: false,
			doNotRecalculateAfterLoad: false,
			incrementalLoading: true
	};

	// 템플릿 테이터 	
	var spread1 = GC.Spread.Sheets.findControl(document.getElementById('excel_area'));
	var jsonString = JSON.stringify(spread1.toJSON(jsonOptions));

	var printInfo = new GC.Spread.Sheets.Print.PrintInfo();
	printInfo.showColumnHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
	printInfo.showRowHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
	printInfo.showBorder(false);

	
	$.ajax({
		url: "/Doc/modify_doc_prc",
		type: "POST",
		data: {
			doc_id: docId,
			doc_title: titleValue,			
			doc_color: colorValue,
			doc_data: jsonString
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", "수정 되었습니다.", "top", "center", "", "");				
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");
			}
			setTimeout(function() {
				lodingModal('hide');
			}, 1000);			
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});	
}

// 공유 멤버 수정 
function modalMemPop(){
	var docId = $('#doc_id').val();
	$.ajax({
		url: "/Doc/mem_modal_pop_prc",
		type: "POST",
		data: {
			doc_id: docId
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				var she_txt = '';
				var mem_txt = '';
				$.each(rlt.data.sheet, function (index, entry) {				
					she_txt += '<li class="list-group-item">';
					she_txt += '	<input class="form-check-input me-1 sheet_lt" type="checkbox" name="sheet_lt" value="'+entry['sheet_id']+'" id="'+entry['sheet_id']+'">';
					she_txt += '	<label class="form-check-label" for="'+entry['sheet_id']+'"><span>'+entry['sheet_name']+'</span></label>';
					she_txt += '</li>';
				});

				$.each(rlt.data.mem, function (index, entry) {
					mem_txt += '<li class="list-group-item">';
					mem_txt += '	<input class="form-check-input me-1 mem_lt" type="checkbox" name="mem_lt" value="'+entry['idx']+'" id="mem_'+entry['idx']+'">';
					mem_txt += '	<label class="form-check-label" for="firstCheckbox">'+entry['mem_name']+' <span>'+entry['mem_email']+'</span></label>';
					mem_txt += '</li>';
				});
				$('#modal_share_sheet_list').html(she_txt);
				$('#modal_share_mem_list').html(mem_txt);
				$('#share-add-modal').modal('show');
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		}
	});
}

function modalChangeShareType(str){
	$('#modal_share_type').val(str);
}
// 현재 공유 멤버 리스트 
function getDocShareaMem(){
	var docId = $('#doc_id').val();
	var pageNm = $('#share_page').val();

	$.ajax({
		url: '/Doc/get_doc_mem_share_data_prc',
		type: 'POST',
		data: {
			doc_id: docId,
			page_nm: pageNm
		},
		dataType: 'json',
		success: function (rlt) {
			if( rlt.code == 200 ){
				var mem_txt = '';
				$.each(rlt.data, function (index, entry) {
					var sheetObj = JSON.parse(entry['sheet_id']);
					mem_txt += '<a class="row mb-3" aria-current="true" id="'+entry['share_code']+'">';
					mem_txt += '	<div class="row">';
					if(entry['user_check'] == 0){
						mem_txt += '		<div class="col-auto"><img src="/resources/images/no-join-img.png" alt="Profile" class="rounded-circle add-img"></div>';
					}
					else {
						if(entry['user_img_path'] != null && entry['user_img_name'] != null ){
						mem_txt += '		<div class="col-auto"><img src="'+entry['user_img_path']+'/'+entry['user_img_name']+'" alt="Profile" class="rounded-circle add-img"></div>';
						}else {
						mem_txt += '		<div class="col-auto"><img src="/resources/images/no-profile-img.png" alt="Profile" class="rounded-circle add-img"></div>';
						}
					}
					mem_txt += '		<div class="col-auto"><span class="add-name">'+entry['mem_name']+'<i class="bi bi-pen-fill ms-2"></i></span></div>';
					mem_txt += '		<div class="col"><span class="add-email">'+entry['mem_email']+'</span></div>';
					mem_txt += '	</div>';
					mem_txt += '	<div class="row icon-area">';					
					mem_txt += '		<div class="col-auto">';
					if(entry['doc_edit'] == 'M'){				
						mem_txt += '		<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="편집" >';
						mem_txt += '			<i class="bi bi-pencil-square"></i>';
						mem_txt += '		</span>';
					}
					else {
						mem_txt += '		<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="보기" >';
						mem_txt += '			<i class="bi bi-eye"></i>';
						mem_txt += '		</span>';
					}
					mem_txt += '		</div>';
					mem_txt += '		<div class="col-auto me-auto">';

					
					if(sheetObj.stype == 'all'){
						mem_txt += '		<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="전체" >';
						mem_txt += '			<i class="bi bi-files"></i>';
						mem_txt += '		</span>';
					} 
					else {
						mem_txt += '		<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="시트" >';
						mem_txt += '			<i class="bi bi-file-spreadsheet"></i>';
						mem_txt += '		</span>';
					}
					mem_txt += '		</div>';
					
					mem_txt += '		<div class="col-auto">';
					mem_txt += '			<button class="btn btn-outline-secondary btn-sm border-none" data-bs-toggle="modal" data-bs-target="#share-del-modal" onclick="delShareMemPop(\''+entry['share_code']+'\')">삭제</button>';
					mem_txt += '		</div>';
					if(sheetObj.stype != 'all'){
						mem_txt += '	<div class="col-auto"><button class="btn btn-secondary btn-sm btn-shared-more" data-target="sh_more'+entry['share_code']+'" onclick="docUserShareModify(\''+entry['share_code']+'\')">더보기</button></div>';
					}
					mem_txt += '		<div class="shared-more" id="sh_more_'+entry['share_code']+'">';					
					mem_txt += '		</div>';					
					mem_txt += '	</div>';
					mem_txt += '</a>';
				});
				$('#shared_mem').html(mem_txt);
				$('#share_cnt').html( rlt.cnt);

            }
			else {
				$('#share_cnt').html( rlt.cnt);
			}
		},
		error : function(request, status, error) {
			showNotification("alert-danger",'ERROR', "top", "center", "", "");			
		}
	});
	

}

// 선택 멤버 공유 하기
function addShareMem(){
	var docId = $('#doc_id').val();
	var editType = $('#modal_edit_type:checked').val();
	var shareType = $('#modal_share_type').val();
	var sheetList = new Array(); 
	var memList = new Array(); 
	if(shareType != 'A'){
		var sheetLen = $("input:checkbox[name='sheet_lt']:checked").length;
		if((sheetLen * 1) < 1){
			showNotification("alert-warning", "공유할 시트를 선택해 주세요", "top", "center", "", "");
			return false;
		}
		$("input:checkbox[name='sheet_lt']").each(function (index) {
			if($(this).is(":checked")==true){
				sheetList.push($(this).val());
			}
		})
	};
	var memLen = $("input:checkbox[name='mem_lt']:checked").length;
	if((memLen * 1) < 1){
		showNotification("alert-warning", "공유할 멤버를 선택해 주세요", "top", "center", "", "");
		return false;
	};

	$('input:checkbox[name=mem_lt]').each(function (index) {
		if($(this).is(":checked")==true){
			memList.push($(this).val());
		}
	});
	$.ajax({
		url: "/Doc/doc_mem_share_prc",
		type: "POST",
		data: {
			docId: docId,
			editType: editType,
			shareType: shareType,
			sheetList: sheetList,
			memList, memList
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", rlt.msg, "top", "center", "", "");
				getDocShareaMem();
				$('#share-add-modal').modal('hide');
			}
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		}
	});
}


// 문서 삭제 처리 
function delDocData(){
	lodingModal('show');
	var docId = $('#doc_id').val();
	var confirm_rlt = confirm('문서를 영구삭제하시겠습니까? \n설정한 공유도 없어집니다.');
	if(confirm_rlt){
		$.ajax({
			url: "/Doc/delete_doc_prc",
			type: "POST",
			data: {
				doc_id: docId
			},
			dataType: "json",
			success: function(rlt) {
				if(rlt.code == 200){
					location.href='/TCmain';
				}
				else {
					showNotification("alert-warning", "ERROR", "top", "center", "", "");
					lodingModal('hide');
				}
			},
			error: function(request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			}
		});
	}
	else lodingModal('hide');
}


function docUserShareModify(str){
	var docId = $('#doc_id').val();
	if($('#sh_more_'+str).css('display') == 'none'){
		$.ajax({
			url: "/Doc/get_user_mem_share_sheet_prc",
			type: "POST",
			data: {
				doc_id: docId,
				sh_code: str
			},
			dataType: "json",
			success: function(rlt) {
				if(rlt.code == 200){
					var str_txt = '';
					$.each(rlt.data, function (index, entry) {
						str_txt += '<div class="row">';
						str_txt += '	<div class="col-auto">';
						str_txt += '		<p><span></span> ['+entry['sheet_name']+']</p>';
						str_txt += '	</div>';
						str_txt += '	<div class="col-auto ms-auto">';
						str_txt += '		<input type="hidden" id="sc_'+entry['sheet_id']+'" value="'+str+'">';
						str_txt += '		<select class="form-select" id="sts_'+entry['sheet_id']+'" onChange="setUserShafeSeet(\''+entry['sheet_id']+'\')">';
						str_txt += '			<option value="T"';
						if(entry['sh_t'] == 'T') str_txt += 'selected';
						str_txt += '			>권한없음</option>';
						str_txt += '			<option value="V"';
						if(entry['sh_t'] == 'V') str_txt += 'selected';
						str_txt += '			>보기</option>';
						str_txt += '			<option value="M"';
						if(entry['sh_t'] == 'M') str_txt += 'selected';
						str_txt += '			>편집</option>';
						str_txt += '		</select>';
						str_txt += '	</div>';
						str_txt += '</div>';
					});
					$('#sh_more_'+str).html(str_txt);
					$('#sh_more_'+str).show();
					
				}
				else showNotification("alert-warning", "ERROR", "top", "center", "", "");
			},
			error: function(request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			}
		});
	} else {
		$('#sh_more_'+str).hide();
	}
}

function setUserShafeSeet(str){
	var docId = $('#doc_id').val();
	var shareCd = $('#sc_'+str).val();
	var shareType = $('#sts_'+str+' option:selected').val();
	$.ajax({
		url: "/Doc/set_user_mem_share_sheet_prc",
		type: "POST",
		data: {
			doc_id: docId,
			sh_code: shareCd,
			set_id: str,
			set_type: shareType
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
			}
			else showNotification("alert-warning", "처리중 오류가 발생 하였습니다. ", "top", "center", "", "")
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "")
		}
	});
}

// 공유 삭제 
function docUserShareMemDel(){
	var docId = $('#doc_id').val();
	var shareId = $('#share_id').val();
	if(docId == ''){
		showNotification("alert-warning", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "")
		return;
	}

	if(shareId == ''){
		showNotification("alert-warning", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "")
		return;
	}
	
	$.ajax({
		url: "/Doc/delete_user_mem_share_prc",
		type: "POST",
		data: {
			doc_id: docId,
			share_id: shareId
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				$('#'+rlt.data.share_id).remove();
				$('#share_cnt').html(rlt.cnt);
				$('#share-del-modal').modal('hide');
			}
			else showNotification("alert-warning", "처리중 오류가 발생 하였습니다. ", "top", "center", "", "")
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "")
		}
	});
}

// 공유 URL 복사
function copyShareUrl(){
	var shareUrlVal = $('#share_url_val').val();
	var docId = $('#doc_id').val();	
	if(shareUrlVal == ''){
		$.ajax({
			url: "/Doc/add_share_url_prc",
			type: "POST",
			data: {
				doc_id: docId
			},
			dataType: "json",
			success: function(rlt) {
				if(rlt.code == 200){
					var enurl = encodeURI($('#web_url').val()+'/Share/doc/'+rlt.data.share_url_val);
					$('#share_url_val').val(enurl);
					$('#share_url_html').html($('#web_url').val()+'/Share/doc/'+rlt.data.share_url_val);
					$('#share_url_val').attr('type', 'text');
					$('#share_url_val').select();
					var copy = document.execCommand('copy');
					$('#share_url_val').attr('type', 'hidden');
					// 사용자 알림
					if(copy) {
						showNotification("alert-success", "URL 이 복사 되었습니다.", "top", "center", "", "");
					}
				}
				else showNotification("alert-warning", "처리중 오류가 발생 하였습니다. ", "top", "center", "", "")
			},
			error: function(request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "")
			}
		});
	}
	else {
		$('#share_url_val').attr('type', 'text');
		$('#share_url_val').select();
		var copy = document.execCommand('copy');
		$('#share_url_val').attr('type', 'hidden');
		// 사용자 알림
		if(copy) {
			showNotification("alert-success", "URL 이 복사 되었습니다.", "top", "center", "", "");
		}
	}

}

function delShareMemPop(idx){
	$('#share_id').val(idx);
}

function delShareMemCancel(){
	$('#share_id').val('');
}
 
window.onload = function(){
	basicOption = {
		showHorizontalScrollbar:true,
		showVerticalScrollbar:true,
		scrollbarMaxAlign:true,
		scrollbarShowMax:true,
		calcOnDemand: true,
		allowExtendPasteRange: true
	};
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), basicOption);
	var theme = new GC.Spread.Sheets.Theme("koCustomTheme", GC.Spread.Sheets.ThemeColors.Office, "맑은 고딕", "맑은 고딕");
	spread.sheets.forEach(function (item) {item.currentTheme(theme);});
	GC.Spread.Common.CultureManager.culture("ko-kr");	

	var excelIo = new GC.Spread.Excel.IO();	
	var fileMenuTemplate = GC.Spread.Sheets.Designer.getTemplate(GC.Spread.Sheets.Designer.TemplateNames.FileMenuPanelTemplate);
	var listContainer = fileMenuTemplate.content[0].children[0].children[0].children[0].children[1];
	listContainer.items.splice(0,2);
	var listDisplayContainer = fileMenuTemplate.content[0].children[0].children[1];
	listDisplayContainer.children.splice(0,2);
	var list = fileMenuTemplate.content[0].children[0].children[0];
	list.children[0].children.splice(2, 2);
	list.children[0].children.splice(3, 2);
	GC.Spread.Sheets.Designer.registerTemplate(GC.Spread.Sheets.Designer.TemplateNames.FileMenuPanelTemplate, fileMenuTemplate);
	var fileMenuPanelCommand = GC.Spread.Sheets.Designer.getCommand(GC.Spread.Sheets.Designer.CommandNames.FileMenuPanel);
	var oldExecuteFn = fileMenuPanelCommand.getState;
	fileMenuPanelCommand.getState = function (context, propertyName, newValue) {
	  let options = oldExecuteFn.apply(this, arguments);
	  if (options['activeCategory_main'] === 'New') {
		options['activeCategory_main'] = 'Print';
	  }
	  return options;
	}	 
	var config = GC.Spread.Sheets.Designer.DefaultConfig;
	config.commandMap = {fileMenuPanel: fileMenuPanelCommand}
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);
	viewDocData();

	document.getElementById('ex_export').onclick = function () {
		var fileName = $("#doc_title").val();  
		if (fileName.substr(-5, 5) !== '.xlsx') {  
			fileName += '.xlsx';  
		}
		var json = spread.toJSON();
		excelIo.save(json, function (blob) {
			saveAs(blob, fileName);
		}, function (e) {
			// process error
			console.log(e);
		}, {});		
	};

	const body = document.querySelector('body');
	const togle_class = ['toggle-file', 'toggle-memo', 'toggle-share'];	

	//닫기 버튼(공통)
	$('.btn-close-sidemenu').click(function() {
		togle_class.forEach(function(to_class) {			
			body.classList.remove(to_class);
		});
	});
	
	//색상정렬
    $(".dropdown-menu.sort").on("click", ".dropdown-item", function() {
		var selectedColorId = $(this).find("div.color-label").attr("data-color");
		$("#act-color").attr("class", "color-label "+selectedColorId);
		$("#act-color").attr("data-color", selectedColorId);
	});

	//파일관리 버튼
	$('.btn-file').click(function() {
		if($('body').hasClass("toggle-file")){
			body.classList.remove('toggle-file');
		}
		else {
			togle_class.forEach(function(togle_class) {
				body.classList.remove(togle_class);
			});
			body.classList.add('toggle-file');
		}
	})

	//메모버튼
	$('.btn-memo').click(function() {
		if($('body').hasClass("toggle-memo")){
			body.classList.remove("toggle-memo");
		} else {
			togle_class.forEach(function(togle_class) {
				body.classList.remove(togle_class);
			});
			body.classList.add('toggle-memo');
		}
	})

	//히스토리 버튼
	$('.btn-history').click(function() {
		var confirm_rlt = confirm('저장 되지 않는 내용이 삭제 될 수 있습니다. 저장 후 이동 해 주세요. 히스토리 페이지로 이동 하시겠습니까?');
		if(confirm_rlt){
			location.href='/Doc/history/'+$('#doc_id').val();
		}
	})

	$('.btn-close-his').click(function() {
		body.classList.toggle('toggle-history');
		$('#doc_ht').val('F')
		$("#history_list").html('<h5>이전 문서</h5>');
		$('#history_list_loading').show();
		$('#sel_his_id').val('');
		viewDocData();
	})

	 //공유 버튼
    $('.btn-share').click(function() {
		if($('body').hasClass("toggle-share")){
			body.classList.remove("toggle-share");
		}
		else {
			togle_class.forEach(function(togle_class) {
				body.classList.remove(togle_class);
			});
			body.classList.add('toggle-share');
			getDocShareaMem();
		}
	})
	

  // 공유 주소록에서 더보기 버튼
  $(document).ready(function() {
    const buttons = document.querySelectorAll('.btn-shared-more');
    const contents = document.querySelectorAll('.shared-more');
    
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const targetId = button.dataset.target;
        const targetContent = document.getElementById(targetId);
    
        contents.forEach(content => {
          if (content.style.display === 'block' && content !== targetContent) {
            content.style.display = 'none';
          }
        });
    
        if (targetContent.style.display === 'none') {
          targetContent.style.display = 'block';
        } else {
          targetContent.style.display = 'none';
        }
      });
    });
  
  });

  //공유 url 복사 toast
  $('#liveToastBtn').click(function() {
    var toast = new bootstrap.Toast($('#liveToast')[0], { delay: 2000 });
    toast.show();
  });
    

  // 공유 추가하기에서 범위 선택
  const share_range_button = document.querySelector('.btn-share-range');
  const share_range_contents = document.querySelector('.share-range');
  const share_range_list = document.querySelector('#selected-options-range');

  share_range_button.addEventListener('click', () => {
    if (share_range_contents.style.display === 'none') {
      share_range_contents.style.display = 'block';
      share_range_list.style.display = 'block';
    } else {
      share_range_contents.style.display = 'none';
      share_range_list.style.display = 'none';
    }
  });
  

  $('.share-range li').on('click', function(event) {
    event.preventDefault();
    var checkbox = $(this).find('input[type="checkbox"]');
    checkbox.prop('checked', !checkbox.prop('checked'));
    var selectedValue = checkbox.val();
    if (checkbox.is(':checked')) {
      $('<span class="selected-option-range pe-2">' + selectedValue + '<i class="bi bi-x"></i></span>').appendTo('#selected-options-range');
    } else {
      $('.selected-option-range:contains(' + selectedValue + ')').remove();
    }
  });
  
$(document).on('click', '.selected-option i', function() {
	var selectedValue = $(this).parent().text().replace(/\s/g, '').replace('×', '');
	$('.share-range input[type="checkbox"][value="' + selectedValue + '"]').prop('checked', false);
	$(this).parent().remove();
});

  

  // 공유 추가하기에서 멤버 선택하고 삭제
  $('.btn-check').on('change', function() {
    if ($('#range-user').is(':checked')) {
      $('.share-range').show();
    } else {
      $('.share-range').hide();
    }
  });

  //선택된 목록 아래에 표시
  $(document).on('click', '.selected-option i', function() {
    var selectedValue = $(this).parent().text().replace(/\s/g, '').replace('×', '');
    $('.share-member input[type="checkbox"][value="' + selectedValue + '"]').prop('checked', false);
    $(this).parent().remove();
  });
  
  //공유 url 복사 toast
  $('#btn-shared-toast').click(function() {
    var toast = new bootstrap.Toast($('#shared-toast')[0], { delay: 2000 });
    toast.show();
  });
}