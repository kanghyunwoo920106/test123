<script type="text/javascript">
    var spreadNS = GC.Spread.Sheets;   
    window.onload = function () {
        var spread = new GC.Spread.Sheets.Workbook(_getElementById("ss"),{sheetCount:1});

        spread.options.showScrollTip = GC.Spread.Sheets.ShowScrollTip.both;

        spread.options.tabStripVisible = false;
        spread.options.tabNavigationVisible = true;

        // 시트 이름을 변경 못하게
        spread.options.tabEditable = true;

        // 시트 순서 변경 금지
        spread.options.allowSheetReorder = true;
        
        // disable the vertical scrollbar
        spread.options.showVerticalScrollbar = true;
        
        // disable the horizontal scrollbar
        spread.options.showHorizontalScrollbar = true; 
        
        spread.options.scrollbarMaxAlign = true;

        initSpread(spread);
    }

  

    function initSpread(spread){      
        var sheet = spread.getActiveSheet();
        sheet.options.selectionBorderColor = 'red';
        sheet.options.selectionBackColor = 'transparent';

        var array = [];
        
        _getElementById('btn').addEventListener('click', function () {
            var selections = sheet.getSelections(); 

            // [{"row":3,"rowCount":11,"col":1,"colCount":2}]
            alert(selections[0].row + ' ' + selections[0].rowCount + '||' + selections[0].col + ' ' + selections[0].colCount);            
            var rowcell = '';
            var colcell = '';
            for(var i = 0; i < selections[0].rowCount; i++){ 
                rowcell = (selections[0].row * 1) + (i *  1);                
                for(var ii = 0; ii < selections[0].colCount; ii++){
                    colcell = (selections[0].col * 1) + (ii *  1);
                    console.log(rowcell + ' ' + colcell + ' = '+ sheet.getCell(rowcell, colcell).value());                   
                    if(sheet.getCell(rowcell, colcell).value()!=null){
                        array.push(sheet.getCell(rowcell, colcell).value());
                    }                               
                }             
            }
            console.log(array);
        })
    }
    function _getElementById(id){
        return document.getElementById(id);
    }
</script>    
<div class="sample-tutorial">
    <input type="button" value="셀렉트한 셀 값 표시" id="btn" />
    <div id="ss" style="width:100%;height:380px"></div>    
</div>
