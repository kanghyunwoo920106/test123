 <main id="main" class="main main-1400">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container px-4 px-lg-5">
			<a href="<?php echo WEB_URL; ?>" class="col-4 logo d-flex align-items-center">
				<span class="d-none d-lg-block"></span>
				<img class="rendering-logo" src="<?php echo IMG_PATH; ?>logo.png" alt="">
			</a>
			<div class="d-flex rendering-btn">
				<button class="btn btn-outline-secondary border-none me-2" type="button"  onclick="infoGo()">팀셀 알아보기</button>				
				<button class="btn btn-outline-green border-none" type="button" onclick="loginGo()">로그인</button>
			</div>
		</div>
	</nav>
	<section class="pt-5">
		<div class="container px-4 px-lg-5 my-5">
			<div class="row gx-4 gx-lg-5 align-items-center">
				<div class="col-md-5">
					<h1 class="rendering-tit fw-bolder">팀과 데이터 <br class="no-pc">공유할 땐,<br>엑셀보다 <b>팀셀</b></h1>
					<div class="fs-5 mb-5">
						<ul class="redner-ul mt-5">
							<li>엑셀처럼 쉽고 직관적인 UI적용</li>
							<li>웹페이지 연동 및 API Collaboration</li>
							<li>복잡한 수식과 기능을 템플릿으로 간편사용.</li>
						</ul>
					</div>
					<p class="lead">파일에서 시트까지 자유롭게 공유하고<br>정리가 필요한 데이터 팀셀 템플릿으로 관리해보세요!</p>
					<div class="d-flex">
						<button class="btn btn-secondary me-3 btn-rendering" type="button" onclick="infoGo()">팀셀 알아보기</button>
                        <button class="btn btn-green btn-rendering" type="button" onclick="loginGo()">로그인</button>
                    </div>
				</div>
				<div class="col-md-7 rendering-img"><img class="card-img-top mb-5 mb-md-0" src="<?php echo IMG_PATH; ?>rendering_bg.png" alt="..."></div>
			</div>
		</div>
	</section>
</main>
<footer class="py-4 bg-dark rendering-footer">
	<div class="container px-4 px-lg-5">
		<button class="btn btn-outline-light border-none btn-sm" type="button" onclick="tosGo()">이용약관</button>
		<button class="btn btn-outline-light border-none btn-sm" type="button" onclick="tosPrGo()">개인정보 처리방침</button>
		<p class="mt-2 text-left text-white">(주)투썬챌린지 : 이종현 &nbsp;&nbsp;&nbsp; 사업자등록번호 : 811-85-02026 <br>
        경기도 성남시 분당구 판교역로 221 투썬월드 B / D &nbsp;&nbsp;&nbsp; |  &nbsp;&nbsp;&nbsp; 문의메일 : support@teemcell.com</p>
        <p class="mt-2 text-left text-white">twosun Inc.  ⓒ 2023</p>
	</div>
</footer>