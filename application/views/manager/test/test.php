<link rel="stylesheet" type="text/css" href="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets/styles/gc.spread.sheets.excel2013white.css">
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets/dist/gc.spread.sheets.all.min.js" type="text/javascript"></script>
    
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-excelio/dist/gc.spread.excelio.min.js" type="text/javascript"></script>
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets-charts/dist/gc.spread.sheets.charts.min.js" type="text/javascript"></script>
    <script src="https://demo.grapecity.co.kr/spreadjs/learn-spreadjs/ko/purejs/node_modules/@grapecity/spread-sheets-resources-ko/dist/gc.spread.sheets.resources.ko.min.js" type="text/javascript"></script>

 
<div class="sample-tutorial">
    <div id="ss" class="sample-spreadsheets" style="widht:100%;height:500px"></div>
    <div class="options-container">
        <div class="option-row">
            <div class="inputContainer">
                <input type="checkbox" id="incremental" checked/>
                <label for="incremental">Incremental Loading</label>
                <p class="summary" id="loading-container">
                    Loading progress: 
                    <input style="width: 231px;" id="loadingStatus" type="range" name="points" min="0" max="100" value="0" step="0.01"/>
                </p>
                <input type="file" id="fileDemo" class="input">
                <br>
                <input type="button" id="loadExcel" value="import" class="button">
            </div>
            <div class="inputContainer">
                <input id="exportFileName" value="export.xlsx" class="input">
                <input type="button" id="saveExcel" value="export" class="button">
            </div>
        </div>
        <div class="option-row">
            <div class="group">
                <label>Password:
                    <input type="password" id="password">
                </label>
            </div>
        </div>
    </div>
</div>
<script>
	window.onload = function () {
    var spread = new GC.Spread.Sheets.Workbook(document.getElementById("ss"), {calcOnDemand: true});
    var excelIo = new GC.Spread.Excel.IO();
    document.getElementById('loadExcel').onclick = function () {
        var excelFile = document.getElementById("fileDemo").files[0];
        var password = document.getElementById('password').value;
        var incrementalEle = document.getElementById("incremental");
        var loadingStatus = document.getElementById("loadingStatus");
        
        incrementalEle.addEventListener('change', function (e) {
            document.getElementById('loading-container').style.display = incrementalEle.checked ? "block" : "none";
        });
        // here is excel IO API
        excelIo.open(excelFile, function (json) {
            var workbookObj = json;
            if (incrementalEle.checked) {
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
            } else {
                spread.fromJSON(workbookObj);
            }
        }, function (e) {
            // process error
            alert(e.errorMessage);

        }, {password: password});
    };
    document.getElementById('saveExcel').onclick = function () {

        var fileName = document.getElementById('exportFileName').value;
        var password = document.getElementById('password').value;
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
        }, {password: password});

    };
};
</script>