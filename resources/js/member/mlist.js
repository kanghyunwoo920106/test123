var isRun = false;

function editName(idx, st) {	
	var str_html = '';
	if(st == 'E'){
		var mem_name = $('#mem_na_'+idx).val();
		str_html += '<div style="position: relative; display: inline-block; width: 80%;">';
		str_html += '	<input type="text" class="form-control" style="position:relative; width:100%; display:inline-block;" maxlength="10" id="adr_inpt_'+idx+'" value="'+mem_name+'">';
		str_html += '	<button class="btn" style="position: absolute; top: 0; right: 0;" onclick="noEditName(\''+idx+'\')"><span class="bi bi-x-lg"></span></button><i class="bi bi-pen-fill ms-2 edit-name-pen" style="display: none;"></i>';
		str_html += '</div>';
		str_html += '<button type="button" class="btn btn-outline-dark btn-sm edit-name-confirm bi bi-check-lg" style="display: inline-block;" onclick="editNamePrc(\''+idx+'\')"></button>';	
	} else {
		str_html += '<i class="bi bi-pen-fill ms-2 edit-name-pen" onclick="editName(\''+rlt.data['idx']+'\',\'E\')"></i>';
	}
	$('#adr_'+idx).html(str_html);	
}

function noEditName(idx){
	var mem_name = $('#mem_na_'+idx).val();
	var str_html = '<span class="add-name" id="adr_'+idx+'">';
	str_html += ' 			'+mem_name+'';
	str_html += ' 			<i class="bi bi-pen-fill ms-2 edit-name-pen" onclick="editName(\''+idx+'\',\'E\')"></i>';
	str_html += '			<button type="button" class="btn btn-outline-dark btn-sm edit-name-confirm bi bi-check-lg"></button>';
	str_html += ' 		</span>';
	$('#adr_'+idx).html(str_html);
}

function editNamePrc(idx){
	var ch_name = $('#adr_inpt_'+idx).val();	
	$.ajax({
		url: "/Mem/up_user_mem_prc",
		type: "POST",
		data: {
			idx: idx,
			ch_val: ch_name
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				$('#mem_na_'+idx).val(rlt.data['mem_name']);
				var str_html = rlt.data['mem_name']+'<i class="bi bi-pen-fill ms-2 edit-name-pen" onclick="editName(\''+rlt.data['idx']+'\',\'E\')"></i>'
				$('#adr_'+idx).html(str_html);
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		}
	});	
}

function checkDelMember(){
	lodingModal('show');
	var check_value = [];
	$('.form-check-input:checked').each(function(){
		check_value.push($(this).val());
	});
	if(check_value.length < 1){
		showNotification("alert-warning", '삭제할 주소를 선택 해 주세요', "top", "center", "", "");
		return;
	}
	$.ajax({
		url: "/Mem/del_val_user_mem_prc",
		type: "POST",
		data: {
			ch_idx: check_value
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", "삭제 되었습니다.", "top", "center", "", "");
				userMemList('F')
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
			setTimeout(function() {
				lodingModal('hide');
			}, 1000);	
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {lodingModal('hide');}, 1000);
		}
	});
}

function delMember(idx){
	lodingModal('show');
	$.ajax({
		url: "/Mem/del_user_mem_prc",
		type: "POST",
		data: {
			idx: idx
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", "삭제 되었습니다.", "top", "center", "", "");
				$("#mem_row_"+idx).remove();
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
			setTimeout(function() {
				lodingModal('hide');
			}, 1000);			
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {lodingModal('hide');}, 1000);
		}
	});	
}

