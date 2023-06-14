function templateList(){
	var temPage = $('#pageNum').val();

	if(temPage != 'E'){
		var search_str = $('#searchStr').val();
		var docOrd = $('#docOrd').val();
		var lcate = $('#lcate').val();
		var mcate = $('#mcate').val();
		var scate = $('#scate').val();
	
		$.ajax({
			url: "/Doc/template_list_prc",
			type: "POST",
			data: {
				search: search_str, 
				page: temPage,
				ord: docOrd,
				lcate: lcate,
				mcate: mcate,
				scate: scate
			},
			dataType: "json",
			success: function(rlt) {
				if(temPage == 0){
					$("#template_list").html('');
				}
				if(rlt.code == 200){
					var today, resultDate;
					today = new Date();
					var str_txt = '';
					$.each(rlt.data, function (index, entry) {						
						str_txt += '<div class="col-xl-6">';
						str_txt += '	<div class="card template">';
						str_txt += '		<div class="row g-0">';
						str_txt += '			<div class="col-md-4">';
						str_txt += '				<img src="'+entry['img_path']+'/'+entry['img_name']+'" class="img-fluid rounded-start template-img" alt="...">';
						str_txt += '				<div class="txt-area row">';
						str_txt += '					<h5 class="card-in-title"> <span class="card-in-category">['+entry['cate_name']+']</span>'+entry['tem_title']+'</h5>';
						str_txt += '					<p class="card-in-date">';
						resultDate = new Date(entry['reg_date']);
						if ((today - resultDate)/(60*60*1000) <= 24) {
							str_txt += '						<img src="/resources/images/icon_new.png" class="me-2">';
						}						
						str_txt +=	entry['reg_date']+'</p>';
						str_txt += '					<button type="button" class="col btn btn-secondary btn-sm" onclick="temAdd(\''+entry['tem_id']+'\')">템플릿 사용하기</button>';
						str_txt += '				</div>';
						str_txt += '			</div>';
						str_txt += '			<div class="col-md-8">';
						str_txt += '				<div class="card-body">';
						str_txt += '					<h5 class="card-in-title">템플릿 설명</h5>';
						str_txt += '					<p class="card-in-text">'+entry['tem_memo']+'</p>';						
						str_txt += '				</div>';
						str_txt += '			</div>';
						str_txt += '		</div>';
						str_txt += '	</div>';
						str_txt += '</div>';						
					});
					$('#pageNum').val(rlt.page);
					$("#template_list").append(str_txt);
				}
				else {
					$('#pageNum').val('E');
				};
				$('#loding-area').hide();
			},
			error: function(request, status, error) {
				console.log(error);
			}
		});	
	}
	else {
		$('#loding-area').hide();
	}
}

function selCate(lc, mc, sc){
	$('#pageNum').val(0);
	$('#searchStr').val('');
	$("#search_title").val('');
	$('#lcate').val(lc);
	$('#mcate').val(mc);
	$('#scate').val(sc);
	$("#template_list").html('');
	templateList();
}

function searchTitle(){
	var searchTitle = $("#search_title").val().trim();
	var reg_search = /^[가-힣a-zA-Z0-9 ]{2,}$/;	
	
	if(!reg_search.test(searchTitle)) {
		showNotification("alert-warning", "검색어를 2자이상 입력해 주세요.", "top", "center", "", "");
		return false;
	}

	$('#pageNum').val(0);
	$('#searchStr').val(searchTitle);
	$("#template_list").html('');
	templateList();
}

function temAdd(code){
	location.href='/Doc/write/T/'+code;
}
// 문서 정렬
function orderDoc(type){
	$('#pageNum').val(0);
	$('#docOrd').val(type);
	$("#template_list").html('');
	templateList();
}

window.onload = function(){
	document.getElementById("go-back").addEventListener("click", () => {
		history.back();
	});	

	templateList();
}


//스크롤 바닥 감지
window.onscroll = function(e) {
    //추가되는 임시 콘텐츠
    //window height + window scrollY 값이 document height보다 클 경우,
    if((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    	$('#loding-area').show();
		templateList();
    }
};