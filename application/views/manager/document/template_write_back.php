<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><strong>템플릿 등록</strong></h3>
        </div>
		<div class="title_right">			
        </div>
	</div>
	<div class="clearfix"></div>	
	<div class="">
		<div class="col-sm-12">
			<div class="x_panel">
				<FORM id="file_frm">
				<div class="row">
					<div class="col-sm-1" >
						<h2>분류</h2>							
					</div>
					<div class="col-sm-11">
						<div class="col-md-4 col-sm-4 ">
							<select class="form-control" id="l_cate"  name="l_cate" onChange="get_category('L')">
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
							<select class="form-control" id="m_cate"  name="m_cate" onChange="get_category('M')">
								<option value="">중분류</option>
							</select>
						</div>
						<div class="col-md-4 col-sm-4 ">
							<select class="form-control" id="s_cate"  name="s_cate">
								<option value="">소분류</option>
							</select>
						</div>
					</div>
				</div>
				<div class="clearfix"><p></div>
				<div class="row">
					<div class="col-sm-1">
						<h2>제목</h2>							
					</div>
					<div class="col-sm-11">
						<input type="text" id="tem_title" name="tem_title" required="required" class="form-control ">
					</div>
				</div>
				<div class="clearfix"><p></div>
				<div class="row">
					<div class="col-sm-12">
						<div id="ss" style="width:100%;height:600px;"></div>
					</div>
				</div>		
				<div class="clearfix"><p></div>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<textarea id="tem_memo" name="tem_memo" style="width:100%;height:99%"></textarea>
					</div>
					<div class="col-md-6 col-sm-6">
						<img id="View" src="/resources/images/default-image-300x225.jpg" alt="이미지 미리보기"  style="width:200px; height:100px;"/>
						<input type="file" id="tem_img" name="tem_img">
					</div>
				</div>	
				<div class="clearfix"><p></div>
				<div class="row">			
					<div class="col-md-6 col-sm-6">
						<button type="button" class="btn btn-success" onClick="templat_submit(this.form)">템플릿 등록</button>
					</div>
					<div class="col-md-6 col-sm-6">
					</div>
				</div>
				</FORM>
			</div>
		</div>
	</div>
</div>