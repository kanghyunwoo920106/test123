<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>TEEMcell</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
    <link href="/resources/images/favicon.png" rel="icon">
    <link href="/resources/images/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
   <link href="/resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/resources/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/resources/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
    <link href="/resources/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center work-header">
    <div class="row d-flex align-items-center justify-content-between">
      <a href="index.html" class="btn btn-green" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="대시보드">
        <i class="bi bi-grid"></i>
      </a>
    </div>

    <button type="button" class="btn btn-outline-secondary btn-md ms-4 btn-save"><i class="bi bi-save"></i> 저장</button>
    <div class="col myfile-title-area">
      <div class="color-label red">
      </div>
      <p>
        내문서 타이틀 명
      </p>
    </div>

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item">
          <span class="nav-link nav-icon btn-memo" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="메모">
            <i class="bi bi-chat-right-text" ></i>
          </span>
        </li>
        <li class="nav-item">
          <span class="nav-link nav-icon btn-history" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="히스토리">
            <i class="bi bi-clock-history"></i>
          </span>
        </li>
        <li class="nav-item">
          <a href="address.html" class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="주소록" >
            <i class="bi bi-person-video2"></i>
          </a>
        </li>
        <li class="nav-item">
          <span class="nav-link nav-icon btn-share" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="공유" >
            <i class="bi bi-send-plus"></i>
          </span>
        </li>
        <li class="nav-item">
          <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
            <i class="bi bi-trash3"></i>
          </span>
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">박서준</span>
          </a><!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>박서준</h6>
              <span>@투썬월드</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>정보수정</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>로그아웃</span>
              </a>
            </li>
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
      </ul>
    </nav><!-- End Icons Navigation -->

  </header>
  <!-- End Header -->
<!-- ======= Header2 ======= -->
<header id="header2" class="header sub-header row work-sheet">
  <div class="col-auto me-auto">
    <a><i class="bi bi-arrow-left me-2 btn-close3"></i></a>
    <h2 class="sub-header-title">문서 히스토리</h2>
  </div>
  <div class="col-auto">
    <button type="button" class="btn btn-secondary btn-md">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-reboot" viewBox="0 0 16 16">
      <path d="M1.161 8a6.84 6.84 0 1 0 6.842-6.84.58.58 0 1 1 0-1.16 8 8 0 1 1-6.556 3.412l-.663-.577a.58.58 0 0 1 .227-.997l2.52-.69a.58.58 0 0 1 .728.633l-.332 2.592a.58.58 0 0 1-.956.364l-.643-.56A6.812 6.812 0 0 0 1.16 8z"/>
      </svg>
    선택 문서로 복원
    </button>
  </div>
