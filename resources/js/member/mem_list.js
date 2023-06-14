function editName(span) {
	// 펜 버튼 눌렀을때 이름 수정
	var currentName = span.textContent;  
	var input = document.createElement('input');
	input.type = 'text';
	input.value = currentName;
  
	span.parentNode.replaceChild(input, span);
  
	input.focus();
  
	input.addEventListener('keyup', function(event) {
		if (event.key === 'Enter') {
			var newName = input.value;
			span.textContent = newName;
			input.parentNode.replaceChild(span, input);
		}
	});
}

function user_mem_list(){
	$.ajax({
		url: "/mem/get_mem_list_prc",
		type: "POST",
		data: {
			pg_num: $('#page_nm').val()			
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				$('#page_nm').val(rlt.data.pg_num);
				$('#total_cnt').html(rlt.data.total_cnt);
				var m_txt = '';
				$.each(rlt.data, function(index, entry) {
					m_txt = '<a href="#" class="row d-flex align-items-center mb-3" aria-current="true">';
					m_txt += '	<div class="col-auto me-auto"><input class="form-check-input mt-0" type="checkbox" value="'+entry['idx']+'" aria-label="Checkbox for following text input"></div>';
					m_txt += '	<div class="col-auto me-auto">';
					if((entry['user_check']*1) > 0){
						m_txt += ' 	<img src="/resources/images/no-join-img.png" alt="Profile" class="rounded-circle add-img">';
					} else {
						m_txt += ' 	<img src="/resources/images/no-join-img.png" alt="Profile" class="rounded-circle add-img">';
					}
					m_txt += ' 	</div>';
					m_txt += ' 	<div class="col-auto me-auto"><span class="add-name" onclick="editName(this)">'+entry['mem_name']+'<i class="bi bi-pen-fill ms-2"></i></span></div>';
					m_txt += ' 	<div class="col me-auto ms-4"><span class="add-email">'+entry['mem_email']+'</span><span class="add-date">2023-03-03</span></div>';
					m_txt += ' 	<div class="col-auto me-auto add-del"><i class="bi bi-x-circle"></i></div>';
					m_txt += '</a>';					
					$("#add-list").append(m_txt);
					cnt++;					
				});				
			}
			else alert("ERROR");
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});	
}

function add_user_mem(){
	var reg_nick = /^[가-힣a-zA-Z0-9]{2,}$/;
	var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

	var str_name = $('#mem_name').val();

	var str_email = $('#mem_email_f').val()+'@'+$('#mem_email_s').val();

	// 이름 
	if(!reg_nick.test(str_name)) {
		alert("이름을 2자이상 입력해 주세요");
		return false;
	}
	
	// 이메밀	
	if(!reg_email.test(str_email)) {
		alert("Email을 올바르게 입력해 주세요");
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
			if(rlt.code=200){
				alert('등록 되었습니다.');
				location.reload();
			}
			else alert("ERROR");
		},
		error: function(request, status, error) {
			console.log(error);
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

	user_mem_list();
});
  