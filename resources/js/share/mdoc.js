function modifyDocData(){
	lodingModal('show');
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
		url: "/Share/modify_document_prc",
		type: "POST",
		data: {
			shcd_en: $("#shcd_en").val(),
			doc_data: jsonString
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", "저장 되었습니다.", "top", "center", "", "");				
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
			setTimeout(function() {
				lodingModal('hide');
			}, 500);
											
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {
				lodingModal('hide');
			}, 500);
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
	viewDocData();

	function select(selector) {
    return document.querySelector(selector);
  }

  function on(event, selector, callback) {
    document.addEventListener(event, function(event) {
      const targetElement = event.target.closest(selector);
      if (targetElement) {
        callback(event, targetElement);
      }
    });
  }

    //닫기 버튼
  $('.btn-close-sidemenu').click(function() {
    const body = document.querySelector('body');
    body.classList.remove('toggle-file-authority');
  });


  //파일관리 버튼
  if (select('.btn-file-authority')) {
    on('click', '.btn-file-authority', function(e) {
      select('body').classList.toggle('toggle-file-authority')
    })
  }

	
}