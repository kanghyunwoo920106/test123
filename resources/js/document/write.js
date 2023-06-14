function addDocData() {
	lodingModal('show');
	var docType = $('#doc_type').val();
	var temId = $('#tem_id').val();
	var titleValue = $('#doc_title').val();
	var memoValue = $('#doc_memo').val();
	var colorValue = $('#act-color').attr("data-color");

	if(titleValue == ''){
		titleValue = "내 문서 타이틀 명";
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
	var spreadd = GC.Spread.Sheets.findControl(document.getElementById('excel_area'));
	var jsonString = JSON.stringify(spreadd.toJSON(jsonOptions));
	$.ajax({
		url: '/Doc/add_doc_write_prc',
		type: 'POST',
		data: {
			doc_type: docType,
			tem_id: temId,
			doc_title: titleValue,
			doc_memo: memoValue,
			doc_color: colorValue,
			doc_data: jsonString     
		},
		dataType: 'json',
		success: function (result) {
			if (result.code == 200) {
				showNotification("alert-success", "저장 되었습니다.", "top", "center", "", "");
				setTimeout(function() {
					location.replace('/Doc/view/'+result.data.id);
				}, 1000);
			}
			else {
				showNotification("alert-warning", result.msg, "top", "center", "", "");
				lodingModal('hide', 'T');

			}
		},
		error: function (request, status, error) {		
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			lodingModal('hide', 'T');		
		},
	});
}

function addTemplateData(){	
	var docType = $('#doc_type').val();
	var temId = $('#tem_id').val();
	if(docType == 'T' && temId){
		lodingModal('show');
		$.ajax({
			url: '/Doc/add_doc_write_tem_prc',
			type: 'POST',
			data: {
				doc_type: docType,
				tem_id: temId   
			},
			dataType: 'json',		
			success: function (rlt) {
				if (rlt.code == 200) {
					var serializationOption = {
						ignoreStyle: false,
						ignoreFormula: false,
						saveAsView: false,
						rowHeadersAsFrozenColumns: false,
						columnHeadersAsFrozenRows: false,
						includeAutoMergedCells: false,
						includeBindingSource: true,
					};
					var spreadt = GC.Spread.Sheets.findControl(document.getElementById('excel_area'));
					spreadt.fromJSON(JSON.parse(JSON.stringify(rlt.data)),  serializationOption);
					for (var i = 0; i <= spreadt.getSheetCount(); i++) {
						var sheet = spreadt.getSheet(i);
						if (sheet != null) {
							var pi = sheet.printInfo();
							pi.showColumnHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
							pi.showRowHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
							pi.showBorder(false);
						}
					}

				} else {
					showNotification("alert-warning", result.msg, "top", "center", "", ""); 
				}
				lodingModal('hide', 'T');
			},
			error: function (request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
				lodingModal('hide', 'T');
			},
		});
	}

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
	var spreadNS = GC.Spread.Sheets, sheet = spread.getSheet(0), SheetArea = spreadNS.SheetArea;
	sheet.setRowCount(1000, GC.Spread.Sheets.SheetArea.viewport);
	sheet.setColumnCount(200, GC.Spread.Sheets.SheetArea.viewport);
	var theme = new GC.Spread.Sheets.Theme("koCustomTheme", GC.Spread.Sheets.ThemeColors.Office, "맑은 고딕", "맑은 고딕");
	spread.sheets.forEach(function (item) {item.currentTheme(theme);});
	var excelIo = new GC.Spread.Excel.IO();
	GC.Spread.Common.CultureManager.culture("ko-kr");

	var fileMenuTemplate = GC.Spread.Sheets.Designer.getTemplate(
		GC.Spread.Sheets.Designer.TemplateNames.FileMenuPanelTemplate
	);
	var listContainer = fileMenuTemplate.content[0].children[0].children[0].children[0].children[1];
	listContainer.items.splice(0,2);

	var listDisplayContainer = fileMenuTemplate.content[0].children[0].children[1];
	listDisplayContainer.children.splice(0,2);

	//좌측 리스트 구분선, 열기, 저장 제거
	var list = fileMenuTemplate.content[0].children[0].children[0];
	list.children[0].children.splice(2, 2);
	list.children[0].children.splice(3, 2);	 
	 
	GC.Spread.Sheets.Designer.registerTemplate(
		GC.Spread.Sheets.Designer.TemplateNames.FileMenuPanelTemplate, 
		fileMenuTemplate
	);

	var fileMenuPanelCommand = GC.Spread.Sheets.Designer.getCommand(
		GC.Spread.Sheets.Designer.CommandNames.FileMenuPanel
	);

	var oldExecuteFn = fileMenuPanelCommand.getState;
	fileMenuPanelCommand.getState = function (context, propertyName, newValue) {
	  let options = oldExecuteFn.apply(this, arguments);
	  if (options['activeCategory_main'] === 'New') {
		options['activeCategory_main'] = 'Print';
	  }
	  return options;
	}
	 
	var config = GC.Spread.Sheets.Designer.DefaultConfig;
	config.commandMap = {
	  fileMenuPanel: fileMenuPanelCommand
	}
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);	

	document.getElementById('fileDemo').onchange = function () {
		var excelFile = document.getElementById("fileDemo").files[0];
        excelIo.open(excelFile, function (json) {
            var workbookObj = json;
			var wSerializationOption = {
				ignoreStyle: false,
				ignoreFormula: false,
				saveAsView: false,
				rowHeadersAsFrozenColumns: false,
				columnHeadersAsFrozenRows: false,
				includeAutoMergedCells: false,
				includeBindingSource: true,
			};
			spread.fromJSON(workbookObj, wSerializationOption);
			for (var i = 0; i <= spread.getSheetCount(); i++) {
				var sheet = spread.getSheet(i);
				if (sheet != null) {
					var pi = sheet.printInfo();
					pi.showColumnHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
					pi.showRowHeader(GC.Spread.Sheets.Print.PrintVisibilityType.hide);
					pi.showBorder(false);
				}
			}
        }, function (e) {
			showNotification("alert-danger", e.errorMessage, "top", "center", "", "");
        });		
    };

	document.getElementById('reSet').onclick = function () {
		var confirm_rlt = confirm('저장 되지 않는 내용이 삭제 될 수 있습니다. 전체 내용을 초기화 하시겠습니까?');
		if(confirm_rlt){			
			spread.clearSheets();
			spread.addSheet(0);
			spread.setActiveSheetIndex(0);
			$("#fileDemo").val("");
		}
	};

	const body = document.querySelector('body');
	const togle_class = ['toggle-file', 'toggle-memo'];	

	//색상정렬
    $(".dropdown-menu.sort").on("click", ".dropdown-item", function() {
		var selectedColorId = $(this).find("div.color-label").attr("data-color");
		$("#act-color").attr("class", "color-label "+selectedColorId);
		$("#act-color").attr("data-color", selectedColorId);
	});

	//닫기 버튼(공통)
	$('.btn-close-sidemenu').click(function() {
		togle_class.forEach(function(togle_class) {
			body.classList.remove(togle_class);
		});
	});

	//파일관리 버튼
	if (select('.btn-file')) {
		on('click', '.btn-file', function(e) {
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
	}
	
	//메모버튼
	$('.btn-file').click(function() {
		if($('body').hasClass('toggle-memo')){
			body.classList.remove('toggle-memo');
		} else {
			togle_class.forEach(function(togle_class) {
				body.classList.remove(togle_class);
			});
			body.classList.add('toggle-memo');
		}
	})
	addTemplateData();
}