<!-- ======= Share ======= -->
<aside id="share" class="share">
	<!-- <div class="row ">
	<div class="share-notice">
		<div>
			<span class="notice_tit"><i class="bi bi-info-circle-fill"></i> 공유자 설정 안내</span><br>
			<ul>
				<li>공유할 대상자가 팀셀 회원이면, 프로필 이미지가 표시 됩니다.</li>
				<li>편집 권한 부여받은자는 <b>팀셀회원인 상태에서만</b> 편집을 할 수 있습니다.<br>(편집 공유가 필요하면 꼭, 회원가입을 요청해주세요)</li>
			</ul>
		</div>
	</div>
</div> -->
<div class="row share-top">
	<h5 class="col-auto me-auto">공유</h5>
	<div class="col-auto btn-close4"><i class="bi bi-x-lg"></i></div>
</div>
<div class="row share-url">
	<p class="tit">URL 링크 공유 (보기)</p>
	<p>https://docs.TEEMcell.com/spreadsheets/d/1YISv5y2U8CVh58zuQvGqjLFdZJOo0h_-lzhEg9Jd2gU/edit?usp=sharing</p>
	<button type="button" class="btn btn-outline-primary btn-md" id="liveToastBtn"><i class="bi bi-link"></i> URL 공유링크 복사</button>
</div>
<div class="row share-url share-add">
	<p class="tit">편집 권한 공유 (보기/편집)</p>
	<p>편집 권한 부여받은자는 팀셀회원인 상태에서만 편집을 할 수 있습니다.</p>
	<button type="button" class="btn btn-secondary btn-md" data-bs-toggle="modal" data-bs-target="#share-add-modal"><i class="bi bi-plus-lg"></i> 공유멤버 추가</button>
