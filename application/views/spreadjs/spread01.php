<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SpreadJs Test</title>
    <script src="/resources/SpreadJS.Release.15.2.5_2/SpreadJS/scripts/gc.spread.sheets.all.15.2.5.min.js" type="text/javascript"></script>
    <link href="/resources/SpreadJS.Release.15.2.5_2/SpreadJS/css/gc.spread.sheets.excel2013white.15.2.5.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript">
        window.onload = function(){
            var spread = new GC.Spread.Sheets.Workbook(
                document.getElementById("ss"),
                {sheetcount:3}                
            );
            var sheet = spread.getActiveSheet();
        }
    </script>
</head>
<body>

<div id="container">
	<h1>Getting started with SpreadJS</h1>
    <p> Pure JavaScript</p>

	
        <div id="ss" style="height:500px; width:800px;"></div>
</div>

</body>
</html>