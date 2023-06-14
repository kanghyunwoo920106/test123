function trformat(d) {
	var _tr = _.template($("#innerform").html());
	return _tr(d);
  }

function changeMbrStatus(ln) {
	lodingModal('show');
	var tr = $(ln).closest("tr");
	var code = $(ln).data("code");	
	var idx = $(ln).data("idx");
	var codename = $(tr).children("td:nth-child(5)").text();
	if (codename == memberstatus[code]) {
		var msg =
			"이미 " +
			$(tr).children("td:nth-child(2) ").text() +
			"(" +
			$(tr).children("td:nth-child(3) ").text() +
			")회원님의 상태는 " +
			codename +
			"입니다";
			showNotification("alert-warning", msg, "top", "center", "", "");
			lodingModal('hide', 'N');
		return;
	} else if (
		confirm(
			$(tr).children("td:nth-child(2) ").text() +
			"(" +
			$(tr).children("td:nth-child(3) ").text() +
			")회원님의 상태를 " +
			memberstatus[code] +
			"(으)로 변경하시겠습니까?"
		)
	) {
		//idx: 8 changestatus: NM
		$.ajax({
			url: "/TC_Manager/member_changeStatus_prc",
			type: "POST",
			data: { idx: idx, changestatus: code, prc: true },
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {
					showNotification("alert-success", "변경하였습니다.", "top", "center", "", "");
					$("#" + idx).children("td.mbr_status").text(result.data.codename);
					$("#" + idx).children("td.mbr_secession_date").text(result.data.secession_date);
					lodingModal('hide', 'T');
				} else {
					showNotification("alert-warning", result.msg, "top", "center", "", "");
					lodingModal('hide', 'T');
				}
			},
			error: function(request, status, error) {
				console.log(error);
			}
		});
	}
}

/*-- 이름 변경 --*/
function changeName(idx) {
	lodingModal('show');
	if (confirm("이름을 변경하시겠습니까?")) {
		$.ajax({
			url: "/TC_Manager/member_changeName_prc",
			type: "POST",
			data: $("form[name=form_name_" + idx + "]").serialize(),
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {
					showNotification("alert-success", "변경하였습니다.", "top", "center", "", "");
					$("#" + idx).children("td.user_name").text(result.data.name);
					lodingModal('hide', 'T');
				} else {
					showNotification("alert-warning", result.msg, "top", "center", "", "");
					lodingModal('hide', 'T');
				}
			},
			error: function(request, status, error) {
				console.log(error);
			}
		});
	}
}

/*-- 비밀번호 변경 --*/
function changepw(idx) {
	lodingModal('show');
	if (confirm("정말로 비밀번호를 변경하시겠습니까?")) {
		$.ajax({
			url: "/TC_Manager/member_changePw_prc",
			type: "POST",
			data: $("form[name=form_pw_" + idx + "]").serialize(),
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {
					showNotification("alert-success", "변경하였습니다.", "top", "center", "", "");
					lodingModal('hide', 'T');
				} else {
					showNotification("alert-warning", result.msg, "top", "center", "", "");
				}
			},
			error: function(request, status, error) {
				console.log(error);
			}
		});
	}
}

function userLogin(idx){
	$('#user_idx').val(idx);
	var gsWin = window.open("about:blank", "loginView", 'width=1000,height=800');	
	var frm = document.ad_login_form;
	frm.action = '/TC_Manager/admin_user_login_prc';
	frm.target = "loginView";
	frm.method ="post";
	frm.submit();
}



// Tooltip
$(document).ready(function () {
	table = $("#datatable_member").addClass('nowrap').DataTable({
		processing: true,
		searching: false,
		serverSide: true,
		scrollX: false,
		lengthChange: false, 
		autoWidth: false,
		responsive: false, //반응형 설정
		rowId: "idx",
		ajax: {
			url: "/TC_Manager/member_list_prc",
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
			{ 
				data: "idx", 				
				orderable: true	,
				className: "details-control",
				render: function(data) {
					return '<i class="glyphicon glyphicon-chevron-down"></i><i class="glyphicon glyphicon-ok"></i> <span style="vertical-align:top">[ '+data+' ]</span>';
				}

			},
			{ 
				data: "user_id", 
				className: "user_name", 
				orderable: true,
				render: function (data, type, row, meta) {
					return "<span style='cursor:pointer' onclick='viewDoc(" + row.idx + ")'>" + data + "</span>";
				}
			},
			{ data: "user_name", className: "user_name", orderable: false },
			{ 
				data: "join_type", orderable: false ,
				render:function(data){
					var re_html = '';
					if(data == 'N') re_html = '일반';
					else re_html = '쇼셜';

					return re_html;

				}
			},
			{
				data: "user_state", orderable: false, className: "mbr_status",
				render: function(data) {
					return typeof memberstatus[data] != "undefined" ? memberstatus[data] : data;
				}
			},
			{ data: "reg_date", orderable: false },
			{
				data: "idx", orderable: false, class: "td-etc",
				render: function(data) {
					var str =
						'<div style="position:relative">'+
						'	<ul class="header-dropdown" style="list-style:none;padding-left:7px;">' +
						'		<li class="dropdown">'+
						'			<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' + 
						'				<i class="glyphicon glyphicon-cog"></i>' +
						'			</a>'+
						'			<ul class="dropdown-menu pull-right member_status_menu">';
					str += '			<li style="">'+
							'				<div class="btn_state" style="padding-left:25px;height:30px;"><span class="st_header_split" style="cursor:pointer;color:black;text-decoration:none" onclick="userLogin(\''+data+'\')">계정 로그인</span></div>'+
							'			</li>'+
							'			<li style="">'+
							'				<div style="padding-left:7px;width:12px;height:30px"><span class="st_header_split" style="color:blue;text-decoration:none">상태변경하기</span></div>';
					for (code in memberstatus) {
						str +=
							'<div class="btn_state" style="padding-left:25px;height:30px;" onClick="changeMbrStatus(this)"  data-code="' +
							code +
							'" data-idx="' +
							data +
							'"><a href="javascript:void(0);" style="color:black;text-decoration:none" class="waves-effect waves-block">' +
							memberstatus[code] +
							'</a></div>';
					}					
					str +=	
						'			</li></ul>'+
						'		</li>'+
						'	</ul>'+
						'</div>';
					return str;
				}
			}
		],
		order: [[0, "DESC"]]
	});

	$("#datatable_member tbody").on("click", "td.details-control", function() {
		var tr = $(this).closest("tr");
		var row = table.row(tr);
		
		if (row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass("shown");
		} else {
			// Open this row
			row.child(trformat(row.data())).show();
			tr.addClass("shown");			
		}
	});
    
});