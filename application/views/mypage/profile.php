<!-- ======= Header ======= -->
<header id="header" class="header sub-header row">
	<div class="col-auto me-auto">
		<a href="#" id="go-back"><i class="bi bi-arrow-left"></i></a>
		<h2 class="sub-header-title">정보수정</h2>
	</div>
</header>
<!-- End Header -->
<main id="main" class="main main-1400">
	<section class="section">
		<div class="container-fluid">
			<h3 class="card-title">개인정보 관리</h3>
			<div class="card profile-card p-4">
				<div class="row">
					<div class="col-2 text-center">
					<?php 
					if(!empty($user_img_path) && !empty($user_img_name) ){
						echo '<img src="'.$user_img_path.'/s_'.$user_img_name.'" id="user_pro_img" alt="Profile" class="rounded-circle profile-img">';
					} else {
						echo '<img src="'.IMG_PATH.'no-profile-img.png" id="user_pro_img" alt="Profile" class="rounded-circle profile-img">';
					}
					?>
						<div class="mb-3">
							<form id="pro_img" name="pro_img">
								<label for="formFile" class="form-label"></label>
								<label class="input-file-button mt-2 text-secondary text-decoration-underline small" for="input-file" style="cursor: pointer;">프로필수정</label>
								<input type="file" id="input-file" name="profile_img" style="display:none" onchange="imgChange(this.form);">
							</form>
						</div>
					</div>
					<div class="col-auto">
						<div class="row">
							<div class="row me-auto">
								<input type="hidden" id="user_name" value="<?php echo $user_name;?>">
								<div class="col-sm-auto" id="editNameArea">
									<span class="profile-name"><?php echo $user_name;?></span>
								</div>
								<div class="col-sm-auto">
									<button type="button" class="btn btn-sm ms-n4 profile-name-edit text-secondary text-decoration-underline" onclick="editName()">이름 수정</button>
								</div>
								<div class="col-sm-auto">								
									<button type="button" class="btn btn-outline-dark btn-sm edit-name-confirm bi bi-check-lg" onclick="changeName()"></button>
								</div>
							</div>
							<div class="row"><span><?php echo $user_id;?></span></div>
							<div class="row mt-4">
								<button type="button" class="btn btn-outline-secondary btn-sm col-auto me-1" data-bs-toggle="modal" data-bs-target="#password_Change_Modal" onclick="resetForm()">비밀번호 변경</button>
								<button type="button" class="btn btn-outline-danger btn-sm col-auto me-1" data-bs-toggle="modal" data-bs-target="#Withdrawal_Modal" onclick="resetForm()">회원탈퇴</button>
								<button type="button" class="btn btn-outline-secondary btn-sm col-auto" onclick="logOut()">로그아웃</button>
							</div>
						</div>
					</div>
				</div>
				<!-- hr>
				<h3 class="card-title">SNS 간편로그인 연동</h3>
				<div class="row">
					<div class="col-sm-auto">
						<button type="button" class="btn btn-outline-success btn-sm pt-2 pb-2 me-3"><img src="<?php echo IMG_PATH;?>icon_naver.png"> 네이버 간편로그인 연동</button>
					</div>
					<div class="col-sm-auto">
						<button type="button" class="btn btn-outline-warning btn-sm pt-2 pb-2"><img src="<?php echo IMG_PATH;?>icon_kakao.png"> 카카오 간편로그인 연동</button>
					</div>
				</div>
				<!-- 연동이 완료됐을때 보여지는 버튼 class에 disabled와 p태그 추가됨 ->
				<div class="row mt-5">
					<div class="col-sm-auto">
						<button type="button" class="btn btn-success btn-sm pt-2 pb-2 me-3 disabled"><img src="<?php echo IMG_PATH;?>icon_naver.png"> 네이버 간편로그인 연동</button>
						<p class="btn-disabled-txt">2023.01.01 연동완료</p>
					</div>
					<div class="col-sm-auto">
						<button type="button" class="btn btn-warning btn-sm pt-2 disabled pb-2"><img src="<?php echo IMG_PATH;?>icon_kakao.png"> 카카오 간편로그인 연동</button>
						<p class="btn-disabled-txt">2023.01.01 연동완료</p>
					</div>
				</div> -->
			</div>
		</div>
	</section>
	<!-- 비밀번호 변경 modal -->
	<div class="modal fade" id="password_Change_Modal" tabindex="-1" aria-labelledby="password_Change_ModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="password_Change_ModalLabel">비밀번호 변경</h1>
					<div data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;"><i class="bi bi-x-lg"></i></div>
				</div>
				<div class="modal-body">
					<div class="alert alert-green d-flex align-items-center mt-4 small" role="alert">
						<div>
							<i class="bi bi-info-circle-fill"></i> SNS 간편 가입 회원은 가입한 SNS사이트에서 비밀번호를 찾을 수 있습니다.
						</div>
					</div>
				<form class="user" id="changepw" method="POST" onSubmit="changepw();return false;">
					<div class="form-group mb-2">
						<label for="chpwd" class="form-label text-danger">현재 비밀번호 </label>
						<input type="password" class="form-control form-control-user" name="nowpwd" id="nowpwd" placeholder="현재 비밀번호를 입력해주세요." required>
					</div>
				
					<div class="form-group mb-2">
						<label for="chpwd" class="form-label">새로운 비밀번호 <span class="label-password">특수문자를 포함한 8~16 자리의 비밀번호를 입력해주세요.</span></label>
						<input type="password" class="form-control form-control-user" name="chpwd" id="chpwd" placeholder="새로운 비밀번호를 입력해주세요." required>
					</div>
					<div class="form-group mb-2">
						<label for="re-chpwd" class="form-label">비밀번호 재확인</label>
						<input type="password" class="form-control form-control-user" name="re-chpwd" id="re-chpwd" placeholder="새로운 비밀번호를 동일하게 다시 입력해주세요." required>
					</div>
					<div class="d-grid mt-4">
						<button type="submit" class="btn btn-green">비밀번호 변경하기</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<!-- 회원탈퇴 modal -->
	<div class="modal fade" id="Withdrawal_Modal" tabindex="-1" aria-labelledby="Withdrawal_ModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5" id="Withdrawal_ModalLabel">회원탈퇴</h1>
					<div data-bs-dismiss="modal" aria-label="Close" style="cursor: pointer;"><i class="bi bi-x-lg"></i></div>
				</div>
				<div class="modal-body">
				<form class="user" id="leaveUser" name="leaveUser" method="POST" onSubmit="userLeave();return false;">
					<div class="alert alert-danger d-flex align-items-center mt-2 small" role="alert">
						<div>
							<i class="bi bi-info-circle-fill"></i> 탈퇴 시 작성한 문서 및 공유된 모든 설정들은 <b>영구 삭제되어 복구하실 수 없습니다.</b>
						</div>
					</div>
					<div class="col mb-2">
						<label for="leaveRes" class="form-label">탈퇴하시는 사유를 선택해주세요.</label>
						<select id="leaveRes" name="leaveRes" class="form-select mb-2">
							<option value="0" selected>탈퇴사유를 선택해주세요.</option>
							<option value="6">모든 문서를 삭제하고 싶어서</option>
							<option value="1">이용이 불편하고 장애가 많아서</option>
							<option value="2">다른 엑셀서비스가 더 좋아서</option>
							<option value="3">사용빈도가 낮아서</option>
							<option value="4">원하는 콘텐츠가 없어서</option>
							<option value="5">개인정보를 삭제하고 싶어서</option>
							<option value="7">기타</option>
						</select>
					</div>
					<div class="form-floating mt-2">
						<textarea class="form-control" placeholder="내용을 입력해주세요." id="leaveNote" name="leaveNote" style="height: 100px"></textarea>
						<label for="text-area" class="form-label">기타 의견</label>
					</div>
					<div class="form-group mt-2">
						<label for="leavePwd" class="form-label">비밀번호 입력</label>
						<input type="password" class="form-control form-control-user" id="leavePwd" name="leavePwd" placeholder="비밀번호를 입력해주세요." required>
					</div>
					<div class="d-grid mt-4">
						<button type="submit" class="btn btn-danger">영구삭제 및 탈퇴하기</button>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="edit-comment-modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="comment">댓글:</label>
							<textarea class="form-control" id="comment" rows="3" value="[댓글 내용]"></textarea>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</main>
