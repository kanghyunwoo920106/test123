<input type="hidden" id="web_url" value="<?php echo WEB_URL;?>">
<header id="header" class="header fixed-top d-flex align-items-center work-header">	
	<div class="row d-flex align-items-center justify-content-between">
		<a href="/TCmain" onclick="return confirm('대시보드로 이동 하시겠습니까?');" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="대시보드">
			<i class="bi bi-grid"></i>
		</a>
	</div>	
	<div class="col-auto myfile-title-area">
		<div class="input-group input-group-sm work-sheet-title">					
		<?php 
		if($method == 'views'){ 
		?>
			<div class="color-label" id="doc_act_color"></div>	
			<span class="form-control no-border" id="doc_title_txt">test</span>
			<input type="hidden" id="doc_title" value="">
		<?php 
		} else { 
		?>
			<div class="btn dropdown">
				<div class="dropdown-toggle" id="color-dropdown" data-bs-toggle="dropdown">
					<div id="act-color" data-color="red" class="color-label red active"></div>
				</div>
				<div class="dropdown-menu sort" aria-labelledby="color-dropdown">
					<div class="dropdown-item" data-value="red"><div class="color-label red" data-color="red"></div></div>
					<div class="dropdown-item" data-value="orange"><div class="color-label orange" data-color="orange"></div></div>
					<div class="dropdown-item" data-value="yellow"><div class="color-label yellow" data-color="yellow"></div></div>
					<div class="dropdown-item" data-value="green"><div class="color-label green" data-color="green"></div></div>
					<div class="dropdown-item" data-value="blue"><div class="color-label blue" data-color="blue"></div></div>
					<div class="dropdown-item" data-value="navy"><div class="color-label navy" data-color="navy"></div></div>
					<div class="dropdown-item" data-value="purple"><div class="color-label purple" data-color="purple"></div></div>
				</div>
			</div>
		<?php 
			if($method == 'view'){ 
		?>
			<input type="text" class="form-control no-border" id="doc_title" placeholder="내문서 타이틀">
		<?php 
			} else {
		?>
			<input type="text" class="form-control" id="doc_title" placeholder="내문서 타이틀">
		<?php
			}
		} ?>			
		</div>	
	</div>
	<nav class="header-nav ms-auto">
		<ul class="d-flex align-items-center">
			<li class="nav-item">
				<?php 
					if(in_array($method, ['view', 'views'])) { 
						if($method != 'views' || $doc_edit != 'N'){
				?>
					<button type="button" class="col-auto btn btn-green btn-md me-4 btn-save" onClick="modifyDocData()"><i class="bi bi-save"></i> 저장</button>
				<?php 
						}
				} else { ?>
					<button type="button" class="col-auto btn btn-green btn-md me-4 btn-save" onClick="addDocData()"><i class="bi bi-save"></i> 저장</button>
				<?php } ?>
			</li>
			<?php 
				if(in_array($method, ['view', 'views'])) { 
					if($method == 'views' && $doc_edit == 'Y' ){	
			?>
			<li class="nav-item no-mo">
				<span class="nav-link nav-icon btn-file-authority" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="문서권한" >
					 <i class="bi bi-file-lock2"></i>
				</span>
			</li>
			<?php 
					}
				}
			?>
			<li class="nav-item no-mo">
				<span class="nav-link nav-icon btn-file" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="파일관리">
					<i class="bi bi-gear"></i>
				</span>
			</li>			
			<li class="nav-item no-mo">
				<span class="nav-link nav-icon btn-memo" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="메모">
					<i class="bi bi-chat-right-text" ></i>
				</span>
			</li>
			<?php if(in_array($method, ['view'])){ ?>
			<li class="nav-item no-mo">
				<span class="nav-link nav-icon btn-history" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="히스토리">
					<i class="bi bi-clock-history"></i>
				</span>
			</li>
			<?php }
			if(in_array($method, ['view'])){ ?>
			<li class="nav-item no-mo">
				<span class="nav-link nav-icon btn-share" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="공유">
					<i class="bi bi-send-plus"></i>					
				</span>
			</li>
			<?php }
			if(in_array($method, ['view'])){ ?>
			<li class="nav-item no-mo">
				<span class="nav-link nav-icon" style="cursor:pointer;" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" onclick="delDocData()">
					<i class="bi bi-trash3"></i>
				</span>
			</li>
			<?php }
			$this->load->view('include/header_in_profile');
			?>			
		</ul>
	</nav>
	<div class="col-auto dropdown ms-5 me-5 mt-1 no-pc">
		<svg type="button"  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-stoplights dropdown-toggle" viewBox="0 0 16 16" data-bs-toggle="dropdown" aria-expanded="false">
			<path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
		</svg> 
		<ul class="dropdown-menu">			
			<li class="dropdown-item btn-file">
				<i class="bi bi-gear"></i> 파일관리
			</li>
			<li class="dropdown-item btn-memo">
				<i class="bi bi-chat-right-text" ></i> 메모
			</li>
			<?php if(in_array($method, ['view'])){ ?>
			<li class="dropdown-item btn-history">
				<i class="bi bi-clock-history"></i> 히스토리
			</li>
			<?php }
			if(in_array($method, ['view'])){ ?>
			<li class="dropdown-item btn-share">
				<i class="bi bi-send-plus"></i> 공유
			</li>
			<?php } 
			if(in_array($method, ['view'])){ ?>
			<li class="dropdown-item"  onclick="delDocData()">
				<i class="bi bi-trash3"></i> 삭제
			</li>
			<?php } ?>
			<li>
				<hr class="dropdown-divider">
			</li>
			<li class="dropdown-item" onclick="location.href='/mypage/profile'">
				<i class="bi bi-person"></i> 정보수정
			</li>
			<li class="dropdown-item" onclick="location.href='/Mem/mlist'">
				<i class="bi bi-person-video2"></i> 주소록
			</li>
			<li class="dropdown-item">
				<i class="bi bi-box-arrow-right"></i> 로그아웃
			</li>
		</ul>
	</div> 