</div>
<div class="row mt-3">
	<h3 class="card-title">현재 공유멤버<span>00</span>명</h3>
	<div class="list-group shared-list">
		<a href="#" class="row mb-3" aria-current="true">
		<div class="row">
			<div class="col-auto"><img src="assets/img/profile-img.png" alt="Profile" class="rounded-circle add-img"></div>
			<div class="col-auto"><span class="add-name">박서준1<i class="bi bi-pen-fill ms-2"></i></span></div>
			<div class="col"><span class="add-email">email@email.com</span></div>
		</div>
		<div class="row icon-area">
			<div class="col-auto">
				<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="보기" >
					<i class="bi bi-eye"></i>
				</span>
			</div>
			<div class="col-auto me-auto">
				<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="시트" >
					<i class="bi bi-file-spreadsheet"></i>
				</span>
			</div>
			<div class="col-auto p-0">
				<!-- <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
					<i type="submit" class="bi bi-trash3" data-bs-toggle="modal" data-bs-target="#share-del-modal"></i>
				</span> -->
				<button class="btn btn-outline-secondary btn-sm border-none" data-bs-toggle="modal" data-bs-target="#share-del-modal">삭제</button>
			</div>
			<div class="col-auto"><button class="btn btn-secondary btn-sm btn-shared-more" data-target="more0">더보기</button></div>
			<div class="shared-more" id="more0">
				<div class="row">
					<div class="col-auto">
						<p><span>1</span> [sheet_name]</p>
					</div>
					<div class="col-auto ms-auto">
						<select class="form-select">
							<option value="watch" selected="">보기</option>
							<option value="edit">편집</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<p><span>2</span> [sheet_name2]</p>
					</div>
					<div class="col-auto ms-auto">
						<select class="form-select">
							<option value="watch" selected="">보기</option>
							<option value="edit">편집</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<p><span>3</span> [sheet_name3]</p>
					</div>
					<div class="col-auto ms-auto">
						<select class="form-select">
							<option value="watch">보기</option>
							<option value="edit" selected="">편집</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<p><span>4</span> [sheet_name4]</p>
					</div>
					<div class="col-auto ms-auto">
						<select class="form-select">
							<option value="watch" selected="">보기</option>
							<option value="edit">편집</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<p><span>4</span> [sheet_name4]</p>
					</div>
					<div class="col-auto ms-auto">
						<select class="form-select">
							<option value="watch" selected="">보기</option>
							<option value="edit">편집</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		</a>        
		<a href="#" class="row mb-3" aria-current="true">
		<div class="row">
			<div class="col-auto"><img src="assets/img/no-profile-img.png" alt="Profile" class="rounded-circle add-img"></div>
				<div class="col-auto"><span class="add-name">프로필없<i class="bi bi-pen-fill ms-2"></i></span></div>
				<div class="col"><span class="add-email">email@email.com</span></div>
			</div>
			<div class="row icon-area">
				<div class="col-auto">
					<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="편집" >
						<i class="bi bi-pencil-square"></i>
					</span>
				</div>
				<div class="col-auto me-auto">
					<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="전체" >
						<i class="bi bi-files"></i>
					</span>
				</div>
				<div class="col-auto p-0">
					<button class="btn btn-outline-secondary btn-sm border-none" data-bs-toggle="modal" data-bs-target="#share-del-modal">삭제</button>
				</div>
				<div class="col-auto"><button class="btn btn-secondary btn-sm btn-shared-more" data-target="more1">더보기</button></div>
				<div class="shared-more" id="more1">
					<div class="row">
						<div class="col-auto">
							<p><span>1</span> [sheet_name]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>2</span> [sheet_name2]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>3</span> [sheet_name3]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch">보기</option>
								<option value="edit" selected="">편집</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			</a>
			<a href="#" class="row mb-3" aria-current="true">
			<div class="row">
				<div class="col-auto"><img src="assets/img/no-profile-img.png" alt="Profile" class="rounded-circle add-img"></div>
					<div class="col-auto"><span class="add-name">프없<i class="bi bi-pen-fill ms-2"></i></span></div>
					<div class="col"><span class="add-email">email@email.com</span></div>
				</div>
				<div class="row icon-area">
					<div class="col-auto">
						<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="보기" >
							<i class="bi bi-eye"></i>
						</span>
					</div>
					<div class="col-auto me-auto">
						<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="시트" >
							<i class="bi bi-file-spreadsheet"></i>
						</span>
					</div>
					<div class="col-auto p-0">
						<!-- <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
							<i type="submit" class="bi bi-trash3"></i>
						</span> -->
						<button class="btn btn-outline-secondary btn-sm border-none" data-bs-toggle="modal" data-bs-target="#share-del-modal">삭제</button>
					</div>
					<div class="col-auto"><button class="btn btn-secondary btn-sm btn-shared-more" data-target="more2">더보기</button></div>
					<div class="shared-more" id="more2">
						<div class="row">
							<div class="col-auto">
								<p><span>1</span> [sheet_name]</p>
							</div>
							<div class="col-auto ms-auto">
								<select class="form-select">
									<option value="watch" selected="">보기</option>
									<option value="edit">편집</option>
								</select>
							</div>
						</div>
					<div class="row">
						<div class="col-auto">
							<p><span>2</span> [sheet_name2]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>3</span> [sheet_name3]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch">보기</option>
								<option value="edit" selected="">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>4</span> [sheet_name4]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			</a>
			<a href="#" class="row mb-3" aria-current="true">
			<div class="row">
				<div class="col-auto"><img src="assets/img/no-join-img.png" alt="Profile" class="rounded-circle add-img"></div>
				<div class="col-auto"><span class="add-name">미가입자<i class="bi bi-pen-fill ms-2"></i></span></div>
				<div class="col"><span class="add-email">email@email.com</span></div>
			</div>
			<div class="row icon-area">
				<div class="col-auto">
					<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="편집" >
						<i class="bi bi-pencil-square"></i>
					</span>
				</div>
				<div class="col-auto me-auto">
					<span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="전체" >
						<i class="bi bi-files"></i>
					</span>
				</div>
				<div class="col-auto p-0">
					<!-- <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
						<i type="submit" class="bi bi-trash3"></i>
					</span> -->
					<button class="btn btn-outline-secondary btn-sm border-none" data-bs-toggle="modal" data-bs-target="#share-del-modal">삭제</button>
				</div>
				<div class="col-auto"><button class="btn btn-secondary btn-sm btn-shared-more" data-target="more3">더보기</button></div>
				<div class="shared-more" id="more3">
					<div class="row">
						<div class="col-auto">
							<p><span>1</span> [sheet_name]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>2</span> [sheet_name2]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>3</span> [sheet_name3]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch">보기</option>
								<option value="edit" selected="">편집</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-auto">
							<p><span>4</span> [sheet_name4]</p>
						</div>
						<div class="col-auto ms-auto">
							<select class="form-select">
								<option value="watch" selected="">보기</option>
								<option value="edit">편집</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			</a>
		</div>
		<div class="d-flex justify-content-center">
			<div class="spinner-border" role="status">
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
	</div>
</aside>
<!-- 공유 URL alert -->
<div class="position-fixed top-50 end-50" style="z-index: 999">
	<div id="liveToast" class="toast fade hide" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-body">
			<i class="bi bi-exclamation-circle-fill"></i> 공유 링크가 복사되었습니다.
		</div>
	</div>
