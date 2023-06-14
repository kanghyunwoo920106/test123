function modifyDocData(){
	lodingModal('show');
	var docId = $('#doc_id').val();
	var shareId = $('#share_id').val();

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

	$.ajax({
		url: "/Doc/modify_doc_share_prc",
		type: "POST",
		data: {
			share_id: shareId,
			doc_id: docId,			
			doc_data: jsonString
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code==200){
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
	var excelIo = new GC.Spread.Excel.IO();
	GC.Spread.Common.CultureManager.culture("ko-kr");
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
	//spread.options.tabStripVisible = false;
	//spread.options.showHorizontalScrollbar = false;
	viewsDocData();

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
	const togle_class = ['toggle-file', 'toggle-memo', 'toggle-share', 'toggle-file-authority'];	

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
	//문서권환

	$('.btn-file-authority').click(function() {
		if($('body').hasClass("toggle-file-authority")){
			body.classList.remove("toggle-file-authority");
		} else {
			togle_class.forEach(function(togle_class) {
				body.classList.remove(togle_class);
			});
			body.classList.add('toggle-file-authority');
		}
	})

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
}