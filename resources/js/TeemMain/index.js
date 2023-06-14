function getTemplateList(){
	$.ajax({
		url: "/Main/get_main_template_list_prc",
		type: "POST",
		data: {},
		dataType: "json",
		success: function(result) {
			if (result.code == 200) {
        		var mt_txt = "";
				$.each(result.data, function(index, entry) {
					mt_txt = '<div class="col">';
					mt_txt += '	<!-- Card with an image on top -->';
					mt_txt += '	<div class="card myfile-item">';
					mt_txt += '   <img src="'+entry['img_path']+'/s_'+entry['img_name']+'" class="card-img-top">';
					mt_txt += '   <div class="card-body">';
					mt_txt += '     <h5 class="card-in-title"> <span class="card-in-category">[인사]</span>'+entry['tem_title']+'</h5>';
					mt_txt += '     <p class="card-in-date">'+entry['reg_date']+'</p>';
					mt_txt += '     <p class="card-in-text">'+entry['tem_memo']+'</p>';
					mt_txt += '   </div>';
					mt_txt += ' </div><!-- End Card with an image on top -->';
					mt_txt += '</div>';					
					$("#main_template").append(mt_txt);
				});
				mt_txt = '<div class="col">';	
				mt_txt += '	<!-- Card with an image on top -->';	
				mt_txt += '	<a class="card myfile-item more" href="/template">';	
				mt_txt += ' 	<div class="card-body">';	
				mt_txt += '			<i class="bi bi-arrow-right"></i>';	
				mt_txt += '			<h5 class="card-in-title">더보기</h5>';	
				mt_txt += '		</div>';	
				mt_txt += '	</a><!-- End Card with an image on top -->';	
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
		url: "/Main/get_main_user_doc_list_prc",
		type: "POST",
		data: {},
		dataType: "json",
		success: function(result) {
			if (result.code == 200) {
        		var md_txt = "";			
				$.each(result.data, function(index, entry) {
					md_txt = '<div class="col">';              
					md_txt += '	<div class="card myfile-item red" onClick="docView(\''+entry['doc_id']+'\')">';
					if(entry['doc_memo']){
						md_txt += '		<p class="card-in-memo"><img src="/resources/images/icon_memo.png" class="me-1">'+entry['doc_memo']+'</p>';
					}
					else {
						md_txt += '		<img src="/resources/images/no_memo.png" class="card-img-top">';
					}
					md_txt += '		<div class="card-body">';
					md_txt += '			<h5 class="card-in-title"></span>'+entry['doc_title']+'</h5>';
					md_txt += '			<p class="card-in-date">'+entry['reg_date']+'</p>';
					md_txt += '			<div class="row">';
					
					md_txt += '				<div class="col-auto me-auto card-in-share-num"><i class="bi bi-people"></i>'
					if(( entry['doc_share_cnt'] * 1) > 0){
					md_txt += '	+ '+entry['doc_share_cnt'];					
					}
					md_txt += '				</div>';
					md_txt += '				<div class="col-auto"><p class="card-in-writer"><span>작성자</span>'+entry['user_name']+'</p></div>';
					md_txt += '			</div>';
					md_txt += '		</div>';
					md_txt += '	</div>';
					md_txt += '	<!-- End Card with an image on top -->';
					md_txt += '</div>';					
					$("#main_document").append(md_txt);
				});
				md_txt = '<div class="col">';
				md_txt += '	<!-- Card with an image on top -->';
				md_txt += '	<a class="card myfile-item more" href="my_file.html">';
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

function docView(code){
	location.href='/document/doc_view?doc_id='+code;
}

$(document).ready(function () {
	getTemplateList();
	getUserDocList();
});