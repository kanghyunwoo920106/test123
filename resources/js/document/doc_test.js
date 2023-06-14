function viewDocData(){
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
				if(rlt.data.url_share != '' && rlt.data.url_share != false){
					$('#share_url_val').val($('#web_url').val()+'/Share/doc/'+rlt.data.url_share);
					$('#share_url_html').html($('#web_url').val()+'/Share/doc/'+rlt.data.url_share);
				}
                var spread2 = GC.Spread.Sheets.findControl(document.getElementById('excel_area')); 
				spread2.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  { ignoreFormula: true });
				lodingModal('hide');
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");
				location.href='/TCmain';
			}; 
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"));
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);
	
	viewDocData();

	
}