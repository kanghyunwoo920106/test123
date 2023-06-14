function viewDoc(idx){
	$.ajax({
		url: "/TC_Manager/get_document_detail_prc",
		type: "POST",
		data: { 
			doc_idx: idx
		},		
		dataType: "json",
		success: function (rlt) {
			if(rlt.code=200){
				$('#userDocTitle').html(rlt.data.doc_title);
				var spread = GC.Spread.Sheets.findControl(document.getElementById('ss')); 				
				spread.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  { ignoreFormula: true });
				$("#userDocDetail").modal('show');
			}
			else alert("ERROR");			
		},
		error: function (request, status, error) {
			alert("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요#2");
		},
	});	
}

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("ss"));
	spread.options.showVerticalScrollbar = true;
	spread.options.scrollbarMaxAlign = true;
	spread.options.scrollbarShowMax = true;
}

// Tooltip
$(document).ready(function () {
	table = $("#datatable_doc_user").addClass('nowrap').DataTable({
		processing: true,
		searching: false,
		serverSide: true,
		scrollX: false,
		lengthChange: false, 
		autoWidth: false,
		responsive: false, //반응형 설정
		rowId: "idx",
		ajax: {
			url: "/TC_Manager/doc_user_list_prc",
			type: "GET",
			data: function(d) {
				return $.extend({}, d, {
					// startdate: $("input[name=startdate]").val(),
					// enddate: $("input[name=enddate]").val(),
					// mbr_status: $("#mbr_status").val(),
					// search_field: $("#search_field").val(),
					// search: $("input[name=search]").val()
				});
			}
		},
		drawCallback: completed,
		columns: [
			{ data: "idx",  orderable: true },
			{ data: "user_idx", orderable: true },
			{ 
				data: "doc_id", orderable: true,
				render: function (data, type, row, meta) {
					return "<span style='cursor:pointer' onclick='viewDoc(" + row.idx + ")'>" + data + "</span>";
				}
			},
			{ data: "doc_title", orderable: false },
			{ data: "reg_date", orderable: false }
		],
		order: [[0, "DESC"]]
	});    
});

