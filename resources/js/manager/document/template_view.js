// 템플릿 카테고리 정보 
function templateCategoryData(){
	$.ajax({
		url: "/TC_Manager/get_doc_template_category_prc",
		type: "POST",
		data: {
			idx: $("#idx").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				$("#category_area").html('');
				$.each(rlt.data, function(index, entry) {
					var c_txt = '<div>';
					c_txt += '	<span style="font-size:15px">'+entry['l_cate_name']+' </span> ';
					if(entry['m_cate_name']){
						c_txt += '<span style="font-size:25px"> > </span><span style="font-size:15px"> '+entry['m_cate_name']+ ' </span>';
					}
					if(entry['s_cate_name']){
						c_txt += '<span style="font-size:25px"> > </span><span style="font-size:15px"> '+entry['s_cate_name']+ ' </span> ';
					}
					c_txt += '</div>';
					$("#category_area").append(c_txt);
				});
			}
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

function viewTemplatedata(){
	$.ajax({
		url: "/TC_Manager/get_template_detail_prc",
		type: "POST",
		data: {
			idx: $("#idx").val()
		},
		dataType: "json",
		success: function(rlt) {
			if(rlt.code=200){
				templateCategoryData();
				$('#exportFileName').val(rlt.data.tem_title);
				$('#tem_title').html('<span style="font-size:25px">'+rlt.data.tem_title+'</span>');
				$('#tem_memo').val(rlt.data.tem_memo);
				if(rlt.data.img_path != '' && rlt.data.img_path != null && rlt.data.img_name != '' && rlt.data.img_name != null){
					$("#viewImg").attr("src", rlt.data.img_path+'/'+rlt.data.img_name);
				}
				var serializationOption = {
					ignoreStyle: false,
					ignoreFormula: false,
					saveAsView: false,
					rowHeadersAsFrozenColumns: false,
					columnHeadersAsFrozenRows: false,
					includeAutoMergedCells: false,
					includeBindingSource: true,
				};
				var spread2 = GC.Spread.Sheets.findControl(document.getElementById('excel_area')); 
				
				spread2.suspendPaint();
				spread2.suspendCalcService();
				spread2.suspendEvent();
				spread2.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  serializationOption);
				spread2.resumePaint();
				spread2.resumeEvent();
				spread2.resumeCalcService();
			}
			else alert("ERROR");
		},
		error: function(request, status, error) {
			console.log(error);
		}
	});
}

window.onload = function(){
	

	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), {calcOnDemand: true});
	var excelIo = new GC.Spread.Excel.IO();
	GC.Spread.Common.CultureManager.culture("ko-kr");
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);
	viewTemplatedata();	


	document.getElementById('saveExcel').onclick = function () {
        var fileName = $('#exportFileName').val();       
        if (fileName.substr(-5, 5) !== '.xlsx') {
            fileName += '.xlsx';
        }

        var json = spread.toJSON();
        // here is excel IO API
        excelIo.save(json, function (blob) {
            saveAs(blob, fileName);
        }, function (e) {
            // process error
            console.log(e);
        });
    };		
}