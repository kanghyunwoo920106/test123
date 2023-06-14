 <main id="main" class="main main-1400">
	<div class="container">		
		<div class="row justify-content-center text-center">
			<div class="col-xl-5 col-lg-12 col-md-9">
				<div class="d-block row mt-5">
					<a href="index.html" class="col-4 logo">
						<span class="d-none d-lg-block"></span>
						<img src="<?php echo IMG_PATH;?>logo.png" alt="TEEMcell">
					</a>
				</div>
				<div class="d-block row">
					<div class="col-lg-12">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h3 fw-bolder mb-4">이메일 인증이 유효하지 않습니다.</h1>
								<p class="medium">회원님의 이메일인증에 실패하였습니다. <br>
								인증시간이 경과하였거나 잘못된 인증정보로 접속하였습니다. <br>다시 시도해주세요.</p>
							</div>
							<img src="<?php echo IMG_PATH;?>email_fail.png" alt="email_fail">
							<div class="row mt-4">
								<button type="button" class="col btn btn-green btn-md" onclick="location.href='/login#signup';">회원가입</button> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>