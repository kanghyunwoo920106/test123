 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">
	<div class="row">
		<div class="col-auto d-flex align-items-center">
			<a href="<?php echo WEB_URL;?>" class="logo">
				<span class="d-none d-lg-block"></span>
				<img class="col-auto" src="<?php echo IMG_PATH;?>logo.png" alt="">
			</a>
		</div>
		<i class="col-auto d-flex bi bi-list toggle-sidebar-btn"></i>
	</div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">            
            <?php 
				$this->load->view('include/header_in_profile');
			?>
        </ul>
    </nav>
    
</header>
<!-- End Header -->