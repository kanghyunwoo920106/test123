    <script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <div>
      <script type="text/javascript">
        var naver_id_login = new naver_id_login("<?php echo MAVER_CLIENT_ID;?>", "http://127.0.0.1/login/nvrcb"); // 역시 마찬가지로 'localhost'가 포함된 CallBack URL
        
        // 접근 토큰 값 출력
        var access_token = naver_id_login.oauthParams.access_token;

        

         // 네이버 사용자 프로필 조회
         naver_id_login.get_naver_userprofile("naverSignInCallback()");
        
        // 네이버 사용자 프로필 조회 이후 프로필 정보를 처리할 callback function
        function naverSignInCallback() {
          alert(JSON.stringify(naver_id_login));
          alert(naver_id_login.getProfileData('email'));
          alert(naver_id_login.getProfileData('nickname'));
        }
  
        $.ajax({
          url: "/login/nvrcb_prc",
          type: "POST",
          data: {
            at : access_token
      		},
          dataType: "json",
          success: function(rlt) {
            if(rlt.code == 200){
              alert('등록 되었습니다.');
            }
            else alert("ERROR");
          },
          error: function(request, status, error) {
            console.log(error);
          }
        });

      
        
        // 네이버 사용자 프로필 조회
        naver_id_login.get_naver_userprofile("naverSignInCallback()");
        
        // 네이버 사용자 프로필 조회 이후 프로필 정보를 처리할 callback function
        function naverSignInCallback() {
          //alert(naver_id_login.getProfileData('email'));
          /alert(naver_id_login.getProfileData('nickname'));
        }
        
      </script>
    </div> 

