<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><strong>템플릿 수정</strong></h3>
        </div>
		<div class="title_right">			
        </div>
	</div>
	<div class="clearfix"></div>	
	<div class="">
		<div class="col-sm-12">
			<div class="x_panel">
				<FORM id="file_frm">
				<input type="hidden" id="template_idx" name="template_idx" value="<?php echo $idx;?>">				
				<div class="row">					
					<div class="col-sm-12">
						<h2>분 류 <a style="cursor:pointer;text-align:right" data-toggle="modal" data-target="#modifyCategory" onclick="addCategoryPop()"><i class="fa fa-plus"></i></a></h2>
						<span class="message" id="category_area"></span>
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
					<div class="col-sm-12"">
						<div id="excel_area" style="width:100%;height:900px;"></div>
						<div id="designerHost" style="width:100%;height:900px;"></div>
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
						<button type="button" class="btn btn-success" onClick="templatModifySubmit(this.form)">템플릿 등록</button>
					</div>
					<div class="col-md-6 col-sm-6">
					</div>
				</div>
				</FORM>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="modifyCategory" tabindex="-1" role="dialog" aria-labelledby="modifyCategory" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="catogoryModalTitle">템플릿 카테고리 수정</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- start accordion -->
				<div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
					<input type="hidden" id="category_idx" vlaue="">
					<div class="col-sm-1" >
						<h2>분류</h2>							
					</div>
					<div class="col-sm-11">
						<div class="col-md-4 col-sm-4 ">
							<select class="form-control" id="l_cate"  name="l_cate" onChange="getCategoryList('L')">
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
							<select class="form-control" id="m_cate"  name="m_cate" onChange="getCategoryList('M')">
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
		    	<!-- end of accordion -->
      		</div>
			<div class="modal-footer">
				<div class="col-sm-12">
					<div class="col-md-4 col-sm-4 ">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
					<div class="col-md-4 col-sm-4 ">
					</div>
					<div class="col-md-4 col-sm-4" style="text-align:right">
						<button type="button" class="btn btn-success" data-dismiss="modal" id="btnAdd" onclick="addDocTemCate()">Submit</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal" id="btnModify" onclick="modifyDocTemCate()">Modify</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>