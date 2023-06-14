<header id="header" class="header sub-header row">
	<div class="col-auto me-auto">
		<a href="#" id="go-back"><i class="bi bi-arrow-left"></i></a>
		<h2 class="sub-header-title">히스토리</h2>
	</div>
	<div class="col-auto">
		<button type="button" class="btn btn-secondary" onclick="selDocHistoryData()">
		<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
			<path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.812 6.812 0 0 0 1.16 8z"/>
		</svg>
		선택 문서로 복원</button>
  </div>
</header><!-- End Header -->
<input type="hidden" id="doc_id" value="<?php echo $doc_id;?>">
<input type="hidden" id="doc_ht" value="S">
<main id="main" class="main main-100" style="padding:0;">
	<div id="excel_area" style="width: 100%;  z-index: -1;  position: fixed; height:900px;"></div>
	<aside id="history" class="history">
		<div class="row">
			<input type="hidden" id="sel_his_id" value="">
			<div class="history-list mt-3" id="history_list">
				<h5>이전 문서</h5>
			</div>
			<div class="d-flex justify-content-center">
				<div class="spinner-border" role="status" id="history_list_loading">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
	</aside>
</main>