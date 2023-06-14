window.onload = function() {
	var spread = new GC.Spread.Sheets.Workbook(_getElementById('ss'));
	var spreadNS = GC.Spread.Sheets;
	spread.setSheetCount(3);
	initSpread(spread);

	spread.bind(spreadNS.Events.ActiveSheetChanged, function(e, args) {
		_getElementById('activeSheetIndex').value = spread.getActiveSheetIndex();
		_getElementById('changeSheetIndexName').value = spread.getActiveSheet().name();
	});

	_getElementById('btnAddSheet').addEventListener('click',function() {
		var activeIndex = spread.getActiveSheetIndex(); 
		if (activeIndex >= 0) {
		spread.addSheet(activeIndex+1);
		spread.setActiveSheetIndex(activeIndex+1);
	}
		else{
			spread.addSheet(0);
			spread.setActiveSheetIndex(0);
		}
	});

	_getElementById('btnRemoveSheet').addEventListener('click',function() {
		var activeIndex = spread.getActiveSheetIndex();
		if (activeIndex >= 0) {
			spread.removeSheet(activeIndex);
			spread.setActiveSheetIndex(activeIndex);
		}
	});

	_getElementById('btnClearSheets').addEventListener('click',function() {
		spread.clearSheets();
	});

	_getElementById('btnSetActiveSheetIndex').addEventListener('click',function() {
		var index = _getElementById('activeSheetIndex').value;
		if (!isNaN(index)) {
			index = parseInt(index);
			if (0 <= index && index < spread.getSheetCount()) {
				spread.setActiveSheetIndex(index);
			}
		}
	});
	_getElementById('btnChangeSheetIndex').addEventListener('click',function() {
		var sheetName = _getElementById('changeSheetIndexName').value;
		var targetIndex = _getElementById('changeSheetIndexTargetIndex').value;
		if (!isNaN(targetIndex)) {
			targetIndex = parseInt(targetIndex);
			if (0 <= targetIndex && targetIndex <= spread.getSheetCount()) {
				spread.changeSheetIndex(sheetName, targetIndex);
			}
		}
	});
};
function initSpread(spread) {
	
}

function _getElementById(id){
    return document.getElementById(id);
} 
