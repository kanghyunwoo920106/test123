function changepw(){
	var userPwd = $('#urpw').val();
	var reUserPwd = $('#reurpw').val();

	if(userPwd != reUserPwd){
		showNotification("alert-success", "재입력한 비밀번호가 일치하지 않습니다", "top", "center", "", "");
		return false;
	}

	if(!checkPassword(userPwd)){
		return false;
	}

	$.ajax({
		url: '/auth/fpw_prc',
		type: 'POST',
		data: $("#changepw").serialize(),
		dataType: 'json',
		success: function (result) {
			if (result.code == 200) {
				showNotification("alert-success", result.msg, "top", "center", "", "");
				setTimeout(function() {
					location.replace('/login');
				}, 1000);
			} else showNotification("alert-warning", result.msg, "top", "center", "", "");
		},
		error : function(request, status, error) {
			showNotification("alert-danger", error, "top", "center", "", "");
		}
	});
	return false;
}