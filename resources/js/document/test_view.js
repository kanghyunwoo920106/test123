function viewDocData(){
	lodingModal('show');
	$.ajax({
		url: "/Doc/test_get_doc_detail_prc",
		type: "POST",
		data: {
			doc_id: $("#doc_id").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
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
				lodingModal('hide');
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

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), {calcOnDemand: true});
	var excelIo = new GC.Spread.Excel.IO();
	GC.Spread.Common.CultureManager.culture("ko-kr");	
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);
	viewDocData();	
}