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