</div>
<!-- 공유멤버 제외 확인 모달 -->
<div class="modal fade" id="share-del-modal" tabindex="-1" aria-labelledby="share-del-modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<h5 class="modal-title" id="share-del-modalLabel"><i class="bi bi-exclamation-circle-fill"></i> 선택멤버를 공유에서 제외 하시겠습니까?</h5>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">취소</button>
				<button type="button" class="btn btn-green btn-md">제외</button>
			</div>
		</div>
	</div>
</div>

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
						<p class="modal-in-title"><i class="bi bi-pencil-square"></i> 편집 권한까지 제공<span>기본은 보기 권한까지 제공됩니다.</span></p>
					</div>
					<div class="col-auto">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
							<label class="form-check-label" for="flexSwitchCheckDefault"></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="modal-in-title"><i class="bi bi-send"></i> 공유 범위 지정<span>공유를 원하는 범위를 선택해주세요.</span></p>
					</div>
					<div class="col-12">
						<input type="radio" class="btn-check" name="options" id="range-all" autocomplete="off" checked>
						<label class="btn btn-outline-secondary" for="range-all">엑셀 전체</label>
						
						<input type="radio" class="btn-check" name="options" id="range-now" autocomplete="off">
						<label class="btn btn-outline-secondary" for="range-now">현재 시트</label>
						
						<input type="radio" class="btn-check" name="options" id="range-user" autocomplete="off">
						<label class="btn btn-outline-secondary btn-md btn-share-range" for="range-user">범위 지정</label>
					</div>
					<ul class="col list-group share-range pt-3">
						<li class="list-group-item">
							<input class="form-check-input me-1" type="checkbox" value="시트1" id="sheet1">
							<label class="form-check-label" for="sheet1">시트1 <span>[시트명이 노출됩니다.]</span></label>
						</li>
						<li class="list-group-item">
							<input class="form-check-input me-1" type="checkbox" value="시트2" id="sheet2">
							<label class="form-check-label" for="sheet2">시트2 <span>[시트명이 노출됩니다.]</span></label>
						</li>
						<li class="list-group-item">
							<input class="form-check-input me-1" type="checkbox" value="시트3" id="sheet3">
							<label class="form-check-label" for="sheet3">시트3 <span>[시트명이 노출됩니다.]</span></label>
						</li>
						<li class="list-group-item">
							<input class="form-check-input me-1" type="checkbox" value="시트4" id="sheet4">
							<label class="form-check-label" for="sheet4">시트4 <span>[시트명이 노출됩니다.]</span></label>
						</li>
						<li class="list-group-item">
							<input class="form-check-input me-1" type="checkbox" value="시트5" id="sheet5">
							<label class="form-check-label" for="sheet5">시트5 <span>[시트명이 노출됩니다.]</span></label>
						</li>
					</ul>
					<div id="selected-options-range"></div>
				</div>
				<div class="row">
					<div class="col-12">
						<p class="modal-in-title"><i class="bi bi-person-add"></i> 공유 멤버 선택<span>공유를 원하는 멤버를 선택해주세요.</span></p>
					</div>
					<div class="col">
						<ul class="list-group share-member">
							<li class="list-group-item">
								<input class="form-check-input me-1" type="checkbox" value="쵸이" id="firstCheckbox">
								<label class="form-check-label" for="firstCheckbox">쵸이 <span>abcd@twosun.com</span></label>
							</li>
							<li class="list-group-item">
								<input class="form-check-input me-1" type="checkbox" value="자영" id="secondCheckbox">
								<label class="form-check-label" for="secondCheckbox">자영 <span>1234@twosun.com</span></label>
							</li>
							<li class="list-group-item">
								<input class="form-check-input me-1" type="checkbox" value="후니" id="thirdCheckbox">
								<label class="form-check-label" for="thirdCheckbox">후니 <span>abcd@twosun.com</span></label>
							</li>
							<li class="list-group-item">
								<input class="form-check-input me-1" type="checkbox" value="카누" id="fourCheckbox">
								<label class="form-check-label" for="fourCheckbox">카누 <span>abcd@twosun.com</span></label>
							</li>
							<li class="list-group-item">
								<input class="form-check-input me-1" type="checkbox" value="리나" id="fiveCheckbox">
								<label class="form-check-label" for="fiveCheckbox">리나 <span>abcd@twosun.com</span></label>
							</li>
						</ul>
						<div id="selected-options"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-green col" id="btn-shared-toast">선택 멤버 공유하기</button>
			</div>
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