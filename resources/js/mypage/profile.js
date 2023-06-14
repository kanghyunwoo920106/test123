// 프로필 이미지 수정
function imgChange(frm){
	var fileCheck = frm.profile_img.value;

	// 이미지
	if(!fileCheck) {
		showNotification("alert-warning", "적용할 썸네일을 등록해 주세요.", "top", "center", "", "");
		return false;
	}
	var formData = new FormData(frm);

	$.ajax({
		url: "/Mypage/change_profile_img_prc",
		type: "POST",
		dataType: 'json',
		enctype: 'multipart/form-data',
		processData:false,
		contentType:false,
		data: formData,
		success: function (result) {
			if (result.code == 200) {
				$("#user_pro_img").attr("src", result.data['img_url']);
				showNotification("alert-success", "변경 되었습니다.", "top", "center", "", "");
			}
			else showNotification("alert-warning", result.msg, "top", "center", "", "");
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
		},
	});
}

// 이름 수정
function editName(){
	var str_input = '<input type="text" id="new_user_name" name="new_user_name" value="'+$('#user_name').val()+'">';
	$('#editNameArea').html(str_input);
	$(".edit-name-confirm").css("display","inline-block"); 
	$(".profile-name-edit").css("display","none"); 
}

function changeName(){
	var now_name = $('#user_name').val();
	var new_name = $('#new_user_name').val();

	if(now_name == new_name ){
		$('#editNameArea').html(new_name);
		$(".edit-name-confirm").css("display","none"); 
		$(".profile-name-edit").css("display","inline-block"); 
		return false;
	} else {
		if(!checkName(new_name)){
			return false;
		} else {
			$.ajax({
				url: "/Mypage/change_user_name_prc",
				type: 'POST',
				dataType: 'json',
				data: {
					newName: new_name
				},
				success: function (result) {
					if (result.code == 200) {					
						showNotification("alert-success", "변경 되었습니다.", "top", "center", "", "");
						$('#user_name').val(new_name);
						$('#editNameArea').html(new_name);
						$(".edit-name-confirm").css("display","none"); 
						$(".profile-name-edit").css("display","inline-block"); 
					}
					else showNotification("alert-warning", result.msg, "top", "center", "", "");
				},
				error: function (request, status, error) {
					showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
				},
			});
		}
	}
}

function changepw(){
	var userPwd = $('#chpwd').val();
	var reUserPwd = $('#re-chpwd').val();

	if(userPwd != reUserPwd){
		showNotification("alert-warning", "재입력한 비밀번호가 일치하지 않습니다.", "top", "center", "", "");
		return false;
	}
	
	if(!checkPassword(userPwd)){
		return false;
	}

	$.ajax({
		url: '/Mypage/change_password_prc',
		type: 'POST',
		data: $("#changepw").serialize(),
		dataType: 'json',
		success: function (result) {
			if(result.code == 200){
				showNotification("alert-success", result.msg, "top", "center", "", "");	
				$('#password_Change_Modal').modal('hide');
			}
			else showNotification("alert-warning", result.msg, "top", "center", "", "");		
		},
		error : function(request, status, error) {
			showNotification("alert-danger", error, "top", "center", "", "");
		}
	});
	return false;
}

function userLeave(){	
	var userPwd = $('#leavePwd').val();
	if(!checkPassword(userPwd)){
		return false;
	}

	var count = $('#leaveRes option:selected').val();
	if(count == 0) {
		showNotification("alert-warning", "탈퇴 사유를 선택 해 주세요!", "top", "center", "", "");	
		return false;
	}

	$.ajax({
		url: '/Mypage/leave_user_prc',
		type: 'POST',
		data: $("#leaveUser").serialize(),
		dataType: 'json',
		success: function (result) {
			if(result.code == 200){
				showNotification("alert-success", result.msg, "top", "center", "", "");					
				location.replace('/Login/signout');
			}
			else showNotification("alert-warning", result.msg, "top", "center", "", "");		
		},
		error : function(request, status, error) {
			showNotification("alert-danger", error, "top", "center", "", "");
		}
	});
	return false;

}

function logOut(){
	location.replace('/Login/signout');
}

window.onload = function(){
	document.getElementById("go-back").addEventListener("click", () => {
		history.back();
	});
};