</header>
<!-- End Header2 -->
  <!-- ======= Memo ======= -->
  <aside id="memo" class="memo">
    <div class="row memo-top">
      <h5 class="col-auto me-auto">메모</h5>
      <div class="col-auto btn-close2"><i class="bi bi-x-lg"></i></div>
    </div>
    <form class="row g-3">
      <div class="col-12">
        <div class="form-floating">
          <textarea class="form-control" id="floatingTextarea" style="height: 200px;"></textarea>
          <label for="floatingTextarea">메모를 입력하세요</label>
        </div>
      </div>
        <button type="submit" class="btn btn-green">저장</button>
    </form>
  </aside>
  <!-- End Memo-->
  <!-- ======= History ======= -->
  <aside id="history" class="history">
    <div class="row">
      <div class="history-list">
        <h5>오늘 히스토리 문서</h5>
        <input type="radio" class="btn-check" name="options-outlined" id="history_list01" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list01">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

        <input type="radio" class="btn-check" name="options-outlined" id="history_list02" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list02">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

        <input type="radio" class="btn-check" name="options-outlined" id="history_list03" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list03">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

      </div>
      <div class="history-list mt-3">
        <h5>이전 문서</h5>
        <input type="radio" class="btn-check" name="options-outlined" id="history_list04" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list04">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

        <input type="radio" class="btn-check" name="options-outlined" id="history_list05" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list05">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

        <input type="radio" class="btn-check" name="options-outlined" id="history_list06" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list06">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

        <input type="radio" class="btn-check" name="options-outlined" id="history_list07" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list07">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>

        <input type="radio" class="btn-check" name="options-outlined" id="history_list08" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list08">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>
        
        <input type="radio" class="btn-check" name="options-outlined" id="history_list08" autocomplete="off">
        <label class="btn btn-outline-success myfile-writer" for="history_list08">00월 00일(수) 오전 00:00<p><span>편집자</span>홍길동</p></label>
      </div>
      <div class="d-flex justify-content-center">
        <div class="spinner-border" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </aside>
  <!-- End History-->
  <!-- ======= Share ======= -->
  <aside id="share" class="share">
    <!-- <div class="row ">
      <div class="share-notice">
        <div><span class="notice_tit"><i class="bi bi-info-circle-fill"></i> 공유자 설정 안내</span><br>
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
            <div class="col-auto">
              <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
                <i type="submit" class="bi bi-trash3" data-bs-toggle="modal" data-bs-target="#share-del-modal"></i>
              </span>
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
            <div class="col-auto">
              <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
                <i type="submit" class="bi bi-trash3"></i>
              </span>
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
            <div class="col-auto">
              <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
                <i type="submit" class="bi bi-trash3"></i>
              </span>
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
            <div class="col-auto">
              <span class="nav-link nav-icon" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="삭제" >
                <i type="submit" class="bi bi-trash3"></i>
              </span>
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
  <!-- End Share-->
  <main id="main" class="main main-100" style="padding:0;">
    <img src="assets/img/spreadjs.png" alt="" style="width:1902px; height:869px;">
  </main>

  <!-- ======= Footer ======= -->
  <!-- <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">-->
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
     </div>
   </footer> -->
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->

    <!-- Vendor JS Files -->
    <script src="/resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="/resources/gentelella-master/jquery/dist/jquery.min.js"></script>
 




    <script>
	(function() {
  "use strict";
  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }


//메모버튼
  if (select('.btn-memo')) {
    on('click', '.btn-memo', function(e) {
      select('body').classList.toggle('toggle-memo')
    })
  }
  if (select('.btn-close2')) {
    on('click', '.btn-close2', function(e) {
      select('body').classList.toggle('toggle-memo')
    })
  }

  //히스토리 버튼
  if (select('.btn-history')) {
    on('click', '.btn-history', function(e) {
      select('body').classList.toggle('toggle-history')
    })
  }
if (select('.btn-close3')) {
    on('click', '.btn-close3', function(e) {
      select('body').classList.toggle('toggle-history')
    })
  }


  //공유 버튼
    if (select('.btn-share')) {
      on('click', '.btn-share', function(e) {
        select('body').classList.toggle('toggle-share')
      })
    }
  if (select('.btn-close4')) {
      on('click', '.btn-close4', function(e) {
        select('body').classList.toggle('toggle-share')
      })
    }


  // 공유 주소록에서 더보기 버튼
  $(document).ready(function() {
    const buttons = document.querySelectorAll('.btn-shared-more');
    const contents = document.querySelectorAll('.shared-more');
    
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const targetId = button.dataset.target;
        const targetContent = document.getElementById(targetId);
    
        contents.forEach(content => {
          if (content.style.display === 'block' && content !== targetContent) {
            content.style.display = 'none';
          }
        });
    
        if (targetContent.style.display === 'none') {
          targetContent.style.display = 'block';
        } else {
          targetContent.style.display = 'none';
        }
      });
    });
  
  });

  //공유 url 복사 toast
  $('#liveToastBtn').click(function() {
    var toast = new bootstrap.Toast($('#liveToast')[0], { delay: 2000 });
    toast.show();
  });
    

  // 공유 추가하기에서 범위 선택
  const share_range_button = document.querySelector('.btn-share-range');
  const share_range_contents = document.querySelector('.share-range');
  const share_range_list = document.querySelector('#selected-options-range');

  share_range_button.addEventListener('click', () => {
    if (share_range_contents.style.display === 'none') {
      share_range_contents.style.display = 'block';
      share_range_list.style.display = 'block';
    } else {
      share_range_contents.style.display = 'none';
      share_range_list.style.display = 'none';
    }
  });
  

  $('.share-range li').on('click', function(event) {
    event.preventDefault();
    var checkbox = $(this).find('input[type="checkbox"]');
    checkbox.prop('checked', !checkbox.prop('checked'));
    var selectedValue = checkbox.val();
    if (checkbox.is(':checked')) {
      $('<span class="selected-option-range pe-2">' + selectedValue + '<i class="bi bi-x"></i></span>').appendTo('#selected-options-range');
    } else {
      $('.selected-option-range:contains(' + selectedValue + ')').remove();
    }
  });
  
  $(document).on('click', '.selected-option i', function() {
    var selectedValue = $(this).parent().text().replace(/\s/g, '').replace('×', '');
    $('.share-range input[type="checkbox"][value="' + selectedValue + '"]').prop('checked', false);
    $(this).parent().remove();
  });
  
  

  // 공유 추가하기에서 멤버 선택하고 삭제
  $('.btn-check').on('change', function() {
    if ($('#range-user').is(':checked')) {
      $('.share-range').show();
    } else {
      $('.share-range').hide();
    }
  });
  //선택된 목록 아래에 표시
  $(document).on('click', '.selected-option i', function() {
    var selectedValue = $(this).parent().text().replace(/\s/g, '').replace('×', '');
    $('.share-member input[type="checkbox"][value="' + selectedValue + '"]').prop('checked', false);
    $(this).parent().remove();
  });
  
  //공유 url 복사 toast
  $('#btn-shared-toast').click(function() {
    var toast = new bootstrap.Toast($('#shared-toast')[0], { delay: 2000 });
    toast.show();
  });
  
})();
	</script>

  <!-- Template Main JS File -->
<script>
(function() {
  "use strict";
  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle
   */
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function(e) {
      select('body').classList.toggle('toggle-sidebar')
    })
  }


  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate tooltips
   */
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

 
  /**
   * Initiate Datatables
   */
  const datatables = select('.datatable', true)
  datatables.forEach(datatable => {
    new simpleDatatables.DataTable(datatable);
  })


  //공유 url 복사 toast
  document.querySelector('#btn-share-copy').addEventListener('click', function() {
    var toast = new bootstrap.Toast(document.querySelector('#share-copy'), { delay: 2000 });
    toast.show();
  });
  
})();

</script>
 


</body>

</html>