<script>
	window.onload = function(){
		var spread = new GC.Spread.Sheets.Workbook(
			document.getElementById("ss"),{sheetcount:1}
        );
        var sheet = spread.getActiveSheet();


    }
	function share_doc(){
        $.ajax({
            url: "/share/share_prc",
            type: "POST",
            data: {
				sid:$('#sid').val()
			},
            dataType: "json",
            success: function(rlt) {
				if(rlt.code=200){
                    var spread = GC.Spread.Sheets.findControl(document.getElementById('ss')); 
                    spread.fromJSON(JSON.parse(JSON.stringify(rlt.data.doc_data)),  { ignoreFormula: true });
                }
                else alert("ERROR");
            },
            error: function(request, status, error) {
                console.log(error);
            }
        });
    }
</script>
<input type="hidden" id="sid" value="<?php echo $sid;?>">
<div id="ss" style="height:500px; width:800px;"></div>
<div>
        <button name="share" value="복사" style="height:20px;" onclick="share_doc()">문서 불러오기</button>
    </div>