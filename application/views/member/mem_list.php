<header id="header" class="header sub-header row">
	<div class="col-auto me-auto">
		<a href="#" id="go-back"><i class="bi bi-arrow-left"></i></a>
		<h2 class="sub-header-title">이메일 주소록</h2>
	</div>
</header>
<main id="main" class="main main-1400">
	<section class="section">
		<div class="row">
			<div class="alert alert-green" role="alert">
				<div>
					<h5 class="fs-6"><i class="bi bi-exclamation-circle"></i> 주소록 안내</h5>
					 <ul>
						<li>등록한 이메일이 팀셀 회원이면, 프로필 이미지가 표시 됩니다.</li>
						<li>편집 권한 부여받은 사용자는 팀셀회원인 상태에서만 편집을 할 수 있습니다. (편집 공유시 비회원이면, 꼭 회원가입 요청해주세요)</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-12 add-card">
				<h5 class="card-title">추가할 이메일을 입력해주세요</h5>
				<div class="card add-card">
					<div class="card-body">
					<form class="row gy-2 gx-3 align-items-end" id="mem_form">
						<div class="col-auto">
							<label for="colFormLabel" class="form-label">이름</label>
							<input type="text" required class="form-control" id="mem_name" name="mem_name" placeholder="이름을 입력해주세요">
						</div>
						<div class="col-auto">
							<label for="colFormLabel" class="form-label">이메일</label>
							<input type="text" required class="form-control" id="mem_email_f" name="mem_email_f" placeholder="이메일을 입력해주세요">
						</div>
						<div class="col-auto mt-2">
							<div class="input-group">
								<div class="input-group-text">@</div>
								<input type="text" class="form-control" id="mem_email_s" name="mem_email_s" placeholder="">
							</div>
						</div>
						<div class="col-auto">
							<select class="form-select" id="email_sel" name="email_sel">
								<option selected value="">직접입력</option>
								<option value="naver.com">naver.com</option>
								<option value="gmail.com">gmail.com</option>
								<option value="daum.net">daum.net</option>
								<option value="nate.com">nate.com</option>
							</select>
						</div>
						<div class="col-auto">
							<button type="button" class="btn btn-green" onClick='addUserMem()'>+ 이메일 추가</button>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row-12">
			<input type="hidden" id="page_nm" value="1">
			<div class="row align-items-end">
				<div class="col-auto me-auto">
					<h3 class="card-title pb-0">총 <span id="total_cnt">00</span>건의 이메일 주소록이 존재합니다.</h3>
				</div>
				<div class="col-auto">
					<select class="form-select" id="mem_order" onchange="userMemList('F')">           
						<option value="1" selected>최신등록순</option>
						<option value="2">가나다순</option>
					</select>
				</div>
				<div class="col-auto">
					<button type="button" id="select-all" class="btn btn-outline-secondary btn-md">전체선택</button>
					<button type="button" class="btn btn-secondary btn-md" onclick="checkDelMember()">선택삭제</button>
				</div>
			</div>
			<div class="row-12">       
				<div class="list-group add-list" id="add-list">
				</div>
			</div>
			<div class="d-flex justify-content-center">
				<div class="spinner-border" role="status" id="loding-area" style="display:none">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
	</section>
</main>
