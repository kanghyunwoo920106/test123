<header id="header" class="header fixed-top d-flex share-page">
	<div class="col-auto myfile-title-area">
		<span id="dtype_dom" class="badge rounded-pill"></span>	
		<p id="doc_title"></p>
	</div>
	<div class="col-auto ms-auto" id="save_btn">		
	</div>
	<div class="col-auto dropdown ms-5 me-5 mt-1">
		<svg type="button"  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-stoplights dropdown-toggle" viewBox="0 0 16 16" data-bs-toggle="dropdown" aria-expanded="false">
			<path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
		</svg> 
		<ul class="dropdown-menu" id="share_menu">
			 <li><a class="dropdown-item btn-file-authority" href="#"><i class="bi bi-file-lock2"></i> 문서 권한보기</a></li>
			<li><a class="dropdown-item" href="<?php echo WEB_URL;?>"><i class="bi bi-house"></i> 팀셀 홈 바로가기</a></li>
		</ul>
	</div>
</header>
<input type="hidden" id="shcd_en" value="<?php echo $shcd_en;?>">
<main id="main" class="main main-100" style="padding:0;">
	<div id="excel_area" style="width:100%;z-index:-1;position:fixed;"></div>
	<div id="designerHost" style="width:100%;z-index:-1;position:fixed;height:94%;"></div>	
	<!-- ======= 권한 ======= -->
	<aside id="file-authority" class="file file-authority">
		<div class="row file-top">
			<h5 class="col-auto me-auto">문서권한 보기</h5>
			<div class="col-auto btn-close-sidemenu"><i class="bi bi-x-lg"></i></div>
		</div>
		<div class="col-12">
			<div class="alert alert-green" role="alert">
				<div>
					<p id="share_info_txt"><i class="bi bi-exclamation-circle"></i> 본 파일의 사용권한을 확인해주세요.<br>
					편집권한이 없을경우 편집을 해도 
					저장이 되지 않습니다.</p>
				</div>
			</div>
			<div class="d-grid gap-2 text-center file-authority-txt" id="shd_list">				
			</div>
		</div>
	</aside>
	<!-- End Memo-->
</main>