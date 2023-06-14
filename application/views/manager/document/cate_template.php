<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><strong>Template Category 관리</strong></h3>
        </div>
		<div class="title_right"></div>
	</div>
	<div class="clearfix"></div>
	<div class="col-sm-12">
		<div class="x_panel">
			<div class="x_title">
				<ul class="nav navbar-right panel_toolbox">
					<li style="width:30px;text-align:center;"><a class="" data-toggle="modal" data-target="#modifyMainCate"><i class="fa fa-gear"></i></a></li>
					<li style="width:30px;text-align:center;"><a class="" data-toggle="modal" data-target="#addMainCate"><i class="fa fa-plus"></i></a></li>
				</ul>
				<div class="clearfix"></div>
            </div>
			<div class="x_content">
				<div class="col-xs-8">
					<!-- required for floating -->
					<!-- Nav tabs -->
					<div class="nav nav-tabs flex-column  bar_tabs" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<?php						
						if($cate){
							foreach($cate as $row){
						?>
							<a class='nav-link' id='v-pills-<?php echo $row["active_code"];?>-tab' data-toggle='pill' href='#v-pills-<?php echo $row["active_code"];?>' role='tab' aria-controls='v-pills-<?php echo $row["active_code"];?>' aria-selected='false' onclick='setMiddleCate("<?php echo $row["idx"];?>")'><?php echo $row["cate_name"];?></a>
						<?php
							}
						}						
						?>
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<!-- Tab panes -->
					<input type="hidden" id="main_cate_idx" value="">
					<input type="hidden" id="main_active_code" value="">
					<div class="tab-content" id="v-pills-tabContent">						
					<?php
					if($cate){						
						foreach($cate as $row){
					?>
						<div class='tab-pane fade' id='v-pills-<?php echo $row["active_code"];?>' role='tabpanel' aria-labelledby='v-pills-<?php echo $row["active_code"];?>-tab'>
							<ul class="nav navbar-right">
								<li style="height:45px;width:30px;text-align:center;cursor:pointer;">
									<a class="" data-toggle="modal" data-target="#addMiddleCate" onclick="setMiddleCate('<?php echo $row["idx"];?>')"><i class="fa fa-plus"></i></a>
								</li>
							</ul>
							<ul class='to_do middle_cate_list' id='sub_cate_<?php echo $row["idx"];?>'></ul>
						</div>
					<?php 
						}
					}					
					?>						
					</div>
				</div>
				<div class="col-md-4 col-sm-6">
					<!-- Tab panes -->
					<input type="hidden" id="sub_cate_idx" value="">
					<input type="hidden" id="sub_active_code" value="">
					<div class="tab-content"  id="v-pills-tabContent-sub">
						
						<?php
						/*
						<div class="tab-pane fade" id="qwe">
							<ul class="nav navbar-right"><li style="height:45px;width:30px;text-align:center;"><a class="" data-toggle="modal" data-target="#addMiddleCate"><i class="fa fa-plus"></i></a></li></ul>
							<ul class='to_do small_cate_list'>
								<li>
									<input type='hidden' class='small_cate_idx' value=''>
									<div><p>3-1</p></div>
									<div style='text-align:right;'><a><i class='fa fa-wrench' style='width:25px;'></i></a><a><i class='fa fa-close' style='width:25px;'></i></a></div>								
								</li>
							</ul>
						</div>
						*/
						?>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modifyMainCate" tabindex="-1" role="dialog" aria-labelledby="modifyMainCateTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">템플릿 메인 카테고리 수정</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- start accordion -->
				<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
			<?php
				if($cate){
					foreach($cate as $row){
			?>		
					<div class="panel" id="panel_<?php echo $row["idx"];?>">
						<input type='hidden' class="cate_idx" value="<?php echo $row["idx"];?>">
						<a class="panel-heading" role="tab" id="heading_<?php echo $row["idx"];?>" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $row["active_code"];?>" aria-expanded="true" aria-controls="<?php echo $row["active_code"];?>" style="height:50px">
                          <h2 class="panel-title"><?php echo $row["cate_name"];?></h2>
                        </a>
                        <div id="<?php echo $row["active_code"];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_<?php echo $row["idx"];?>">
							<div class="panel-body">
								<div class="row clearfix">
									<div class="col-md-2 col-sm-3 col-xs-4">
										<p><strong>이름변경</strong></p>
									</div>
									<div class="col-md-6 col-sm-4 col-xs-5">
										<form name="form_name_<?php echo $row["idx"];?>">
										<input type="hidden" name="idx" value="<?php echo $row["idx"];?>">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" class="form-control" id="ch_name_<?php echo $row["idx"];?>" name="changeName" value="">
											</div>
										</div>
										</form>
									</div>
									<div class="col-md-4 col-sm-3 col-xs-3">
										<button type="button" class="btn btn-warning" onclick="changeCate('<?php echo $row["idx"];?>')">변경</button>
										<button type="button" class="btn btn-danger" onclick="delCate('<?php echo $row["idx"];?>')">삭제</button>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php
				}
			}
			?>
				</div>
		    	<!-- end of accordion -->
      		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>				
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addMainCate" tabindex="-1" role="dialog" aria-labelledby="addMainCateTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">템플릿 대분류 카테고리 등록</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_content">
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">카테고리명<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 ">
							<form>
								<input type="text" id="category-name" required="required" class="form-control ">
							</form>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" onclick="addMainCategory()">Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addMiddleCate" tabindex="-1" role="dialog" aria-labelledby="addMiddleCateTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">템플릿 중분류 카테고리 등록</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_content">
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">카테고리명<span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 ">
							<form>
								<input type="text" id="sub-category-name" required="required" class="form-control ">
							</form>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" onclick="addMiddleCatagory()">Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addSmallCate" tabindex="-1" role="dialog" aria-labelledby="addSmallCateTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">템플릿 소분류 카테고리 등록</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_content">
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">카테고리명 : </label>
						<div class="col-md-6 col-sm-6 ">
							<form><input type="text" id="small_category_name" required="required" class="form-control "></form>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" onclick="addSmallCatagory()">Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modifySubCate" tabindex="-1" role="dialog" aria-labelledby="modifySubCateTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">CATEGORY 이름 변경</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="x_content">
					<div class="item form-group">
						<label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">카테고리명 : </label>
						<div class="col-md-6 col-sm-6 ">
							<form>
								<input type="hidden" id="ch_category_idx" vlaue="">
								<input type="text" id="ch_category_name" required="required" class="form-control" placeholder="카테고리명을 입력해 주세요">
							</form>
						</div>
					</div>					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" onclick="subCateChanageName()">Submit</button>
			</div>
		</div>
	</div>
</div>

