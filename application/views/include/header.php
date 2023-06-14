 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="row d-flex align-items-center justify-content-between">
        <i class="col bi bi-list toggle-sidebar-btn"></i>
        <a href="index.html" class="col-4 logo d-flex align-items-center">
            <span class="d-none d-lg-block"></span>
            <img src="<?php echo IMG_PATH;?>logo.png" alt="">
        </a>
    </div>
    <!-- End Logo -->
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link nav-icon" href="/Mem/mlist" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="주소록" >
                    <i class="bi bi-person-video2"></i>
                </a>
            </li>
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?php if(!empty($user_data['user_img_path']) && !empty($user_data['user_img_name'])) {echo $user_data['user_img_path']."/s_".$user_data['user_img_name'];} else {echo IMG_PATH."profile-img.png";} ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user_data['user_name']?></span>
                </a>
                <!-- End Profile Iamge Icon -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $user_data['user_name']?></h6>
                        <span><?php echo $user_data['user_id']?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/mypage/profile">
                            <i class="bi bi-person"></i>
                            <span>정보수정</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/login/signout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>로그아웃</span>
                        </a>
                    </li>
                </ul>
                <!-- End Profile Dropdown Items -->
            </li>
            <!-- End Profile Nav -->
        </ul>
    </nav>
    <!-- End Icons Navigation -->
</header>
<!-- End Header -->