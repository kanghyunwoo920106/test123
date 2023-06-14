function login(){
	lodingModal('show');
	var userID = $('#user_id').val();
	var userPW = $('#user_pass').val();

	if(!checkEmail(userID)){
		lodingModal('hide');
		return false;
	}

	if(!checkPassword(userPW)){
		lodingModal('hide');
		return false;
	}

	$.ajax({
		url: '/login/login_prc',
		type: 'POST',
		data: $("#sign_in").serialize(),
		dataType: 'json',
		success: function (result) {
			if( result.rlt == true ){
				if($('#reurl').val() != ''){								
					location.replace($('#reurl').val());
				}
				else {
					location.replace('/TCmain');
				}
			} else {
				showNotification("alert-danger", result.msg, "top", "center", "", "");
				lodingModal('hide');
			}
		},
		error : function(request, status, error) {
			showNotification("alert-danger",'ERROR', "top", "center", "", "");
			lodingModal('hide');
		}
	});
	return false;
}

function accountprc(){
	lodingModal('show');
	var userName = $('#cre_user_name').val();
	var userEmail = $('#cre_user_email').val();
	var userPwd = $('#cre_user_pwd').val();

	// 약관 확인 
	if(!$('#tos1').is(':checked') || !$('#tos2').is(':checked')){
		showNotification("alert-warning", "필수 약관에 동의를 해주셔야 합니다.", "top", "center", "", "");
		lodingModal('hide');
		return false;
	};

	if(!checkName(userName)){
		lodingModal('hide');
		return false;
	}

	if(!checkEmail(userEmail)){
		lodingModal('hide');
		return false;
	}

	if(!checkPassword(userPwd)){
		lodingModal('hide');
		return false;
	}

	$.ajax({
		url: '/login/account_prc',
		type: 'POST',
		data: $("#create_account").serialize(),
		dataType: 'json',
		success: function (result) {
			if( result.rlt == true ){
				showNotification("alert-success", result.msg, "top", "center", "", "");
				setTimeout(function() {
					location.replace('/');
				}, 2000);
            }else {
				showNotification("alert-warning", result.msg, "top", "center", "", "");
				lodingModal('hide');
            }
		},
		error : function(request, status, error) {
			showNotification("alert-danger",'ERROR', "top", "center", "", "");
			lodingModal('hide');
		}
	});
	return false;
}

function findpwprc(){
	var userEmail = $('#femail').val();

	if(!checkEmail(userEmail)){
		return false;
	}

	$.ajax({
		url: '/login/find_password_prc',
		type: 'POST',
		data: $("#find_pw").serialize(),
		dataType: 'json',
		success: function (result) {
			if( result.rlt == true ){
				showNotification("alert-success", result.msg, "top", "center", "", "");	
				setTimeout(function() {
					location.replace('/');
				}, 3000);
            }else {
				showNotification("alert-warning", result.msg, "top", "center", "", "");			
            }
		},
		error : function(request, status, error) {
			showNotification("alert-danger",'ERROR', "top", "center", "", "");			
		}
	});
	return false;
}

$(document).ready(function() {
	$("#cbx_chkAll").click(function() {
		if($("#cbx_chkAll").is(":checked")) $(".tos").prop("checked", true);
		else $(".tos").prop("checked", false);
	});
})