<!-- End #main --

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>User Profile</h3>
        </div>
        <div class="title_right"></div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">                    
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-3 col-sm-3  profile_left">
                        <div class="profile_img">
                            <div id="crop-avatar">
                                <!-- Current avatar --
                                <img class="img-responsive avatar-view" src="/resources/images/page/picture.jpg" alt="Avatar" title="Change the avatar">
                            </div>
                        </div>
                        <h3>Samuel Doe</h3>
                        <ul class="list-unstyled user_data">
                            <li>
                                <i class="fa fa-map-marker user-profile-icon"></i> San Francisco, California, USA
                            </li>
                            <li>
                                <i class="fa fa-briefcase user-profile-icon"></i> Software Engineer
                            </li>
                            <li class="m-top-xs">
                                <i class="fa fa-external-link user-profile-icon"></i>
                                <a href="http://www.kimlabs.com/profile/" target="_blank">www.kimlabs.com</a>
                            </li>
                        </ul>
                        <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile Photo</a>
                        <br />
                    </div>
                    <div class="col-md-9 col-sm-9 ">
                        <div class="x_content">
                            <form class="" action="" method="post" novalidate>
                                <p>For alternative validation library <code>parsleyJS</code> check out in the <a href="form.html">form page</a>
                                </p>
                                <span class="section">Personal Info</span>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Name<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="ex. John f. Kennedy" required="required" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Occupation<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" class='optional' name="occupation" data-validate-length-range="5,15" type="text" />
                                    </div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">email<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" name="email" class='email' required="required" type="email" /></div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Confirm email address<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="email" class='email' name="confirm_email" data-validate-linked='email' required='required' /></div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Number <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="number" class='number' name="number" data-validate-minmax="10,100" required='required'></div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Date<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" class='date' type="date" name="date" required='required'></div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Time<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" class='time' type="time" name="time" required='required'></div>
                                </div>
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Password<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="password" id="password1" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" title="Minimum 8 Characters Including An Upper And Lower Case Letter, A Number And A Unique Character" required />
                                        
                                        <span style="position: absolute;right:15px;top:7px;" onclick="hideshow()" >
                                            <i id="slash" class="fa fa-eye-slash"></i>
                                            <i id="eye" class="fa fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Repeat password<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="password" name="password2" data-validate-linked='password' required='required' /></div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">Telephone<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input class="form-control" type="tel" class='tel' name="phone" required='required' data-validate-length-range="8,20" /></div>
                                </div>
                                <div class="field item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3  label-align">message<span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea required="required" name='message'></textarea></div>
                                </div>
                                <div class="ln_solid">
                                    <div class="form-group">
                                        <div class="col-md-6 offset-md-3">
                                            <button type='submit' class="btn btn-primary">Submit</button>
                                            <button type='reset' class="btn btn-success">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>       -->