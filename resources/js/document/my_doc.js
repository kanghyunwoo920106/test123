function myDocument(val){
	$('#page_num').val(0);
	$('#doc_type').val(val);
	$("#myfile-item-list").html('');
	myDocList();

}
function myDocList(){	
	var myDocPage = $('#page_num').val();
	var docType = $('#doc_type').val();
	if(myDocPage != 'E'){
		lodingModal('show');
		var docOrd = $('#doc_ord').val();
		var docCor = $('#doc_cor').val();
		$.ajax({
			url: "/Doc/my_doc_list_prc",
			type: "POST",
			data: {
				type: docType,
				page: myDocPage,
				ord: docOrd,
				cor: docCor
			},
			dataType: "json",
			success: function(rlt) {
				if(rlt.code == 200){
					var str_txt = '';
					$.each(rlt.data, function (index, entry) {						
						str_txt += '<section class="myfile-item" id="se_'+entry['doc_id']+'">';
						str_txt += '	<div class="row">';
						str_txt += '		<div class="col col-xl-8" >';
						str_txt += '			<div class="col myfile-title-area">';
						str_txt += '				<input type="hidden" id="doc_id_'+entry['idx']+'" value="'+entry['doc_id']+'">';
						str_txt += '				<input type="hidden" id="doc_title_'+entry['idx']+'" value="'+entry['doc_title']+'">';
						str_txt += '				<input type="hidden" id="doc_dtype_'+entry['idx']+'" value="'+entry['dtype']+'">';
						str_txt += '				<input type="hidden" id="sh_code_'+entry['idx']+'" value="'+entry['share_code']+'">';						
						str_txt += '				<div class="color-label ' + entry['code_name'] + '"></div>';
						str_txt += '				<p class="row-cols-2 file-name" id="title_area_'+entry['idx']+'">';						
						str_txt += '				<span onclick="docView(\''+entry['idx']+'\');">';						
						if(entry['doc_title'] == ''){
							str_txt += '-';
						} else {
							if(entry['doc_title'].length > 30){
								var doc_title = entry['doc_title'].substr(0, 30);
								str_txt += doc_title+'...';
							} else {
								str_txt += entry['doc_title'];
							}							
						}
						str_txt += '					</span>';
						if(entry['dtype'] == 'M'){
						str_txt += '					<i class="bi bi-pen-fill ms-2 edit-name-pen" onclick="setTitleChange(\''+entry['idx']+'\')"></i>';
						}
						str_txt += '				</p>';
						if(entry['doc_memo'] != '' && entry['doc_memo'] != null){
							str_txt += '				<p class="row-cols-1 myfile-title-memo"><img src="/resources/images/icon_memo.png" class="me-1"> ' + entry['doc_memo'] + '</p>';
						}
						str_txt += '			</div>';
						str_txt += '		</div>';
						str_txt += '		<div class="col col-xl-2 myfile-writer">';
						str_txt += '			<p><span>작성자</span>'+entry['user_name']+'</p>';
						if(entry['doc_share_cnt'] > 0){
							str_txt += '			<p class="card-in-share-num"><i class="bi bi-people"></i>'+ entry['doc_share_cnt'] +'</p>';
						} else {
							str_txt += '			<p class="card-in-share-num no-share"><i class="bi bi-people">0</i></p>';
						}
						str_txt += '		</div>';
						str_txt += '		<div class="col col-xl-2 myfile-date">';
						str_txt += '			<p><span>수정일</span>' + entry['up_date'] + '</p>';
						str_txt += '			<p class="myfile-date-last">(<span>등록일</span> <span id="update_'+entry['idx']+'">' +  entry['reg_date']+ '</span>)</p>';
						str_txt += '		</div>';
						str_txt += '		<div class="dropdown">';
						str_txt += '			<svg type="button"  xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-stoplights dropdown-toggle" viewBox="0 0 16 16" data-bs-toggle="dropdown" aria-expanded="false">';
						str_txt += '				<path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm0 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm1.5 2.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>';
						str_txt += '			</svg>';
						str_txt += '			<ul class="dropdown-menu">';
						if(entry['dtype'] == 'S'){
							str_txt += '				<li><a class="dropdown-item" onclick="copyDoc(\''+entry['share_code']+'\', \''+entry['dtype']+'\')"><i class="bi bi-files"></i> 사본생성</a></li>';
						} else {
							str_txt += '				<li><a class="dropdown-item" onclick="copyDoc(\''+entry['doc_id']+'\', \''+entry['dtype']+'\')"><i class="bi bi-files"></i> 사본생성</a></li>';
						}
						if(entry['dtype'] == 'M'){
						str_txt += '				<li><a class="dropdown-item" onclick="deleteDoc(\''+entry['doc_id']+'\')"><i class="bi bi-trash3"></i> 삭제</a></li>';
						}
						str_txt += '			</ul>';
						str_txt += '		</div>';
						str_txt += '	</div>';
						str_txt += '</section>';
					});
					$("#myfile-item-list").append(str_txt);
					$('#page_num').val(rlt.page);
				}
				else {
					$('#page_num').val('E');
				};
				setTimeout(function() {
					$('#loding-area').hide();
					lodingModal('hide');
				}, 1000);				
			},
			error: function(request, status, error) {
				lodingModal('hide');
			}
		});	
	}
	else {
		$('#loding-area').hide();		
	}
}

