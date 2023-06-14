<main id="main" class="main main-1400">
<div class="container">
	<div class="row justify-content-center">
		 <div class="col-4">
			<div class="row d-flex mt-5">
				<a href="<?php echo WEB_URL;?>" class="col-4 logo">
					<span class="d-none d-lg-block"></span>
					<img src="<?php echo IMG_PATH;?>logo.png" alt="TEEMcell">
				</a>
			</div>
			<div>
				<a class="hiddenanchor" id="signup"></a>
				<a class="hiddenanchor" id="signin"></a>
				<a class="hiddenanchor" id="findpw"></a>
				<div class="login_wrapper">
					<div class="animate form login_form">			
						<div class="card o-hidden border-0 shadow-lg my-3 login-area">
							<input type="hidden" name="reurl" id="reurl" value="<?php echo $reurl; ?>">
							<div class="card-body p-0">
								<div class="row">
									<div class="col-12">
										<div class="p-5">
											<div class="text-center">
												<h1 class="h4 fw-bolder mb-4">로그인</h1>
											</div>
											<form class="user" id="sign_in" method="POST" onSubmit="login();return false;">
												<div class="form-group mb-2">
													<input type="email" class="form-control form-control-user" id="user_id" name="user_id" aria-describedby="emailHelp" placeholder="이메일을 입력해주세요." required>
												</div>
												<div class="form-group mb-4">
													<input type="password" class="form-control form-control-user" id="user_pass" name="user_pass" placeholder="비밀번호를 입력해주세요" required>
												</div>
												<div class="text-center small">
													<span>아직 팀셀 회원이 아니신가요?</span><a href="#signup" class="to_register" onclick="resetForm()"> 회원가입</a>
												</div>
												<div class="text-center small">
													<span>비밀번호를 잊어버리셨나요?</span><a href="#findpw" class="to_register" onclick="resetForm()"> 비밀번호 찾기</a>
												</div>
												<div class="d-grid gap-2 mt-4">
													<button type="submit" class="btn btn-green pt-2 pb-2">로그인</button>
												</div>
												<!-- <div class="text-center">
													<h5 class="h5 fw-bolder mb-4">SNS 로그인</h5>
												</div>
												<div class="d-grid gap-2">
													<button type="button" class="btn btn-outline-success btn-sm pt-2 pb-2"><img src="<?php echo IMG_PATH;?>icon_naver.png"> 네이버 간편로그인</button>
													<button type="button" class="btn btn-outline-warning btn-sm pt-2 pb-2"><img src="<?php echo IMG_PATH;?>icon_kakao.png"> 카카오 간편로그인</button>
												</div>
												-->
												<div class="copyright text-center mt-4">
													<span>ⓒ Twosun Corp.</span>
												</div>
											</form>
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
					<div id="register" class="animate form registration_form">			
						<div class="card o-hidden border-0 shadow-lg my-3 login-area">
							<div class="card-body p-0">
								<div class="row">
									<div class="col-lg-12">
										<div class="p-5">
											<div class="text-center">
												<h1 class="h4 fw-bolder mb-4">회원가입</h1>
											</div>
											<form class="user" id="create_account" method="POST" onSubmit="accountprc();return false;">
												<div class="form-group mb-2">
													<label for="InputName" class="form-label">이름</label>
													<input  class="form-control form-control-user" id="cre_user_name" name="user_name" placeholder="이름을 입력해주세요." required>
												</div>
												<div class="form-group mb-4">
													<label for="InputEmail" class="form-label">이메일</label>
													<input type="email" class="form-control form-control-user" id="cre_user_email" name="user_email" aria-describedby="emailHelp" placeholder="이메일을 입력해주세요." required>
												</div>
												<div class="form-group mb-4">
													<label for="InputPassword" class="form-label">비밀번호</label><span class="label-password ms-auto">특수문자를 포함한 8~16자리를 입력해주세요.</span>
													<input type="password" class="form-control form-control-user" id="cre_user_pwd" name="user_pass" placeholder="비밀번호를 입력해주세요." required>
												</div>
												<div class="form-check all">
													<input class="form-check-input" type="checkbox" value="" id="cbx_chkAll">
													<label class="form-check-label" for="cbx_chkAll" onclick="alltos()">
														약관에 모두 동의합니다.
													</label>
												</div>
												<div class="form-check essential">
													<input class="form-check-input tos" name="tos1" type="checkbox" value="Y" id="tos1">
													<label class="form-check-label" for="tos1">
														<span class="join_red">(필수)</span> 팀셀 <a target="_blank" href="https://teemcell.imweb.me/policy">서비스 이용약관</a>에 동의
													</label>
												</div>
												<div class="form-check essential">
													<input class="form-check-input tos" name="tos2" type="checkbox" value="Y" id="tos2">
													<label class="form-check-label" for="tos2">
														<span class="join_red">(필수)</span> <a target="_blank" href="https://teemcell.imweb.me/privacy">개인정보 수집 및 이용</a>에 동의
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input tos" name="tos3" type="checkbox" value="Y" id="tos3">
													<label class="form-check-label" for="tos3">
														(선택) <a target="_blank" href="https://teemcell.imweb.me/marketing_agree">마케팅 광고 정보 제공</a>에 동의
													</label>
												</div>
												<div class="d-grid gap-2 mt-4">
													<button type="submit" class="btn btn-green pt-2 pb-2">회원가입 (무료)</button>
												</div>
												<div class="text-center small mt-2">
													<span>이미 회원이시라면</span> <a href="#signin" class="to_register" onclick="resetForm()"> 로그인하기</a>
												</div>
												<!--
												<div class="text-center">
													<h5 class="h5 fw-bolder mb-4">SNS 로그인</h5>
												</div>
												<div class="d-grid gap-2">
													<button type="button" class="btn btn-outline-success btn-sm pt-2 pb-2"><img src="<?php echo IMG_PATH;?>icon_naver.png"> 네이버 간편로그인</button>
													<button type="button" class="btn btn-outline-warning btn-sm pt-2 pb-2"><img src="<?php echo IMG_PATH;?>icon_kakao.png"> 카카오 간편 로그인</button>
												</div>
												-->
												<div class="copyright text-center mt-4">
													<span>ⓒ Twosun Corp.</span>
												</div>
											</form>
										</div>
									</div>									
								</div>
							</div>
						</div>				
					</div>
					<div id="findpw" class="animate form findpassword_form">			
						<div class="card o-hidden border-0 shadow-lg my-3 login-area">
							<div class="card-body p-0">
								<div class="row">
									<div class="col-12">
										<div class="p-5">
											<div class="text-center">
												<h1 class="h4 fw-bolder mb-2">비밀번호 찾기</h1>
												<p class="small">이메일 주소로 비밀번호 변경 페이지가 발송됩니다.</p>
											</div>
											<div class="alert alert-green d-flex align-items-center mt-4 mb-3" role="alert">
												<div>
													<i class="bi bi-info-circle-fill"></i> SNS 간편 가입 회원분은 가입한 SNS사이트에서 비밀번호 찾을 수 있습니다.
												</div>
											</div>
											<form class="user" id="find_pw" method="POST" onSubmit="findpwprc();return false;">
												<div class="form-group mb-2">
													<input type="email" name="femail" class="form-control form-control-user" id="femail" aria-describedby="emailHelp" placeholder="이메일을 입력해주세요." required>
												</div>
												<div class="d-grid gap-2 mb-4">
													<button type="submit" class="btn btn-green">비밀번호 변경페이지 발송</button>
												</div>
												<div class="text-center small">
													<a href="#signin" class="to_register" onclick="resetForm()"> 로그인하러 가기</a>
												</div>
											</form>
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
  </main>