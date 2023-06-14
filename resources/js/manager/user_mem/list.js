// Tooltip
$(document).ready(function () {
	table = $("#dt_user_mem").addClass('nowrap').DataTable({
		processing: true,
		searching: false,
		serverSide: true,
		scrollX: false,
		lengthChange: false, 
		autoWidth: false,
		responsive: false, //반응형 설정
		rowId: "idx",
		ajax: {
			url: "/TC_Manager/user_mem_list_prc",
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
			{ data: "idx", orderable: true },
			{ 
				data: "user_id", 
				className: "user_name", 
				orderable: true
			},
			{ data: "user_name", className: "user_name", orderable: false },
			{ data: "join_type", orderable: false },
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
					str += '			<li>'+
							'				<div style="padding-left:7px;width:12px;height:30px"><span class="st_header_split" style="color:blue;text-decoration:none">상태변경하기</span></div>';
					for (code in memberstatus) {
						str +=
							'<div style="padding-left:25px;height:30px"><a href="javascript:void(0);" style="color:black;text-decoration:none" onClick="changeMbrStatus(this)" data-code="' +
							code +
							'" data-idx="' +
							data +
							'" class="waves-effect waves-block">' +
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