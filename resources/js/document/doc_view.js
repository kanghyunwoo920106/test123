function view_data(){
	$.ajax({
		url: "/Doc/get_doc_detail_prc",
		type: "POST",
		data: {
			doc_id: $("#doc_id").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				$('#doc_title').val(rlt.data.doc_title);
				$('#doc_memo').val(rlt.data.doc_memo);
                var spread = GC.Spread.Sheets.findControl(document.getElementById('ss')); 
				spread.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  { ignoreFormula: true });
			}
			else alert("ERROR");
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

function modify_doc(frm){
	// 템플릿 테이터 	
	var docId = frm.doc_id.value;
	var docTitle = frm.doc_title.value;
	var docMemo = frm.doc_memo.value;
	
	// 제목
	if(!docTitle) {
		alert("제목을 입력해 주세요.");
		return false;
	}

	// 템플릿 테이터 	
	var spread1 = GC.Spread.Sheets.findControl(document.getElementById('ss'));
	var jsonString = JSON.stringify(spread1.toJSON( { includeBindingSource: true } ));

	var formData = new FormData(frm);
	formData.append("doc_data", jsonString);

	$.ajax({
		url: "/Doc/modify_doc_prc",
		type: "POST",
		data: {
			doc_id: docId,
			doc_title: docTitle,
			doc_memo: docMemo,
			doc_data: jsonString
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				alert('수정 되었습니다.');
				location.reload();
			}
			else alert("ERROR");
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});	
}

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(
		document.getElementById("ss"),
		{sheetcount:1}                
	);
	var sheet = spread.getActiveSheet();
	view_data();	
}