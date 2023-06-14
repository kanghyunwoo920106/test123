window.onload = function() {
	var spread = new GC.Spread.Sheets.Workbook(document.getElementById("excel_area"), {calcOnDemand: true});
	var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"), '', spread);


};
