<div>
    <div class="login_wrapper">
        <div class="animate form login_form">            
        </div>
        <div>
            <form id="simple_join" method="POST" onSubmit="nvSingInPrc()">
                <input type="hidden" id="nv_dt" value="<?php echo $code_dt;?>">
                <button>회원 가입</button>
            </form>
        </div>
        <div>
            <form id="sign_in" method="POST" onSubmit="login();return false;">
                <input type="hidden" name="nv_dt" id="nv_dt" value="<?php echo $code_dt; ?>">
                <h1>Login Form</h1>
                <div>
                    <input type="text" name="user_id" class="form-control" placeholder="UserEmail" required="" />
                </div>
                <div>
                    <input type="password" name="user_pass" class="form-control" placeholder="Password" required="" />
                </div>
                <div>
                    <button class="btn btn-block bg-pink waves-effect" type="submit">SIGN IN</button>
                </div>
                <div class="clearfix"></div>
                <button>회원 연동</button>
            </form>
        </div>
    </div>
</div>
<script>
function nvSingInPrc(){
}
</script>
