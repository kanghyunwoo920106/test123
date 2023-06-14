				</div>
				<footer>
					<div class="pull-right"></div>
					<div class="clearfix"></div>
				</footer>
			</div>
		</div>
		<?php 
			// $this->load->view('include/footer_in_loading');
		?>
		<!-- jQuery -->
		<script src="<?php echo ADMIN_TEMPLATE_PATH;?>jquery/dist/jquery.min.js"></script>
		<script src="<?php echo ADMIN_TEMPLATE_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo ADMIN_TEMPLATE_PATH;?>fastclick/lib/fastclick.js"></script>
		<script src="<?php echo ADMIN_TEMPLATE_PATH;?>nprogress/nprogress.js"></script>
		<script src="<?php echo ADMIN_TEMPLATE_PATH;?>bootstrap-notify/bootstrap-notify.js"></script>
		<script src="<?php echo JS_PATH?>common.js"></script>
		<script src="<?php echo ADMIN_JS_PATH;?>custom.js"></script>
		<?php
		/* ▼ 추가 자바스크립트 */
		if($h_JavaScript != null && $h_JavaScript != ''):
		  foreach($h_JavaScript AS $idx=>$val):
			echo "<script src='".$val."' type='text/javascript'></script>\n";
		  endforeach;
		endif;
		/* ▲ 추가 자바스크립트 */
		?>
		
	</body>
</html>
