


function doSearch() {
	var sachar_txt = $("#search_txt").val().trim();	
	var reg_search = /^[가-힣a-zA-Z0-9 ]{2,}$/;	
	if(!reg_search.test(sachar_txt)) {
		showNotification("alert-warning", "검색어를 2자이상 입력해 주세요.", "top", "center", "", "");
		return false;
	}
	templateList();
} 

function getCategoryListTem(cate_type) {
	var cateIdx = "";
	switch (cate_type) {
		case 'L':
			cateIdx = $("#l_cate").val();
			if (cateIdx == '') {
				$("#m_cate").html("<option value=''>중분류</option>");
				$("#s_cate").html("<option value=''>소분류</option>");
			}
			break;
		case 'M':
			cateIdx = $("#m_cate").val();
			break;
	}

	$.ajax({
		url: "/TC_Manager/get_category_list_prc",
		type: "POST",
		data: {
			cate_idx: cateIdx,
		},
		dataType: "json",
		success: function (result) {
			if (result.code == 200) {
				var m_txt = "";
				$.each(result.data, function (index, entry) {
					m_txt += "<option value='" + entry["idx"] + "'>" + entry["cate_name"] + "</option>";
				});
				switch (cate_type) {
					case 'L':
						$("#m_cate").html("<option value=''>중분류</option>" + m_txt);
						$("#s_cate").html("<option value=''>소분류</option>");
						break;
					case 'M':
						$("#s_cate").html("<option value=''>소분류</option>" + m_txt);
						break;
				}				
			} else {
				switch (cate_type) {
					case 'L':
						$("#m_cate").html("<option value=''>중분류</option>");
						$("#s_cate").html("<option value=''>소분류</option>");
						break;
					case 'M':
						$("#s_cate").html("<option value=''>소분류</option>");
						break;
				}				
			}
			templateList();
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");			
		}
	});
}

function templateList(){
	var l_cate = $("#l_cate option:selected").val();
	var m_cate = $("#m_cate option:selected").val();
	var s_cate = $("#s_cate option:selected").val();
	var search_txt = $("#search_txt").val().trim();	

	$("#default_thumbnail").html("");
	$("#thumbnail").html("");
	var m_txt = "";	
	var cnt = 0;
	$.ajax({
		url: "/TC_Manager/get_template_list_prc",
		type: "POST",
		data: {
			lcate: l_cate,
			mcate: m_cate,
			scate: s_cate,
			searchtxt: search_txt
		},
		dataType: "json",
		success: function(result) {
			if (result.code == 200) {				
				$.each(result.data, function(index, entry) {
					m_txt = '<div class="col-md-55 panel">';
					m_txt += '	<div class="thumbnail">';
					m_txt += '		<div class="image view view-first">';
					m_txt += '			<input type="hidden" class="itemNum" value="'+ entry["idx"]  +'">';
					m_txt += '			<img style="width: 100%; display: block;" src="' + entry["img_path"] + "/" + entry["img_name"] + '" alt="image" />';
					m_txt += '			<div class="mask">';
					m_txt += '				<p>' + entry["tem_title"] +'</p>';
					m_txt += '			  	<div class="tools tools-bottom">';
					m_txt += '					<a href="#" onclick="detailTemplate(\'' + entry["idx"] + '\')"><i class="fa fa-file-text-o"></i></a>';
					m_txt += '					<a href="#" onclick="modifyTemplate(\'' + entry["idx"] + '\')"><i class="fa fa-edit"></i></a>';
					m_txt += '					<a href="#" onclick="delTemplate(\'' + entry["idx"] + '\')"><i class="fa fa-times"></i></a>';
					m_txt += '	  			</div>';
					m_txt += '			</div>';
					m_txt += '  	</div>';
					m_txt += '  	<div class="caption">';
					m_txt += '			<p>'+ entry["tem_memo"] +'</p>';
					m_txt += '  	</div>';
					m_txt += '	</div>';
					m_txt += '</div>';					
					$("#thumbnail").append(m_txt);
					cnt++;					
				});				
				window.scrollTo({top:location});
			} else {
				$("#thumbnail").append('');
				return;
			}
		},
		error: function(request, status, error) {			
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		}
	});
}

function reorder(){
	$(".panel").each(function(i, box) {
		$.ajax({
			url: "/TC_Manager/up_template_sort_prc",
			type: "post",
			data: {
				idx : $(box).find(".itemNum").val(),
				sort_num : i + 1,
			},
			dataType: "json",
			success: function(result) {
				if (result.code == 200) {					
				}
				else {
					alert(result.msg);
				}
			}			
		});
	});
}
// Tooltip
$(document).ready(function () {
	templateList();

	$("#thumbnail").sortable({
		start: function(event, ui) {			
		},		
		stop: function(event, ui) {			
			reorder();			
        }
	});
});