<!-- ======= Header ======= -->
<header id="header" class="header sub-header row">
    <div class="col-auto me-auto">
        <a href="#" id="go-back"><i class="bi bi-arrow-left"></i></a>
        <h2 class="sub-header-title">내문서</h2>
    </div>
    <div class="col-auto">
        <button type="button" class="btn btn-green" onclick="location.href='/Doc/write'">새문서 작성</button>
    </div>
</header><!-- End Header -->
<input type="hidden" id="doc_type" value="A">
<input type="hidden" id="page_num" value="0">
<input type="hidden" id="doc_ord" value="D">
<input type="hidden" id="doc_cor" value="all">
<main id="main" class="main main-1400">
    <section class="section">
		<div class="row">
			<div class="alert alert-white d-flex align-items-center" role="alert">
				<i class="bi bi-bell-fill"></i>
				<?php
				$this->load->view("include/berner");
				?>
			</div>
			<div class="d-grid gap-2 d-md-flex justify-content-md-end sort-area">
				<button class="btn" type="button" onclick="orderDoc('D')"><i class="bi bi-sort-down"></i></button>
				<button class="btn" type="button" onclick="orderDoc('A')"><i class="bi bi-sort-down-alt"></i></button>
				<div class="btn dropdown">
					<div class="dropdown-toggle" id="color-dropdown" data-bs-toggle="dropdown">
						<div id="act-color" data-color="all" class="color-label all active"></div>
					</div>
					<div class="dropdown-menu sort" aria-labelledby="color-dropdown">
						<div class="dropdown-item" data-value="red"><div id="red" class="color-label red" data-color="red"></div></div>
						<div class="dropdown-item" data-value="orange"><div id="orange" class="color-label orange" data-color="orange"></div></div>
						<div class="dropdown-item" data-value="yellow"><div id="yellow" class="color-label yellow" data-color="yellow"></div></div>
						<div class="dropdown-item" data-value="green"><div id="green" class="color-label green" data-color="green"></div></div>
						<div class="dropdown-item" data-value="blue"><div id="blue" class="color-label blue" data-color="blue"></div></div>
						<div class="dropdown-item" data-value="navy"><div id="navy" class="color-label navy" data-color="navy"></div></div>
						<div class="dropdown-item" data-value="purple"><div id="purple" class="color-label purple" data-color="purple"></div></div>
						<div class="dropdown-item" data-value="all"><div id="purple" class="color-label all" data-color="all"></div></div>
					</div>
				</div>
			</div>
			<ul class="nav nav-tabs nav-tabs-bordered justify-content-center" id="borderedTabJustified" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="all-tab" data-bs-toggle="tab" type="button" role="tab" aria-selected="true" onclick="myDocument('A')">전체</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="write-tab" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="myDocument('M')">내가 작성한 문서</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="shared-tab" data-bs-toggle="tab" type="button" role="tab" aria-selected="false" onclick="myDocument('S')">공유 받은 문서</button>
				</li>
			</ul>
				<h3 class="card-title">이전 문서</h3>
				<div class="myfile-item-list" id="myfile-item-list">                
				</div>   
			<div class="d-flex justify-content-center">
				<div class="spinner-border" role="status" id="loding-area" style="display:none">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
    </section>
</main>