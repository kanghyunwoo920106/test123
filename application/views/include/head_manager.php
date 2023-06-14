<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="<?php echo IMG_PATH;?>favicon.png" rel="icon">
		<title><?php echo WEB_TITLE;?></title>		
		<!-- Bootstrap -->
		<link href="<?php echo ADMIN_TEMPLATE_PATH; ?>bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo ADMIN_TEMPLATE_PATH; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo ADMIN_TEMPLATE_PATH; ?>nprogress/nprogress.css" rel="stylesheet">
		<!-- iCheck -->
		<link href="<?php echo ADMIN_TEMPLATE_PATH; ?>iCheck/skins/flat/green.css" rel="stylesheet">		
		<?php
		/* ▼ 추가 스타일시트 */
		if($h_StyleSheet != null && $h_StyleSheet != ''):
			foreach($h_StyleSheet AS $idx=>$val):
				echo "<link href='".$val."' rel='stylesheet' type='text/css'/>\n";
			endforeach;
		endif;
		/* ▲ 추가 스타일시트 */
		?>
		<link href="<?php echo ADMIN_CSS_PATH; ?>admin.css" rel="stylesheet">
	</head>
	<body class="nav-md">
		<div class="container body">
			<div class="main_container">
				<div class="col-md-3 left_col">
					<div class="left_col scroll-view">
						<div class="navbar nav_title" style="border: 0;">
							<a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $h_Title;?></span></a>
						</div>
						<div class="clearfix"></div>
						<!-- menu profile quick info -->
						<div class="profile clearfix">
							<div class="profile_pic">
								<img src="<?php echo IMG_PATH; ?>page/executive-g5e96efc27_640.jpg" alt="..." class="img-circle profile_img">
							</div>
							<div class="profile_info">							
								<span>Welcome,</span>
								<h2><?php echo $admin_data['ad_name']?></h2>
							</div>
						</div>
						<!-- /menu profile quick info -->
						<br />
						<!-- sidebar menu -->
						<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
							<div class="menu_section">
								<h3>TEEMCell</h3>
								<ul class="nav side-menu">
								<?php
								foreach($menu_list as $row) {
									$active = ($menu_m == $row['active']) ? 'active' : '';
									echo '<li class="'.$active.'" ><a><i class="fa '.$row['icon'].'"></i> '.$row['menu'].' <span class="fa fa-chevron-down"></span></a>';
									if($row['sub']) {
										if($active){
											echo '<ul class="nav child_menu" style="display: block;">';
										} else {
											echo '<ul class="nav child_menu">';
										}
										foreach($row['sub'] as $row_s){
											$sub_active = ($menu_s == $row_s['active']) ? 'current-page' : ''; 
											echo '<li class="'.$sub_active.'"><a href="/TC_Manager'.$row_s['url_link'].'">'.$row_s['menu'].'</a></li>';
										}
										echo '</ul>';
									}
									echo '</li>';
								}
								?>                          
								</ul>                
							</div>
						</div>
						<!-- /sidebar menu -->
						<!-- /menu footer buttons -->
						<div class="sidebar-footer hidden-small">
							<a data-toggle="tooltip" data-placement="top" title="Settings">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="FullScreen">
							<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Lock">
							<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
						</a>
						<a data-toggle="tooltip" data-placement="top" title="Logout" href="/login/manager_signout">
							<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
						</a>
					</div>
					<!-- /menu footer buttons -->
				</div>
			</div>
			<!-- top navigation -->
			<div class="top_nav">
				<div class="nav_menu">
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
					</div>
					<nav class="nav navbar-nav">
						<ul class=" navbar-right"></ul>
					</nav>
				</div>
			</div>
			<!-- /top navigation -->
			<!-- page content -->
			<div class="right_col" role="main">