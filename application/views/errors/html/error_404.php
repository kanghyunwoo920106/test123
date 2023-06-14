<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">	
	<title><?php echo WEB_TITLE;?></title>
	<meta content="" name="description">
	<meta content="" name="keywords">	
	<link href="<?php echo IMG_PATH;?>favicon.png" rel="icon">
	<link href="<?php echo IMG_PATH;?>apple-touch-icon.png" rel="apple-touch-icon">
	<link href="<?php echo TEMPLATE_PATH;?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo TEMPLATE_PATH;?>bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo TEMPLATE_PATH;?>simple-datatables/style.css" rel="stylesheet">
	<link href="<?php echo CSS_PATH;?>style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>
<body>
<main id="main" class="main main-1400">
	<div class="container">
		<div class="row justify-content-center text-center">
			<div class="col-xl-5 col-lg-12 col-md-9">
				<div class="d-block row mt-5">
					<a href="<?php echo WEB_URL; ?>" class="col-4 logo">
						<span class="d-none d-lg-block"></span>
						<img src="<?php echo IMG_PATH;?>logo.png" alt="TEEMcell">
					</a>
				</div>
				<img class="mt-5" src="<?php echo IMG_PATH;?>error.png" alt="email_fail">
				<div class="d-block row">
					<div class="col-lg-12">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h3 fw-bolder mb-4">페이지를 찾을수가 없습니다.</h1>
								<p class="medium">방문하려는 페이지가 주소가 잘못되었거나, <br>
								요청하신 페이지 주소가 변경 혹은 삭제가 되었습니다. <br>페이지 주소를 다시 확인해주세요.</p>
							</div>
							<div class="row mt-4">
								<button type="button" class="col btn btn-green btn-md" onclick="location.href='<?php echo WEB_URL; ?>';">팀셀로 이동</button> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="<?php echo TEMPLATE_PATH;?>bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>