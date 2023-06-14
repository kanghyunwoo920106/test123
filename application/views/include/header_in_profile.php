<li class="nav-item dropdown pe-3 no-mo">
	<span class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-placement="bottom" data-bs-original-title="proflie" data-bs-toggle="dropdown">
		<img src="<?php if(!empty($user_data['user_img'])) {echo $user_data['user_img'];} else {echo IMG_PATH."no-profile-img.png";} ?>" alt="Profile" class="rounded-circle" style="cursor:pointer;">
		<span class="d-none d-md-block dropdown-toggle ps-2" style="cursor:pointer;"><?php echo $user_data['user_name']?></span>
	</span>
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
			<a class="dropdown-item d-flex align-items-center" href="/Mem/mlist">
				<i class="bi bi-person-video2"></i>
				<span>주소록</span>
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