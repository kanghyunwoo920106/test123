function templatSubmit(frm) {
	lodingModal('show');
	var categoryCheck = frm.l_cate.value;
	var titleCheck = frm.tem_title.value;
	var memoCheck = frm.tem_memo.value;
	var fileCheck = frm.tem_img.value;
	// 제목
	if(!categoryCheck) {
		showNotification("alert-warning", "분류를 선택해 주세요.", "top", "center", "", "");
		return false;
	}
	// 제목
	if(!titleCheck) {
		showNotification("alert-warning", "제목을 입력해 주세요.", "top", "center", "", "");
		return false;
	}
	// 메모
	if(!memoCheck) {
		showNotification("alert-warning", "메모를 입력해 주세요.", "top", "center", "", "");
		return false;
	}
	// 이미지
	if(!fileCheck) {
		showNotification("alert-warning", "적용할 썸네일을 등록해 주세요.", "top", "center", "", "");
		return false;
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

	var formData = new FormData(frm);
	formData.append("tem_data", jsonString)

	$.ajax({
		url: "/TC_Manager/add_template_prc",
		type: "POST",
		dataType: 'json',
		enctype: 'multipart/form-data',
		processData:false,
		contentType:false,
		data: formData,
		success: function (rlt) {
			if (rlt.code == 200) {
				showNotification("alert-success", "등록 되었습니다.", "top", "center", "", "");
				setTimeout(function() {
					location.replace('/TC_Manager/document/template');
				}, 1000);				
			}
			else {
				showNotification("alert-warning", rlt.msg, "top", "center", "", "");
				setTimeout(function() {lodingModal('hide')}, 1000);
			}
		},
		error: function (request, status, error) {
			showNotification("alert-danger", "오류가 발생하였습니다.\n잠시 후에 다시 시도해주세요.", "top", "center", "", "");
			setTimeout(function() {lodingModal('hide')}, 1000);
		},
	});
}


function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#View').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

window.onload = function(){
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), {calcOnDemand: true});
    var excelIo = new GC.Spread.Excel.IO();	
	GC.Spread.Common.CultureManager.culture("ko-kr");
	var fileMenuTemplate = GC.Spread.Sheets.Designer.getTemplate(
		GC.Spread.Sheets.Designer.TemplateNames.FileMenuPanelTemplate
	);
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);

    document.getElementById('loadExcel').onclick = function () {
		var excelFile = document.getElementById("fileDemo").files[0];
		var incrementalEle = document.getElementById("incremental");
        var loadingStatus = document.getElementById("loadingStatus");

		document.getElementById('loading-container').style.display = "block";
		// here is excel IO API
        excelIo.open(excelFile, function (json) {
            var workbookObj = json;
			spread.fromJSON(workbookObj, {
				incrementalLoading: {
					loading: function (progress, args) {
						progress = progress * 100;
						loadingStatus.value = progress;
						console.log("current loading sheet", args.sheet && args.sheet.name());
					},
					loaded: function () {
					}
				}
			});           
        }, function (e) {
            // process error
            alert(e.errorMessage);
        });		
    };
	document.getElementById('reSet').onclick = function () {
		var loadingStatus = document.getElementById("loadingStatus");
		spread.clearSheets();
		spread.addSheet(0);
		spread.setActiveSheetIndex(0);
		loadingStatus.value = 0;
	};
    
	var sheet = spread.getActiveSheet();
	$("#tem_img").on('change', function(){
		readURL(this);
	});
}