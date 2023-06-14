<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><strong>Template LIST</strong></h3>
        </div>
		<div class="title_right">
			<div class="col-md-4 col-sm-4 ">
				<select class="form-control" id="l_cate" onChange="getCategoryListTem('L')">
					<option value="">대분류</option>
					<?php
					if($cate){
						foreach($cate as $row){
							echo "<option value='".$row['idx']."'>".$row['cate_name']."</option>";
						}
					}
					?>
				</select>
			</div>
			<div class="col-md-4 col-sm-4 ">
				<select class="form-control" id="m_cate" onChange="getCategoryListTem('M')">
					<option>중분류</option>
				</select>
			</div>
			<div class="col-md-4 col-sm-4 ">
				<select class="form-control" id="s_cate" onChange="getCategoryListTem('S')">
					<option>소분류</option>
				</select>
			</div>
			<div class="col-md-5 col-sm-5   form-group pull-right top_search">				
				<div class="input-group">
					<input type="text" class="form-control" id="search_txt" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button" onclick="doSearch()">Go!</button>
					</span>
                </div>
            </div>
        </div>
	</div>
	<div class="clearfix"></div>	
	<div class="row">
		<div class="col-sm-12">
			<button type="button" class="btn btn-secondary" onclick="writeTemplate()">템플릿 등록</button>
		</div>
		<div class="col-sm-12">
		<div class="x_panel">			
			<div class="x_title">
				<div class="clearfix"></div>
			</div>
			<div class="x_content">
				<div class="row" id="thumbnail">					
				</div>
			</div>
		</div>
	</div>
</div>