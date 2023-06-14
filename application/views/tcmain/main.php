<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
	<div class="d-grid gap-2 mt-3"></div>
	<ul class="sidebar-nav" id="sidebar-nav">		
		<li class="nav-item">
			<a class="nav-link collapsed" href="/Doc/template">
				<i class="bi bi-layout-text-window-reverse"></i><span>템플릿</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" href="/doc/my_doc">
				<i class="bi bi-files"></i><span>내문서</span>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" data-bs-target="#charts-nav" href="/Mem/mlist">
				<i class="bi bi-person-video2"></i><span>주소록</span></i>
			</a>
		</li>
		<li class="nav-item">
			<a class="nav-link collapsed" data-bs-target="#charts-nav" target="_blank" href="https://teemcell.imweb.me/30">
				<i class="bi bi-megaphone"></i><span>공지사항</span></i>
			</a>
		</li>
		<li class="nav-item nav-footer first">
			<a class="nav-link collapsed emphasize" target="_blank" href="https://teemcell.imweb.me/privacy">개인정보처리방침</a>
		</li>
		<li class="nav-item nav-footer">
			<a class="nav-link collapsed" target="_blank" href="https://teemcell.imweb.me/policy">이용약관</a>
		</li>
		<li class="nav-item nav-footer">
			<a class="nav-link collapsed" target="_blank" href="https://teemcell.imweb.me/customer">고객센터</a>
		</li>
	</ul>

	

</aside>
<main id="main" class="main">
	<section class="section dashboard">
		<div class="row">
			<div class="cols-12 alert alert-white d-flex align-items-center" role="alert">
				<i class="bi bi-bell-fill"></i>
				<?php
				$this->load->view("include/berner");
				?>
			</div>
			<div class="cols-12 no-pd">
				<h5 class="card-title ms-2">템플릿</h5>
				<div class="card">
					<div class="card-body pt-4"> 
						<div class="row row-cols-6" id="main_template">
						</div>
					</div>
				</div>
				<h5 class="card-title ms-2">내문서</h5>
					<div class="card">
						<div class="card-body pt-4"> 
							<div class="row row-cols-6" id="main_document">
								<div class="col-auto">									
									<div class="card myfile-item new">
										<a href="/Doc/write/F/">
										<div class="card-body">
											<i class="bi bi-plus-circle"></i>
											<h5 class="card-in-title">새문서 작성</h5>
										</div>
										</a>
									</div>
								</div>
							</div>
						</div>				
					</div>
				</div>
			</div>
		</div>
	</section>
</main>