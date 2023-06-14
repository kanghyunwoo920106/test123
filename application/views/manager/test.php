<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>​
  <!--CSS files-->
  <link rel="styleSheet" href="<?php echo SPREADJS_PATH; ?>css/gc.spread.sheets.<?php echo SPREADJS_VAR;?>.css";" />
  <link rel="styleSheet" href="<?php echo SPREADJS_PATH; ?>css/gc.spread.sheets.designer.<?php echo SPREADJS_VAR;?>.min.css" />​
  <!--Script files-->
  <script src="<?php echo SPREADJS_PATH; ?>scripts/gc.spread.sheets.all.<?php echo SPREADJS_VAR;?>.min.js"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/plugins/gc.spread.sheets.charts.<?php echo SPREADJS_VAR;?>.min.js"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/plugins/gc.spread.sheets.shapes.<?php echo SPREADJS_VAR;?>.min.js" type="text/javascript"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/plugins/gc.spread.sheets.print.<?php echo SPREADJS_VAR;?>.min.js" type="text/javascript"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/plugins/gc.spread.sheets.barcode.<?php echo SPREADJS_VAR;?>.min.js" type="text/javascript"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/plugins/gc.spread.sheets.pdf.<?php echo SPREADJS_VAR;?>.min.js" type="text/javascript"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/interop/gc.spread.excelio.<?php echo SPREADJS_VAR;?>.min.js" type="text/javascript"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/designer/gc.spread.sheets.designer.resource.en.<?php echo SPREADJS_VAR;?>.min.js " type="text/javascript"></script>
  <script src="<?php echo SPREADJS_PATH; ?>scripts/designer/gc.spread.sheets.designer.all.<?php echo SPREADJS_VAR;?>.min.js" type="text/javascript"></script>
​	<script src="<?php echo SPREADJS_PATH; ?>license_tc.js" type="text/javascript"></script>
  <script>
      window.onload = function () {
          //Set License Key
          //GC.Spread.Sheets.Designer.LicenseKey = "XXX";
          //GC.Spread.Sheets.LicenseKey = "XXXX";​
          var designer = new GC.Spread.Sheets.Designer.Designer(document.getElementById("designerHost"));
      }
  </script>
</head>
<body>
  <!--DOM element-->
  <div id="designerHost" style="width:100%; height:1000px;border: 1px solid gray;"></div>
</body>
</html>
