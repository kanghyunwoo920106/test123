function doc_submit(frm) {
	
	var titleValue = frm.doc_title.value;
	var memoValue = frm.doc_memo.value;
	
	// 제목
	if(!titleValue) {
		alert("제목을 입력해 주세요.");
		return false;
	}

	// 템플릿 테이터 	
	var spread1 = GC.Spread.Sheets.findControl(document.getElementById('ss'));
	var jsonString = JSON.stringify(spread1.toJSON( { includeBindingSource: true } ));

	var formData = new FormData(frm);
	formData.append("doc_data", jsonString);

	$.ajax({
		url: '/Document/add_doc_write_prc',
		type: 'POST',
		data: {
			doc_title: titleValue,
			doc_memo: memoValue,
			doc_data: jsonString     
		},
		dataType: 'json',		
		success: function (result) {
			if (result.code == 200) {
				alert("등록 되었습니다.");
				//location.replace('/TC_Manager/document/template');
			}
		},
		error: function (request, status, error) {
			alert("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.");
		},
	});
}

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(
		document.getElementById("ss"),
		{sheetcount:1}                
	);
	var sheet = spread.getActiveSheet();
}