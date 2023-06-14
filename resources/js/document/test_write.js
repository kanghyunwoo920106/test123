
function addDocData() {
	lodingModal('show');
	var docType = $('#doc_type').val();
	var temId = $('#tem_id').val();
	var titleValue = $('#doc_title').val();
	var memoValue = $('#doc_memo').val();
	var colorValue = $('#act-color').attr("data-color");

	if(titleValue == ''){
		titleValue = "내 문서 타이틀 명";
	}

	var jsonOptions = {
			ignoreFormula: false,
			ignoreStyle: false,
			frozenColumnsAsRowHeaders: false,
			frozenRowsAsColumnHeaders: false,
			doNotRecalculateAfterLoad: false,
			incrementalLoading: true,
			includeBindingSource: true 
	};

	var spread1 = GC.Spread.Sheets.findControl(document.getElementById('excel_area'));
	var jsonString = JSON.stringify(spread1.toJSON(jsonOptions));
	$.ajax({
		url: '/Doc/test_add_doc_write_prc',
		type: 'POST',
		data: {			
			doc_data: jsonString     
		},
		dataType: 'json',		
		success: function (result) {
			if (result.code == 200) {
				showNotification("alert-success", "저장 되었습니다.", "top", "center", "", "");
				setTimeout(function() {
					location.replace('/Doc/test_view/'+result.data.id);
				}, 1000);
			}
			else {
				showNotification("alert-warning", result.msg, "top", "center", "", "");
				lodingModal('hide');
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다. 잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			lodingModal('hide');
		},
	});
}
window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), {calcOnDemand: true});
    var excelIo = new GC.Spread.Excel.IO();	
	GC.Spread.Common.CultureManager.culture("ko-kr");
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);

	document.getElementById('fileDemo').onchange = function () {
		var excelFile = document.getElementById("fileDemo").files[0];	

		spread.suspendPaint();
		spread.suspendCalcService();
		spread.suspendEvent();

		
		// here is excel IO API
        excelIo.open(excelFile, function (json) {
            var workbookObj = json;
			spread.fromJSON(workbookObj, {
				doNotRecalculateAfterLoad: true,
				incrementalLoading: true
			});           
        }, function (e) {
            // process error
            alert(e.errorMessage);
        });	

		spread.resumeEvent();
		spread.resumeCalcService();
		spread.resumePaint();
    };
	
	const body = document.querySelector('body');
	const togle_class = ['toggle-file', 'toggle-memo'];	

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

	//파일관리 버튼
	if (select('.btn-file')) {
		on('click', '.btn-file', function(e) {
			if($('body').hasClass("toggle-file")){
				body.classList.remove('toggle-file');
			}
			else {
				togle_class.forEach(function(togle_class) {
					body.classList.remove(togle_class);
				});
				body.classList.add('toggle-file');
			}			
		})
	}
}