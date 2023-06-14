<!doctype html>
<html style="height:100%;font-size:14px;">

<head>
    <meta name="spreadjs culture" content="ko-kr"/>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets/styles/gc.spread.sheets.excel2013white.css">
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets/dist/gc.spread.sheets.all.min.js" type="text/javascript"></script>
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets-resources-ko/dist/gc.spread.sheets.resources.ko.min.js" type="text/javascript"></script>
	<script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets-shapes/dist/gc.spread.sheets.shapes.min.js" type="text/javascript"></script>
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets-pivot-addon/dist/gc.spread.pivot.pivottables.min.js" type="text/javascript"></script>
    <script src="<?php echo SPREADJS_PATH;?>license_tc.js" type="text/javascript"></script>



    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/spread/source/data/pivot-data.js" type="text/javascript"></script>
    <script>
window.onload = function() {
	var spread = new GC.Spread.Sheets.Workbook(_getElementById('ss'), { sheetCount: 3 });
	var spread2 = new GC.Spread.Sheets.Workbook(_getElementById('ss1'), { sheetCount: 1 });
	initSpread(spread);
};

function initSpread(spread) {
	var sheet = spread.getSheet(0);
	fillStyle(sheet);

	var pivotSourceSheet = spread.getSheet(1);
	pivotSourceSheet.name("PivotSourceData");
	var pivotSourceTableName = fillPivotSourceData(pivotSourceSheet);

	var pivotTableSheet = spread.getSheet(2);
	pivotTableSheet.name("PivotTable");
	fillPivotTable(pivotTableSheet, pivotSourceTableName);



	_getElementById('fromtoJsonBtn').addEventListener('click', function() {
		var jsonOptions = {
			ignoreFormula: false,
		ignoreStyle: false,
		frozenColumnsAsRowHeaders: false,
		frozenRowsAsColumnHeaders: false,
		doNotRecalculateAfterLoad: false,
		includeBindingSource: true
		};
		var serializationOption = {
			ignoreFormula: false,
			ignoreStyle: false,
			rowHeadersAsFrozenColumns: false,
			columnHeadersAsFrozenRows: false
		};
		//ToJson
		var spread1 = GC.Spread.Sheets.findControl(document.getElementById('ss'));
		var jsonStr = JSON.stringify(spread1.toJSON(serializationOption));
		console.log(jsonStr);

		//FromJson
		var spread2 = GC.Spread.Sheets.findControl(document.getElementById('ss1'));
		var jsttt = '{"name":"sheet1","isSelected":true,"rowCount":5,"columnCount":6,"activeRow":4,"activeCol":5,"visible":1,"frozenTrailingRowStickToEdge":true,"frozenTrailingColumnStickToEdge":true,"theme":"ush_64630ec5df53635","data":{"dataTable":{"1":{"1":{"value":"구구단"}},"3":{"1":{"value":3},"2":{"value":"X","style":"__builtInStyle2"},"3":{"value":4},"4":{"value":"=","style":"__builtInStyle2"},"5":{"value":12,"formula":"IF(AND(ISNUMBER(B4),ISNUMBER(D4)),B4*D4,"")"}}},"columnDataArray":[{"style":"__builtInStyle2"},{"style":"__builtInStyle2"},{"style":"__builtInStyle2"},{"style":"__builtInStyle2"},{"style":"__builtInStyle2"},{"style":"__builtInStyle2"}],"defaultDataNode": {"style":{"backColor":null,"foreColor":"Text 1 0","vAlign":1,"font":"normal normal 14.7px Calibri","themeFont":"Body","borderLeft":null,"borderTop":null,"borderRight":null,"borderBottom":null,"locked":true,"textIndent":0,"wordWrap":false,"textDecoration":0,"diagonalDown":null,"diagonalUp":null,"textOrientation":0,"fontForColumnWidth":"normal normal 14.7px Calibri"}}},"rowHeaderData":{"defaultDataNode":{"style":{"themeFont":"Body"}}},"colHeaderData":{"defaultDataNode":{"style":{"themeFont":"Body"}}},"rows":[null,{"size":22},null,{"size":22}],"leftCellIndex":0,"topCellIndex":0,"selections":{"0":{"row":4,"col":5,"rowCount":1,"colCount":1},"length":1},"defaults":{"colHeaderRowHeight":20,"colWidth":64,"rowHeaderColWidth":40,"rowHeight":22,"_isExcelDefaultColumnWidth":true},"rowOutlines":{"items":[]},"columnOutlines":{"items":[]},"cellStates":[],"states":[],"outlineColumnOptions":[],"autoMergeRangeInfos":[],"shapeCollectionOption":{"snapMode":0},"printInfo":{"margin":{"top":72,"bottom":72,"left":67,"right":67,"header":29,"footer":29},"pageOrder":1,"paperSize":{"width":826.7716535433073,"height":1169.2913385826773,"kind":9}},"index":0}';
		console.log(jsttt);
		spread2.fromJSON(JSON.parse(jsttt), jsonOptions);
	});
}

function fillStyle(sheet) {
	var spreadNS = GC.Spread.Sheets;
	sheet.suspendPaint();	
	sheet.setValue(3, 1, 4);
	sheet.setValue(3, 2, 'X');
	sheet.setValue(3, 3, 2);
	sheet.setValue(3, 4, '=');
	sheet.setFormula(3, 5, '=IF(AND(ISNUMBER(B4),ISNUMBER(D4)),B4*D4,"")');
	sheet.resumePaint();
}