function userMemList(type){
	var pg_num = $('#page_nm').val();
	var mem_order = $('#mem_order').val();
	if(type == 'F'){
		pg_num = 1;
		$('#add-list').html('');
	}
	if(pg_num != 'E'){
		$.ajax({
			url: '/Mem/get_mem_list_prc',
			type: 'POST',
			data: {
				pg_num: pg_num,
				mem_order: mem_order				
			},
			async : false,
			dataType: "json",
			success: function(rlt) {
				if(rlt.code == 200){
					$('#page_nm').val(rlt.pg_num);
					$('#total_cnt').html(rlt.t_cnt);
					var m_txt = '';
					$.each(rlt.data, function(index, entry) {
						m_txt = '<a class="row d-flex align-items-center mb-3" aria-current="true" id="mem_row_'+entry['idx']+'">';
						m_txt += '	<div class="col-auto me-auto"><input class="form-check-input mt-0" type="checkbox" value="'+entry['idx']+'" aria-label="Checkbox for following text input"></div>';
						m_txt += '	<div class="col-auto me-auto">';
						if(entry['user_idx']){
							if(entry['user_img_name'] && entry['user_img_path']){
								m_txt += ' 	<img src="'+entry['user_img_path']+'/'+entry['user_img_name']+'" alt="Profile" class="rounded-circle add-img">';
							} else {
								m_txt += ' 	<img src="/resources/images/no-profile-img.png" alt="Profile" class="rounded-circle add-img">';
							}
						} else {
							m_txt += ' 	<img src="/resources/images/no-join-img.png" alt="Profile" class="rounded-circle add-img">';
						}
						m_txt += ' 	</div>';
						m_txt += ' 	<div class="col-2 me-auto"><input type="hidden" id="mem_na_'+entry['idx']+'" value="'+entry['mem_name']+'">';
						m_txt += ' 		<span class="add-name" id="adr_'+entry['idx']+'">';
						m_txt += ' 			'+entry['mem_name']+'';
						m_txt += ' 			<i class="bi bi-pen-fill ms-2 edit-name-pen" style="cursor:pointer;" onclick="editName(\''+entry['idx']+'\',\'E\')"></i>';
						m_txt += '			<button type="button" class="btn btn-outline-dark btn-sm edit-name-confirm bi bi-check-lg"></button>';
						m_txt += ' 		</span>';
						m_txt += '	</div>';
						m_txt += ' 	<div class="col me-auto ms-4"><span class="add-email">'+entry['mem_email']+'</span><span class="add-date">'+entry['up_date']+'</span></div>';
						m_txt += ' 	<div class="col-auto me-auto add-del" onclick="delMember('+entry['idx']+')"><i class="bi bi-x-lg"></i></div>';
						m_txt += '</a>';
						$("#add-list").append(m_txt);							
					});				
				}
				else{
					$('#page_nm').val(rlt.pg_num);
				}
				$('#loding-area').hide();
			},
			error: function(request, status, error) {
				isRun  = false;
				showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			}
		});	
	} else {
		$('#loding-area').hide();
	}
}

function addUserMem(){
	var str_name = $('#mem_name').val();
	var str_email = $('#mem_email_f').val()+'@'+$('#mem_email_s').val();

	// 이름 	
	if(!checkName(str_name)){
		return false;
	}
	
	// 이메밀
	if(!checkEmail(str_email)){		
		return false;
	}

	$.ajax({
		url: "/mem/add_user_mem_prc",
		type: "POST",
		data: {
			mem_name: str_name,
			mem_email: str_email
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code == 200){
				showNotification("alert-success", "등록 되었습니다.", "top", "center", "", "");
				$('#mem_name').val('');
				$('#mem_email_f').val('');
				$('#mem_email_s').val('');
				userMemList('F')
			}
			else showNotification("alert-warning", rlt.msg, "top", "center", "", "");
		},
		error: function(request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		}
	});	
}
  
// 이메일 추가할때 뒤에 이메일 주소 자동 추가
$(document).ready(function() {
	$('#email_sel').on('change', function() {
		var selectedValue = $(this).val();
		if (selectedValue == '') {			
			$('#mem_email_s').val('');
			$('#mem_email_s').prop('readonly', false);
		} else {
			$('#mem_email_s').prop('readonly', true);
			$('#mem_email_s').val(selectedValue);
		}
	});
	
	// 전체선택 버튼 눌렀을 때
	$('#select-all').click(function() {
		var $checkboxes = $('.form-check-input');
		$checkboxes.prop('checked', !$checkboxes.prop('checked'));
	});
	
	// 삭제 버튼을 클릭할 때
	$('.add-del').on('click', function(e) {
		e.preventDefault(); // 기본 동작 방지  
		// 확인 메시지 띄우기
		var result = confirm('선택한 멤버를 주소록에서 삭제 하시겠습니까?');
		if (result) {
			// 확인 버튼 클릭 시, 부모 요소(a 태그) 삭제
			$(this).closest('a').remove();
		}
	});
	userMemList();

	document.getElementById("go-back").addEventListener("click", () => {
		history.back();
	});
});
var page_nm = '';
//스크롤 바닥 감지
window.onscroll = function(e) {
    //추가되는 임시 콘텐츠
    //window height + window scrollY 값이 document height보다 클 경우,
    if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    	$('#loding-area').show();
		userMemList();
    }
};