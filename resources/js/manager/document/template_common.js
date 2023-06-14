function listTemplate() {
	location.href = "/TC_Manager/document/template/";
}

// 템플릿 상세 보기
function detailTemplate(idx) {
	location.href = "/TC_Manager/document/template/view?idx=" + idx;
}

// 신규 템플릿 등록
function writeTemplate() {
	location.href = "/TC_Manager/document/template/write";
}

// 템플릿 수정
function modifyTemplate(idx) {
	location.href = "/TC_Manager/document/template/modify?idx=" + idx;
}

// 템플릿 삭제 
function delTemplate(idx){
	if(confirm("해당 템플릿을 삭제 하시겠습니까?")){
		$.ajax({
			url: "/TC_Manager/del_template_prc",
			type: "POST",
			dataType: "json",		
			data: {
				idx: idx
			},
			success: function (rlt) {
				if (rlt.code == 200) {
					alert('수정 되었습니다.');
					templateList();
				}
			},
			error: function (request, status, error) {
				showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			},
		});
	}
}

function getCategoryList(cate_type) {
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
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");			
		}
	});
}
