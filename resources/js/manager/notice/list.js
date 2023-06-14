function openNoticeD(board_idx) {	
	$("#board_idx").val(board_idx);
	$.ajax({
		url: "/TC_Manager/get_notice_detail_prc",
		type: "GET",
		data: { 
			board_idx: board_idx
		},		
		dataType: "json",
		success: function (result) {
			$("#boardIdx").val(result.content.idx);
			$("#noticeTitle").html(result.content.title);
			$("#noticeContents").html(result.content.contents);			
			$("#noticeDPop").modal('show');			
		},
		error: function (request, status, error) {
			alert("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요#2");
		},
	});	
}
function closeNoticeD(){
	$('#noticeDPop').modal('hide');	
}
function addNotice(){
	var notice_title = $("#notice-title").val();
	var notice_content = $("#notice-text").val();
	$.ajax({
		url: "/TC_Manager/add_notice_prc",
		type: "POST",
		data: { 
			notice_title: notice_title,
			notice_content: notice_content
		},		
		dataType: "json",
		success: function (result) {
			if (result.code == 200) {
				$('#noticeWrite').modal('hide');
				$("#datatable_notice").dataTable().fnFilter();				
			}
		},
		error: function (request, status, error) {
			alert("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요#2");
		},
	});
}
function resetNoticeD(){	
	$("#board_idx").val('');
	$("#notice-title").val('');
	$("#notice-text").html('');
	$("#addButton").show();
	$("#modifyButton").hide();
}
function modifyNotice(){	
	$('#noticeDPop').modal('hide');
	var m_baord_idx = $("#board_idx").val();
	if(m_baord_idx == ''){
		alert("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요#2");
		return;
	}	
	$.ajax({
		url: "/TC_Manager/get_notice_detail_prc",
		type: "POST",
		data: { 
			board_idx: m_baord_idx
		},		
		dataType: "json",
		success: function (result) {
			$("#board_idx").val(result.content.idx);
			$("#notice-title").val(result.content.title);			
			var content_txt = result.content.contents;
			$("#notice-text").html(content_txt.replace(/(<([^>]+)>)/ig,""));
			$("#addButton").hide();
			$("#modifyButton").show();
			$("#noticeWrite").modal('show');
		
		},
		error: function (request, status, error) {
			alert("오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요#2");
		}		
	});	
}

function modifyNoticePrc(){
}

// Tooltip
$(document).ready(function () {
	table = $("#datatable_notice").addClass('nowrap').DataTable({
		processing: true,
		searching: false,
		serverSide: true,
		scrollX: false,
		lengthChange: false, 
		autoWidth: false,
		responsive: false, //반응형 설정
		rowId: "idx",
		ajax: {
			url: "/TC_Manager/notice_list_prc",
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
			{ data: "category", orderable: true },			
			{ 
				data: "title", orderable: false, 
				render: function (data, type, row, meta) {
						var title_txt;
					if(row.check_board == 'Y'){
						title_txt = "<b>" + row.title + "</b>"
					} else {
						title_txt = row.title;
					}
					return "<span style='cursor:pointer' onclick='openNoticeD(" + row.idx + ")'>" + title_txt + "</span>";
				}
			},
			{ data: "reg_date", orderable: false }
		],
		order: [[0, "DESC"]]
	});
    
});