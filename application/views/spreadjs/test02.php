<script type="text/javascript">   
    window.onload = function () {
        var spread = new GC.Spread.Sheets.Workbook(_getElementById("ss"),{sheetCount:1});
        initSpread(spread);
    }

    function initSpread(spread){
        var spreadNS = GC.Spread.Sheets;
        var sheet =  spread.getActiveSheet();
        var array = [];

        sheet.options.selectionBorderColor = 'red';
        sheet.options.selectionBackColor = 'transparent';

        spread.bind(spreadNS.Events.CellClick, function (e, args) {
            var sheetArea = args.sheetArea === 0 ? 'sheetCorner' : args.sheetArea === 1 ? 'columnHeader' : args.sheetArea === 2 ? 'rowHeader' : 'viewPort';
            console.log('sheetArea: ' +sheetArea + 'row: ' + args.row + ' col: ' + args.col);
            /*
            _getElementById("showSpreadEvents").value=
                'SpreadEvent: ' + GC.Spread.Sheets.Events.CellClick + ' event called' + '\n' +
                'sheetArea: ' + sheetArea + '\n' +
                'row: ' + args.row + '\n' +
                'col: ' + args.col;
            */
        });

        sheet.bind(spreadNS.Events.SelectionChanging, function (e, info) {
            console.log("row: " + info.newSelections[0].row + ", " + "column: " + info.newSelections[0].col + ", " + "rowCount: " + info.newSelections[0].rowCount + ", " + "columnCount: " + info.newSelections[0].colCount );
        //    _getElementById("status").innerHTML = "SelectionChanging event called!";
          //  _getElementById("showSheetEvents").innerHTML = "New Selection(" + "row: " + info.newSelections[0].row + ", " + "column: " + info.newSelections[0].col + ", " + "rowCount: " + info.newSelections[0].rowCount + ", " + "columnCount: " + info.newSelections[0].colCount + ")";
        })
        
/*
        spread.bind(spreadNS.Events.SelectionChanging, function (e, args) {
            var selection = args.newSelections.pop();
            var sheetArea = args.sheetArea === 0 ? 'sheetCorner' : args.sheetArea === 1 ? 'columnHeader' : args.sheetArea === 2 ? 'rowHeader' : 'viewPort';
            console.log( 'SpreadEvent: ' + GC.Spread.Sheets.Events.SelectionChanging + ' event called' + ' sheetArea: ' + sheetArea + ' row: ' + selection.row + ' column: ' + selection.col + ' rowCount: ' + selection.rowCount + ' colCount: ' + selection.colCount);                
        });
*/
        var rowCount = sheet.getRowCount();
        
        _getElementById('btn').addEventListener('click', function () {
            for(var i =0;i<rowCount;i++){
                if(sheet.getCell(i, 0).value()!=null){
                    array[i]=sheet.getCell(i, 0).value();
                }
                else{
                    array[i]=false;
                }
            }
            console.log(array);
            // console.log(sheet.getArray(0,0,sheet.getRowCount(),1)); 2차원 배열 형식으로 불러오기(그리드)
        });

/*

        var rowCount = sheet.getRowCount();
        console.log(rowCount);
        var array = [];
        var cellType = new GC.Spread.Sheets.CellTypes.CheckBox();
        cellType.boxSize(12);
        for (var i = 0; i < rowCount ; i++) {
            sheet.getCell(i, 0).cellType(cellType);
        }
        
        _getElementById('btn').addEventListener('click', function () {
            for(var i =0;i<rowCount;i++){
                if(sheet.getCell(i, 0).value()!=null){
                    array[i]=sheet.getCell(i, 0).value();
                }
                else{
                    array[i]=false;
                }
            }
            console.log(array);
            // console.log(sheet.getArray(0,0,sheet.getRowCount(),1)); 2차원 배열 형식으로 불러오기(그리드)
        });
        */

    }
    function _getElementById(id){
        return document.getElementById(id);
    }
</script>    
<div class="sample-tutorial">
    <input type="button" value="CheckBox value 확인 및 array 저장" id="btn" />
    <div id="ss" style="width:100%;height:380px"></div>    
</div>