function fillSampleData(sheet, range) {
	for (var i = 0; i < range.rowCount; i++) {
		for (var j = 0; j < range.colCount; j++) {
			sheet.setValue(range.row + i, range.col + j, Math.ceil(Math.random() * 300));
		}
	}
}

function fillPivotSourceData(sheet) {
	sheet.setRowCount(117);
	sheet.getCell(-1, 0).formatter("YYYY-mm-DD");
	sheet.getRange(-1,4,0,2).formatter("$ #,##0");
	let table = sheet.tables.add('table', 0, 0, 117, 6);

	for(let i=2;i<=117;i++)
	{
		sheet.setFormula(i-1,5,'=D'+i+'*E'+i)
	}
	table.style(GC.Spread.Sheets.Tables.TableThemes["none"]);
	sheet.setArray(0, 0, pivotSales);
	return table.name();
}

function fillPivotTable (sheet, tableName) {
	sheet.setRowCount(1000);
	let pivotTableOptions = {bandRows:true,bandColumns:true};
	let pivotTable = sheet.pivotTables.add("PivotTable", tableName, 1, 1, GC.Spread.Pivot.PivotTableLayoutType.outline, GC.Spread.Pivot.PivotTableThemes.medium1, pivotTableOptions);
	pivotTable.suspendLayout();
	pivotTable.add("salesperson", "Salesperson", GC.Spread.Pivot.PivotTableFieldType.rowField);
	pivotTable.add("car", "Cars", GC.Spread.Pivot.PivotTableFieldType.rowField);
	pivotTable.add("date", "Date", GC.Spread.Pivot.PivotTableFieldType.columnField);
	let groupInfo = { originFieldName: "date", dateGroups: [{ by: GC.Pivot.DateGroupType.quarters }] };
	pivotTable.group(groupInfo);
	pivotTable.add("total", "Totals", GC.Spread.Pivot.PivotTableFieldType.valueField, GC.Pivot.SubtotalType.sum);
	let style = new GC.Spread.Sheets.Style();
	style.formatter = "$ #,##0";
	pivotTable.setStyle({dataOnly: true}, style);
	pivotTable.resumeLayout();
	pivotTable.autoFitColumn();
}

function _getElementById(id){
    return document.getElementById(id);
} 

	</script>
   <style>
   input[type="checkbox"] {
    margin-left: 20px;
}

.colorLabel {
    background-color: #F4F8EB;
}
.sample-tutorial {
     position: relative;
     height: 100%;
     overflow: hidden;
}

.sample-spreadsheets {
    width: calc(100% - 302px);
    height: 100%;
    overflow: hidden;
    float: left;
}

.options-container {
    float: right;
    width: 302px;
    padding: 12px;
    height: 100%;
    box-sizing: border-box;
    background: #fbfbfb;
    overflow: auto;
}

.option-row {
    font-size: 14px;
    padding: 5px;
    margin-top: 10px;
}

label {
    margin-bottom: 6px;
}

input {
    padding: 4px 6px;
}

input[type=button] {
    margin-top: 6px;
    display: block;
}
body {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
   </style>
</head>
<body>

<div class="sample-tutorial">
    <div class="sample-spreadsheets" style="overflow: auto;">
        <label style="font:bold 10pt arial">ToJson:</label>
        <div id="ss" style="height: 260px"></div>
        <br/>
        <label style="font:bold 10pt arial">FromJson:</label>
        <div id="ss1" style="height: 260px"></div>
    </div>
    <div class="options-container">
        <div style="width:290px">
            <label>This serializes the first Spread instance to a JSON object, and then deserializes that object into the second Spread instance.</label>
            <div class="option-row">
                <input type="button" value="Json Serialize" id="fromtoJsonBtn"/>
            </div>
            <div>
                <div class="container">
                    <div class="row" style="margin-top: 10px">
                        <div class="col-xs-12">
                            <label>FromJSON Options:</label>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="import_noFormula"/>
                                <label style="text-align: left" for="import_noFormula">Ignore Formula</label>
                                <input type="checkbox" id="import_noStyle"/>
                                <label style="text-align: left" for="import_noStyle">Ignore Style</label>
                            </div>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="import_rowHeaders"/>
                                <label style="text-align: left" for="import_rowHeaders">Treat the frozen columns as row headers</label>
                            </div>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="import_columnHeaders"/>
                                <label style="text-align: left" for="import_columnHeaders">Treat the frozen rows as column headers</label>
                            </div>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="import_donotrecalculateafterload"/>
                                <label style="text-align: left" for="import_donotrecalculateafterload">Avoid recalculation after load</label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px">
                        <div class="col-xs-12">
                            <label>ToJSON Options:</label>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="noFormula"/>
                                <label style="text-align: left" for="noFormula">Ignore Formula</label>
                                <input type="checkbox" id="noStyle"/>
                                <label style="text-align: left" for="noStyle">Ignore Style</label>
                            </div>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="SaveCustomRowHeaders"/>
                                <label style="text-align: left" for="SaveCustomRowHeaders">Treat the row headers as frozen columns</label>
                            </div>
                            <div style="margin-top: 10px">
                                <input type="checkbox" id="SaveCustomColumnHeaders"/>
                                <label style="text-align: left" for="SaveCustomColumnHeaders">Treat the column headers as frozen rows</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
</body>
</html>