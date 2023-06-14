<input type="hidden" id="pageNum" value="0">
<input type="hidden" id="docOrd" value="A">
<input type="hidden" id="lcate" value="D">
<input type="hidden" id="mcate" value="D">
<input type="hidden" id="scate" value="D">
<input type="hidden" id="searchStr" value="">

<main id="main" class="main">
	<section class="section">
		<div class="alert alert-white d-flex align-items-center" role="alert">
			<i class="bi bi-bell-fill"></i>
			<?php
			$this->load->view("include/berner");
			?>
		</div>
		<div class="d-flex justify-content-end align-items-center">
			<div class="d-grid d-md-flex justify-content-md-end sort-area">
				<button class="btn px-1" type="button" onclick="orderDoc('D')"><i class="bi bi-sort-down"></i></button>
				<button class="btn px-1" type="button" onclick="orderDoc('A')"><i class="bi bi-sort-down-alt"></i></button>
			</div>
			<div class="d-flex align-items-center">
				<input type="text" id="search_title" class="form-control" name="search_title"><button class="btn col-auto btn-green btn-md ms-1" type="button" onclick="searchTitle()">검색</button>
			</div>
		</div>
		<div class="row align-items-top" id="template_list">
		</div>
		<div class="d-flex justify-content-center">
			<div class="spinner-border" role="status" id="loding-area" style="display:none">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
	</section>
</main>