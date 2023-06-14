<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript">
    window.onload = function(){
        GC.Spread.Common.CultureManager.culture("ko-kr");
        // spread 초기화 
        var spread = new GC.Spread.Sheets.Workbook(
            document.getElementById("ss"),
            {sheetcount:1}                
        );
        // spread 얻기
        //var sheet = spread.getActiveSheet();
        var sheet = spread.getSheet(0);
        
        //값 설정하기 - Text
        sheet.setValue(1, 1, "값 설정하기");
        
        //값 설정하기 - Number : B3에 "Number" 라는 텍스트를, C3에 23이라는 숫자를 삽입합니다.
        sheet.setValue(2, 1, "Number");
        sheet.setValue(2, 2, 23);
        
        //값 설정하기 - Text : B4에 "Text" 라는 텍스트를, C4에 "GrapeCity"라는 텍스트를 삽입합니다.
        sheet.setValue(3, 1, "Text");
        sheet.setValue(3, 2, "GrapeCity");

        //값 설정하기 - DateTime : B5에 "Datetime" 이라는 텍스트를, C5에 오늘 날짜를 삽입합니다.
        //sheet.setValue(4, 1, "Datetime");
        sheet.getCell(4, 1).value("Datetime");
        sheet.getCell(4, 2).value(new Date()).formatter("yyyy-mm-dd");
        
        //함수 설정하기, C3 셀과 20 더하기
        sheet.setFormula(5, 2, '=SUM(C2,20)');
    }

    //문서 저장 후 URL 생성 
    function test(){
        var serializationOption = {
            includeAutoMergedCells: true // include the automatically merged cells to the real merged cells when converting the workbook to json.
        }
        var spread1 = GC.Spread.Sheets.findControl(document.getElementById('ss'));
        var jsonString = JSON.stringify(spread1.toJSON( { includeBindingSource: true } ));

        // 문서 저장 
        $.ajax({
            url: "/spreadjs/test01_prc",
            type: "POST",
            data: {
                doc_id : $('#doc_id').val(),
                doc_data : jsonString,
                doc_limit : $("#limit_dt option:selected").val()
            },
            dataType: "json",
            success: function(rlt) {
                if(rlt.code=200){
                    $('#return_url').val('http://127.0.0.1/share?sid='+rlt.data);
                }
                else alert("ERROR");
            },
            error: function(request, status, error) {
                console.log(error);
            }
        });
    }
</script>
<div id="container">
    <h1>Getting started with SpreadJS</h1>
    <p> Pure JavaScript</p>
    <input type="hidden" id="doc_id" value="">
    <div>
        <ul>
            <li>
                <p>제목 : <input type="text" id="doc_title" value=""></p>
            </li>
            <li>
                <p>공유 기간 :
                <select id="limit_dt">
                    <option value="1">1</option>
                </select>
</p>
            </li>
        </ul>
    </div>
    <div id="ss" style="width:100%;height:600px;"></div>
    <div>
        <ul>
            <li><p>URL : <input type="text" id="return_url" value="" style="width:350px"></p></li>            
        </ul>
    </div>
    <div>
        <button name="share" value="복사" style="height:20px;" onclick="test()">공유 URL 생성</button>
    </div>
</div>