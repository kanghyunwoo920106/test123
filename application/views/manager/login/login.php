<main id="main" class="main main-1400">
<div class="container">
	<div class="row justify-content-center">
		 <div class="col-4">
			<div class="row d-flex mt-5">
				<a href="<?php echo WEB_URL;?>" class="col-4 logo">
					<span class="d-none d-lg-block"></span>
					<img src="<?php echo IMG_PATH;?>logo.png" alt="TEEMcell">
				</a>
			</div>
			<div>				
				<div class="login_wrapper">
					<div class="animate form login_form">			
						<div class="card o-hidden border-0 shadow-lg my-5 login-area">							
							<div class="card-body p-0">
								<div class="row">
									<div class="col-lg-12">
										<div class="p-5">
											<div class="text-center">
												<h1 class="h4 fw-bolder mb-4">Admin 로그인</h1>
											</div>
											<form class="user" id="sign_in" method="POST" onSubmit="mnlogin();return false;">
												<div class="form-group mb-2">
													<input type="id" class="form-control form-control-user" id="user_id" name="user_id"  placeholder="아이디 입력해주세요." required>
												</div>
												<div class="form-group mb-4">
													<input type="password" class="form-control form-control-user" id="user_pass" name="user_pass" placeholder="비밀번호를 입력해주세요" required>
												</div>
											
												<div class="d-grid gap-2 mt-4">
													<button type="submit" class="btn btn-green pt-2 pb-2">로그인</button>
												</div>												
												<div class="copyright text-center mt-4">
													<span>ⓒ Twosun Corp.</span>
												</div>
											</form>
										</div>
									</div>									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>



<script>
  function mnlogin(){
    $.ajax({
      url: '/login/manager_login_prc',
      type: 'POST',
      data: $("#sign_in").serialize(),
      dataType: 'json',
      success: function (result) {
        if( result.rlt == true ){          
          location.replace('/TC_Manager');          
        }else {
          showNotification("alert-danger", result.msg, "top", "center", "", "");
        }
      },
      error : function(request, status, error) {
        console.log(error);
      }
    });
    return false;
  }
</script>