</header>
<?php 
	/** ======= File ======= **/ 
?>
<aside id="file" class="file">
	<div class="row file-top">
		<h5 class="col-auto me-auto">문서관리</h5>
		<div class="col-auto btn-close-sidemenu"><i class="bi bi-x-lg"></i></div>
	</div>
	<div class="d-grid gap-2 text-center file-management">		
		<?php if(in_array($method, ['write', 'test_write'])){ ?>
		<label for="fileDemo" class="btn btn-outline-secondary p-3">
			<p><i class="bi bi-file-earmark-arrow-down-fill"></i> 엑셀 불러오기</p>
			내엑셀 문서를 불러와<br>팀셀에서 사용할 수 있습니다.<b>※ 현재문서는 불러오는 문서로 대체됩니다.</b>
			<input type="file" name="file" id="fileDemo" class="file-input">
		</label>
		<button type="button" class="btn btn-outline-secondary p-3" id="reSet"><p><i class="bi bi-file-earmark-excel-fill"></i> 내용 초기화</p>팀셀에 입력한 내용을 전부다<br>초기화 시킬수 있습니다.</button>
		<?php } 
		if(in_array($method, ['view', 'views'])){ ?>
		<button type="button" class="btn btn-outline-secondary p-3" id="ex_export"><p><i class="bi bi-file-earmark-arrow-up-fill"></i> 엑셀 내보내기</p>팀셀에서 작업한 문서를<br>엑셀로 내보낼수 있습니다.</button>
		<?php } ?>
	</div>
</aside>
<?php 
	/** ======= Memo ======= **/ 
?>
<aside id="memo" class="memo">
	<div class="row memo-top">
		<h5 class="col-auto me-auto">메모</h5>
		<div class="col-auto btn-close-sidemenu"><i class="bi bi-x-lg"></i></div>
	</div>

	<div class="row g-3">
		<div class="col-12">
			<div class="form-floating">
				<textarea class="form-control" id="doc_memo" style="height: 200px;" placeholder="메모를 입력하세요"></textarea>
				<?php if(in_array($method, ['write', 'view'])){ ?>
				<label for="doc_memo">메모를 입력하세요</label>
				<?php } ?>
			</div>
		</div>
		<?php 
		if(in_array($method, ['view', 'views'])){
			if($method != 'views' || $doc_edit != 'N'){
		?>
			<button  class="btn btn-green btn-w-100" onclick="upDocMemo()">수정</button>
		<?php } 
		}
		?>
	</div>
</aside>

<aside id="file-authority" class="file-authority">
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

