<main id="main" class="main main-1400">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-5 col-lg-12 col-md-9">
				<div class="row d-flex mt-5">
					<a href="<?php echo WEB_URL;?>" class="col-4 logo">
						<span class="d-none d-lg-block"></span>
						<img src="<?php echo IMG_PATH;?>logo.png" alt="TEEMcell">
					</a>
				</div>
				<div class="card o-hidden border-0 shadow-lg my-3 login-area">
					<div class="card-body p-0">
						<div class="row">
							<div class="col-lg-12">
								<div class="p-5">
									<div class="text-center">
										<h1 class="h4 fw-bolder mb-2">비밀번호 변경</h1>
										<p class="small">원하시는 새로운 비밀번호로 변경해주세요.</p>
									</div>
									<div class="alert alert-green d-flex align-items-center small mt-4" role="alert">
										<div>
											<i class="bi bi-info-circle-fill"></i> SNS 간편 가입 회원은 가입한 SNS사이트에서 비밀번호를 찾을 수 있습니다.
										</div>
									</div>
									<form class="user" id="changepw" method="POST" onSubmit="changepw();return false;">
										<input type="hidden" id="tccd" name="tccd" value="<?php echo $tccd;?>">
										<div class="form-group mb-2">
											<label for="InputPassword" class="form-label">새로운 비밀번호 <span class="label-password">특수문자를 포함한 8~16자리를 입력해주세요.</span></label>
											<input type="password" class="form-control form-control-user" name="urpw" id="urpw" placeholder="비밀번호를 입력해주세요." required>
										</div>
										<div class="form-group mb-2">
											<label for="Re-InputPassword" class="form-label">비밀번호 재확인</label>
											<input type="password" class="form-control form-control-user" name="reurpw"id="reurpw" placeholder="비밀번호를 동일하게 다시 입력해주세요." required>
										</div>
										<div class="d-grid gap-2 mb-4">
											<button type="submit" class="btn btn-green">비밀번호 변경하기</button>
										</div>
										<div class="text-center small">
											<a href="/login">로그인하러 가기</a>
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
  </main>