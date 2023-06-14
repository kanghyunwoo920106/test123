window.onload = function () {
    GC.Spread.Common.CultureManager.culture("ko-kr");
    var spread = new GC.Spread.Sheets.Workbook(document.getElementById('ss'), { sheetCount: 2 });
    
    // 원본 데이터 시트 생성
    initSpread(spread);
    
    var pivotLayoutSheet = spread.getSheet(0);

    // 피벗 테이블 및 패널 생성
    initPivotTable(pivotLayoutSheet);

    // 피벗 테이블 열 너비 자동 맞춤
    doAutoFitColumn(pivotLayoutSheet);
};

// 원본 데이터 시트 생성
function initSpread(spread) {
    spread.suspendPaint();
    // 시트 2
    // 두번째 시트 가져오기
    var sheet1 = spread.getSheet(1);
    // 두번째 시트 이름 선언
    sheet1.name("DataSource");
    // 두번째 시트 행의 수를 700줄로 설정
    sheet1.setRowCount(700);
    // 6번째 열 너비 설정
    sheet1.setColumnWidth(5, 150);

    // 첨부된 샘플 데이터인 pivotSales.js 로 부터 데이터를 시트 배열로 가져 오기 
    sheet1.setArray(0, 0, pivotSales);
    
    //시트 배열을 엑셀 테이블로 지정하고, tableSales 라는 변수를 설정 (피벗 테이블 생성 시 사용 예정)
    sheet1.tables.add('tableSales', 0, 0, 642, 6);
    // 시트 1
    // 첫번째 시트 가져 오기 
    var sheet0 = spread.getSheet(0);
    // 첫번째 시트 이름을 PivotLayout로 선언
    sheet0.name("PivotLayout");
    // 렌더링 활성화를 통해 화면에 한번에 그려주어 성능 항상
    spread.resumePaint();
}

function initPivotTable(sheet) {
    // 시트에 tableSales라는 원본 테이블을 가지는 myPivotTable 이라는 이름의 피섭 테이블을 생성 합니다. 
    var myPivotTable = sheet.pivotTables.add("myPivotTable", "tableSales", 1, 1, GC.Spread.Pivot.PivotTableLayoutType.outline, GC.Spread.Pivot.PivotTableThemes.dark2);

    // 피벗 테이블이 화면에 그려지는 것을 지연하여 성능을 개선합니다.
    myPivotTable.suspendLayout();

    // 피벗 테이블에 행/열 해더가 보여지도록 설정합니다.
    myPivotTable.options.showRowHeader = true;
    myPivotTable.options.showColumnHeader = true;

    //피벗 테이블에 행 필드에 Region 과 Country를 적용 합니다.
    myPivotTable.add("region", "Region", GC.Spread.Pivot.PivotTableFieldType.rowField);
    myPivotTable.add("country", "Country", GC.Spread.Pivot.PivotTableFieldType.rowField);

    // Date라는 필드를 분기(Quater)별로 그룹핑 해줍니다.     
    var groupInfo = { originFieldName: "date", dateGroups: [{ by: GC.Pivot.DateGroupType.quarters }] };
    myPivotTable.group(groupInfo);

    //비벗 테이블의 열 필드에 분기로 그룹핑한 date 필드를 Qt라는 이름으루 추가해줍니다. 
    myPivotTable.add("date", "Qt", GC.Spread.Pivot.PivotTableFieldType.columnField);
    
    myPivotTable.add("amount", "Sum of amount", GC.Spread.Pivot.PivotTableFieldType.valueField, GC.Pivot.SubtotalType.sum);

    // 마지막으로 html body에서 panel라고 선언한 div상에 
    // 위에서 만든 피벗 테이블과 함께 myPivotPanel 이라는 이름으로 피벗 패널이 함께 보여지도록 선언해 줍니다. 
    var panel = new GC.Spread.Pivot.PivotPanel("myPivotPanel", myPivotTable, document.getElementById("panel"));

    // 피벗 테이블이 화면에 그려지는 것을 활성화 성능을 개선 입니다.
    myPivotTable.resumeLayout();
    return myPivotTable;

}

function doAutoFitColumn (sheet) {
    sheet.suspendPaint();
    var colCount = sheet.getColumnCount();
    for (var i = 0; i < colCount; i++) {
        sheet.autoFitColumn(i);
    }
    sheet.setColumnWidth(0, 20);
    sheet.setRowHeight(0, 20);
    sheet.resumePaint();
}
