function getTemplateList(){
	$.ajax({
		url: "/TCmain/get_main_template_list_prc",
		type: "POST",
		data: {},
		dataType: "json",
		success: function(result) {
			if (result.code == 200) {
        		var mt_txt = "";
				$.each(result.data, function(index, entry) {
					mt_txt += '<div class="col-auto" onclick="temAdd(\''+entry['tem_id']+'\')">';					
					mt_txt += '	<div class="card myfile-item">';
					mt_txt += '   <img src="'+entry['img_path']+'/'+entry['img_name']+'" class="card-img-top">';
					mt_txt += '   <div class="card-body">';
					mt_txt += '     <h5 class="card-in-title"> <span class="card-in-category">['+entry['cate_name']+']</span>'+entry['tem_title']+'</h5>';
					mt_txt += '     <p class="card-in-date">'+entry['reg_date']+'</p>';
					mt_txt += '     <p class="card-in-text">'+entry['tem_memo']+'</p>';
					mt_txt += '   </div>';
					mt_txt += ' </div>';
					mt_txt += '</div>';					
				});
				mt_txt += '<div class="col-auto">';
				mt_txt += '	<a class="card myfile-item more" href="/Doc/template">';	
				mt_txt += ' 	<div class="card-body">';	
				mt_txt += '			<i class="bi bi-arrow-right"></i>';	
				mt_txt += '			<h5 class="card-in-title">더보기</h5>';	
				mt_txt += '		</div>';	
				mt_txt += '	</a>';	
				mt_txt += '</div>';
				$("#main_template").append(mt_txt);
			} else {
				$("#main_template").append('');				
			}
			
		},
		error: function(request, status, error) {
			alert("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
		}
	});
}


function getUserDocList(){
	$.ajax({
		url: "/TCmain/get_main_user_doc_list_prc",
		type: "POST",
		data: {},
		dataType: "json",
		success: function(result) {
			if (result.code == 200) {
        		var md_txt = "";			
				$.each(result.data, function(index, entry) {
					if(entry['dtype'] == 'S'){
						md_txt = '<div class="col-auto" onClick="docView(\''+entry['share_code']+'\', \''+entry['dtype']+'\')">';
					} else {
						md_txt = '<div class="col-auto" onClick="docView(\''+entry['doc_id']+'\', \''+entry['dtype']+'\')">';
					}
					if(entry['doc_memo']){
						md_txt += '	<div class="card myfile-item '+entry['doc_color']+'">';
						md_txt += '		<p class="card-in-memo"><img src="/resources/images/icon_memo.png" class="me-1">'+entry['doc_memo']+'</p>';
					} else {
						md_txt += '	<div class="card myfile-item no_memo">';
						md_txt += '		<img src="/resources/images/no_memo.png" class="card-img-top">';
					}
					md_txt += '			<div class="card-body">';
					md_txt += '				<h5 class="card-in-title"></span>'+entry['doc_title']+'</h5>';
					md_txt += '				<p class="card-in-date">'+entry['reg_date']+'<span class="myfile-date-last"> (<span>수정일</span> '+entry['up_date']+')</span></p></p>';
					md_txt += '				<div class="row">';
					md_txt += '					<div class="col-auto me-auto"><p class="card-in-writer"><span>작성자</span>'+entry['user_name']+'</p></div>';					
					
					if(( entry['doc_share_cnt'] * 1) > 0){
						md_txt += '					<div class="col-auto card-in-share-num"><i class="bi bi-people"></i>'
						md_txt += '	+ '+entry['doc_share_cnt'];
						md_txt += '					</div>';
					}
					
					md_txt += '			</div>';
					md_txt += '		</div>';
					md_txt += '	</div>';
					md_txt += '</div>';					
					$("#main_document").append(md_txt);
				});
				md_txt = '<div class="col">';
				md_txt += '	<a class="card myfile-item more" href="/Doc/my_doc">';
				md_txt += '	<div class="card-body">';
				md_txt += '		<i class="bi bi-arrow-right"></i>';
				md_txt += '		<h5 class="card-in-title">더보기</h5>';
				md_txt += '	</div>';
				md_txt += '	</a>';
				md_txt += '</div>';
				$("#main_document").append(md_txt);				
			} else {
				$("#main_document").append('');
				return;
			}
		},
		error: function(request, status, error) {
			alert("오류가 발생하였습니다.잠시 후에 다시 시도해주세요");
		}
	});
}

function temAdd(code){
	location.href='/Doc/write/T/'+code;
}

function docView(code, type){
	if(type == 'S'){
		location.href='/Doc/views/'+code;
	} else location.href='/Doc/view/'+code;
}

$(document).ready(function () {
	getTemplateList();
	getUserDocList();
});