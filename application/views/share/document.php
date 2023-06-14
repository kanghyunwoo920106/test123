<header id="header" class="header fixed-top d-flex share-page">
	<div class="col-auto myfile-title-area">		
		<span id="dtype_dom" class="badge rounded-pill"></span>	
		<p id="doc_title"></p>
	</div>
	<div class="col-auto dropdown ms-auto me-5 mt-1">
		<svg type="button"  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-stoplights dropdown-toggle" viewBox="0 0 16 16" data-bs-toggle="dropdown" aria-expanded="false">
			<path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
		</svg> 
		<ul class="dropdown-menu" id="share_menu">			
			<li><a class="dropdown-item" href="<?php echo WEB_URL;?>"><i class="bi bi-house"></i> 팀셀 홈 바로가기</a></li>
		</ul>
	</div>
</header>
<input type="hidden" id="shcd_en" value="<?php echo $shcd_en;?>">
<main id="main" class="main main-100" style="padding:0;">
	<div id="excel_area" style="width:100%;position:fixed;height:94%"></div>
</main>