<?php 
if(in_array($method, ['view'])){ 
/** 공유 ======= Share ======= **/
?>
<aside id="share" class="share">
	<div class="row share-top">
		<h5 class="col-auto me-auto">공유</h5>
		<div class="col-auto btn-close-sidemenu"><i class="bi bi-x-lg"></i></div>
	</div>
	<div class="row share-url">
		<input type="hidden" id="share_url_val" value="" >
		<p class="tit">URL 링크 공유 (보기)</p>
		<p id="share_url_html"></p>
		<button type="button" class="btn btn-outline-green btn-md border-none" id="" onclick="copyShareUrl()"><i class="bi bi-link"></i> URL 공유링크 복사</button>
	</div>
	<div class="row share-url share-add">
		<p class="tit">편집 권한 공유 (보기/편집)</p>
		<p>편집 권한 부여받은자는 팀셀회원인 상태에서만 편집을 할 수 있습니다.</p>
		<button type="button" class="btn btn-outline-secondary btn-md border-none" onclick="modalMemPop()"><i class="bi bi-plus-lg"></i> 공유멤버 추가</button>
	</div>
	<div class="mt-3">
		<h3 class="card-title">현재 공유멤버 <span id="share_cnt">00</span>명</h3>
		<div class="list-group shared-list" id="shared_mem">
		</div>		
	</div>
	<input type="hidden" id="share_page" value="0">
</aside>
<!-- 공유 멤버 추가 모달 -->
<div class="modal fade share-modal" id="share-add-modal" tabindex="-1" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">공유 멤버 추가</h5>
				<div data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-auto me-auto">
						<p class="modal-in-title">편집 권한까지 제공<span>기본은 보기 권한까지 제공됩니다.</span></p>
					</div>
					<div class="col-auto">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" role="switch" id="modal_edit_type" value='E'>
							<label class="form-check-label" for="modal_edit_type"></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="modal-in-title">공유 범위 지정<span>공유를 원하는 범위를 선택해주세요.</span></p>
					</div>
					<div class="col-12">
						<input type="radio" class="btn-check" name="options" id="range-all" autocomplete="off" checked>
						<label class="col-4 btn btn-outline-secondary" for="range-all" onclick="modalChangeShareType('A')">엑셀 전체</label>
						
						<input type="radio" class="btn-check" name="options" id="range-user" autocomplete="off">
						<label class="col-4 btn btn-outline-secondary btn-md btn-share-range" for="range-user" onclick="modalChangeShareType('P')">범위 지정</label>
					</div>
					<div class="col">
						<ul class="list-group share-range mt-3" id="modal_share_sheet_list">
						</ul>
					</div>
					<div id="selected-options-range"></div>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="modal-in-title">공유 멤버 선택<span>공유를 원하는 멤버를 선택해주세요.</span></p>
					</div>
					<div class="col">
						<ul class="list-group share-member" id="modal_share_mem_list">							
						</ul>
						<div id="selected-options"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-green col" id="" onclick="addShareMem()">선택 멤버 공유하기</button>
			</div>
			<input type="hidden" id="modal_share_type" value="A">
		</div>
	</div>
	<!-- 공유멤버 추가 alert -->
	<div class="position-fixed top-50 end-50" style="z-index: 999">
		<div id="shared-toast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="toast-body">
				<i class="bi bi-exclamation-circle-fill"></i> 추가 멤버들에게 공유 되었습니다.
			</div>
		</div>
	</div>
</div>

<!-- 공유멤버 제외 확인 모달 -->
<div class="modal fade" id="share-del-modal" tabindex="-1" aria-labelledby="share-del-modalLabel" aria-hidden="true">
	<input type="hidden" id="share_id" value="">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<h5 class="modal-title" id="share-del-modalLabel"><i class="bi bi-exclamation-circle-fill"></i> 선택멤버를 공유에서 제외 하시겠습니까?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" onclick="delShareMemCancel()">취소</button>
				<button type="button" class="btn btn-green btn-sm" onclick="docUserShareMemDel()">제외</button>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<!-- Modal -->
<div class="modal fade" id="addExcelFile" tabindex="-1" role="dialog" aria-labelledby="addExcelFilePop" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">사용자 엑셀 파일 등록</h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<i class="bi bi-x-lg"></i>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_content">
					<p class="summary" id="loading-container">
						Loading progress: 
						<input style="width: 231px;" id="loadingStatus" type="range" name="points" min="0" max="100" value="0" step="0.01"/>
					</p>
					<input type="file" id="fileDemo" class="input"> &nbsp;&nbsp;&nbsp;
					<input type="button" id="reSet" value="초기화">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>