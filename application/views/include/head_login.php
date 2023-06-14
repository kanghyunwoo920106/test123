<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title><?php echo WEB_TITLE;?></title>
	<meta content="" name="description">
	<meta content="" name="keywords">
	<!-- Favicons -->
	<link href="<?php echo IMG_PATH;?>favicon.png" rel="icon">
	<link href="<?php echo IMG_PATH;?>apple-touch-icon.png" rel="apple-touch-icon">
	
	<!-- Vendor CSS Files -->
	<link href="<?php echo TEMPLATE_PATH;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo TEMPLATE_PATH;?>bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
	<link href="<?php echo TEMPLATE_PATH;?>simple-datatables/style.css" rel="stylesheet">

	<!-- Template Main CSS File -->
	<link href="<?php echo CSS_PATH;?>style.css" rel="stylesheet">	
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
	<?php
      /* ▼ 추가 스타일시트 */
      if($h_StyleSheet != null && $h_StyleSheet != ''):
        foreach($h_StyleSheet AS $idx=>$val):        
          echo "<link href='".$val."' rel='stylesheet' type='text/css'/>\n";
        endforeach;
      endif;
      /* ▲ 추가 스타일시트 */
    ?>
</head>
<body>