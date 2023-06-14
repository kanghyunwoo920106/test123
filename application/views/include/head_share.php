<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>TeemCell TEST | </title>

    <!-- Bootstrap -->
    <link href="/resources/gentelella-master/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/resources/gentelella-master/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/resources/gentelella-master/nprogress/nprogress.css" rel="stylesheet">  

    <!-- Custom Theme Style -->
    <link href="/resources/css/custom.css" rel="stylesheet">

    <?php
    /* ▼ 추가 스타일시트 */
    if($h_StyleSheet != null && $h_StyleSheet != ''):
      foreach($h_StyleSheet AS $idx=>$val):        
        echo "<link href='".$val."' rel='stylesheet' type='text/css'/>\n";
      endforeach;
    endif;
    /* ▲ 추가 스타일시트 */
    ?>

    <?php
    /* ▼ 추가 자바스크립트 */
    if($h_JavaScript != null && $h_JavaScript != ''):
      foreach($h_JavaScript AS $idx=>$val):
        echo "<script src='".$val."' type='text/javascript'></script>";
      endforeach;
    endif;
    /* ▲ 추가 자바스크립트 */
    ?>


  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>TeemCell TEST!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">                
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>Share</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">               
              </div>

            </div>
            <!-- /sidebar menu -->            
          </div>
        </div>
		<!-- top navigation -->
        <div class="top_nav">          
        </div>
        <!-- /top navigation -->
		<!-- page content -->
        <div class="right_col" role="main">