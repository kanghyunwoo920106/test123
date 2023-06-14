<!-- ======= Header =======-->
<header id="header" class="header fixed-top d-flex align-items-center sub-header">
	<div class="col-auto me-auto ">
		<a href="#" id="go-back"><i class="bi bi-arrow-left"></i></a>
		<h2 class="sub-header-title">템플릿</h2>
	</div>
    <i class="col-auto d-flex bi bi-list toggle-sidebar-btn no-pc"></i>
</header><!-- End Header-->
<aside id="sidebar" class="sidebar">
	<ul class="sidebar-nav" id="sidebar-nav">
		<li class="nav-heading" onclick="selCate(0, 0, 0)" style="cursor:pointer;">전체</li>
		<?php                 
		foreach($cate_date as $row) {
			echo '<li class="nav-item">';
			echo '	<a class="nav-link collapsed" data-bs-target="#'.$row['active'].'" data-bs-toggle="collapse" href="#" onclick="selCate('.$row['l_cate_num'].', 0, 0)">';
			echo '	<i class="bi bi-file-earmark-ruled"></i>';
			echo '<span>'.$row['menu'].'</span>';
			if(count($row['M']) > 0){
				echo '<i class="bi bi-chevron-down ms-auto"></i></a>';
				echo '<ul id="'.$row['active'].'" class="nav-content collapse" data-bs-parent="#sidebar-nav">';
				foreach($row['M'] as $row_m){				
					echo '<li>';
					echo '<a href="#" onclick="selCate('.$row['l_cate_num'].', '.$row_m['m_cate_num'].', 0)">';
					echo '<i class="bi bi-circle" data-bs-target="#'.$row_m['active'].'" data-bs-toggle="collapse"></i><span>'.$row_m['menu'].'</span>';					
					if(!empty($row_m['S'])){
						echo '<i class="bi bi-chevron-down ms-auto"></i></a>';
						echo '<ul id="'.$row_m['active'].'">';
						foreach($row_m['S'] as $row_s){	
							echo '<li><a href="#" onclick="selCate('.$row['l_cate_num'].', '.$row_m['m_cate_num'].', '.$row_s['s_cate_num'].')">-<span>'.$row_s['menu'].'</</span></a></li>';
						}
						echo '</ul>';
					}
					else{
						echo '</a>';
					}
					echo '</li>';
				}
				echo '</ul>';
			} else {
				echo '</a>';
			}
			echo '</li>';
		}
		?>
	</ul>
</aside>