function setTitleChange(idx){
	var str_html = '';
	
	var title_txt = $('#title_area_'+idx).text().trim();
	str_html += '<div style="position: relative; display: inline-block; width: 80%;">';
	str_html += '	<input type="text" class="form-control" style="position:relative; width:100%; display:inline-block;" maxlength="10" id="input_title_'+idx+'" value="'+title_txt+'">';
	str_html += '	<button class="btn" style="position: absolute; top: 0; right: 0;" onclick="unSetTitleChange(\''+idx+'\')"><span class="bi bi-x-lg"></span></button><i class="bi bi-pen-fill ms-2 edit-name-pen" style="display: none;"></i>';
	str_html += '</div>';
	str_html += '<button type="button" class="btn btn-outline-dark btn-sm edit-name-confirm bi bi-check-lg" style="display: inline-block;" onclick="upTitleModify(\''+idx+'\')"></button>';	
	
	$('#title_area_'+idx).html(str_html);
}

function unSetTitleChange(idx){
	var docTitle = $('#doc_title_'+idx).val();
	if(docTitle == ''){
		docTitle = '-';
	}
	var str_txt = '<span onclick="docView(\''+idx+'\')">' + docTitle + '</span>  <i class="bi bi-pen-fill ms-2 edit-name-pen" onclick="setTitleChange(\''+idx+'\')"></i>';
	$('#title_area_'+idx).html(str_txt);
}

function upTitleModify(idx){	
	var docId = $('#doc_id_'+idx).val();
	var docNewTitle = $('#input_title_'+idx).val();
	$.ajax({
		url: "/Doc/modify_doc_title_prc",
		type: "POST",
		data: {
			docId: docId,
			dcoTitle: docNewTitle
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				var str_txt = '<span onclick="docView(\''+idx+'\');">' +  docNewTitle + '</span> <i class="bi bi-pen-fill ms-2 edit-name-pen" onclick="setTitleChange(\''+idx+'\')"></i>';
				$('#title_area_'+idx).html(str_txt);
				$('#update_'+idx).html(rlt.data.up_date);
			}
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

// 보기
function viewDoc(id){
	location.href='/Doc/view/'+id;
}

function docView(idx){
	var dt = $('#doc_dtype_'+idx).val();
	var did = $('#doc_id_'+idx).val();
	var sid = $('#sh_code_'+idx).val();
	if(dt == 'S') location.href='/Doc/views/'+sid;
	else location.href='/Doc/view/'+did;
}
// 문서 삭제
function deleteDoc(id){	
	var docId = id;
	var result = confirm('문서를 영구삭제하시겠습니까? \n설정한 공유도 없어집니다.');
	if(result){
		$.ajax({
			url: "/Doc/delete_doc_prc",
			type: "POST",
			data: {
				doc_id: docId
			},
			dataType: "json",
			success: function(rlt) {
				if(rlt.code=200){
					$('#se_'+id).remove();
				}
				else alert("ERROR");
			},
			error: function(request, status, error) {
				console.log(error);
			}
		});
	}
}

// 사본 생성 
function copyDoc(code, dt){
	var result = confirm('해당 문서를 복제 하시겠습니까?');
	if(result){		
		$.ajax({
			url: "/Doc/copy_doc_prc",
			type: "POST",
			data: {
				code: code,
				dtype: dt				
			},
			dataType: "json",
			success: function(rlt) {
				if(rlt.code == 200){
					$('#page_num').val(0);
					$("#myfile-item-list").html('');
					myDocList();
				}
				else {
					alert("ERROR");
				}
			},
			error: function(request, status, error) {
				console.log(error);
			}
		});
	}
}

// 문서 정렬
function orderDoc(type){
	$('#page_num').val(0);
	$('#doc_ord').val(type);
	$("#myfile-item-list").html('');
	myDocList();
}

//스크롤 바닥 감지
window.onscroll = function(e) {
    //추가되는 임시 콘텐츠
    //window height + window scrollY 값이 document height보다 클 경우,
    if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    	$('#loding-area').show();
		myDocList();
    }
};

window.onload = function(){
	myDocList();

	//색상정렬
    $(".dropdown-menu.sort").on("click", ".dropdown-item", function() {
		var selectedColorId = $(this).find("div.color-label").attr("data-color");
		$("#act-color").attr("class", "color-label "+selectedColorId);
		$("#act-color").attr("data-color", selectedColorId);
		$('#doc_cor').val(selectedColorId);

		$('#page_num').val(0);
		$("#myfile-item-list").html('');
		myDocList();
	});
	document.getElementById("go-back").addEventListener("click", () => {
		history.back();
	});
}
