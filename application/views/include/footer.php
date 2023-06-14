	<?php 
	$this->load->view('include/footer_in_loading');
	?>
    <span class="back-to-top d-flex align-items-center justify-content-center" onclick="topMove()"><i class="bi bi-arrow-up-short"></i></span>    
    <script src="<?php echo TEMPLATE_PATH;?>bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo ADMIN_TEMPLATE_PATH;?>jquery/dist/jquery.min.js"></script>
	<script src="<?php echo ADMIN_TEMPLATE_PATH;?>bootstrap-notify/bootstrap-notify.js"></script>
    <script src="<?php echo JS_PATH;?>common.js"></script>
    <?php
      /* ▼ 추가 자바스크립트 */
      if($f_JavaScript != null && $f_JavaScript != ''):
        foreach($f_JavaScript AS $idx=>$val):
          echo "<script src='".$val."' type='text/javascript'></script>\n";
        endforeach;
      endif;
      /* ▲ 추가 자바스크립트 */
    ?>  
  </body>
</html>
