<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><strong>템플릿 상세</strong></h3>
        </div>
		<div class="title_right">			
        </div>
	</div>
	<div class="clearfix"></div>
	<div class="">
		<div class="col-sm-12">
			<div class="x_panel">
				<input type="hidden" id="idx" value="<?php echo $idx;?>">
				<input type="hidden" id="exportFileName" value="">
				<div class="row">
					<div class="col-sm-1">
						<h2>분 류</h2>
					</div>
					<div class="col-sm-9">
						<span class="message" id="category_area"></span>
					</div>
					<div class="col-sm-2" style="text-align:right">
						<input class="btn" type="button" id="saveExcel" value="export">
					</div>
				</div>
				<div class="clearfix"><p></div>
				<div class="row">
					<div class="col-sm-1">
						<h2>제 목</h2>
					</div>
					<div class="col-sm-9">
						<span class="message" id="tem_title"></span>			
					</div>
					<div class="col-sm-2" style="text-align:right">
						<input type="checkbox" id="viewType">노출여부
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
						<img id="viewImg" src="/resources/images/default-image-300x225.jpg" alt="이미지 미리보기"  style="width:200px; height:100px;"/>
					</div>			
				</div>
				<div class="clearfix"><p></div>
				<div class="row">			
					<div class="col-md-6 col-sm-6">
						<button type="button" class="btn btn-success" onClick="listTemplate()">리스트</button>
					</div>
					<div class="col-md-6 col-sm-6" style="text-align:right">
						<button type="button" class="btn btn-primary" onclick="modifyTemplate('<?php echo $idx; ?>')">수 정</button>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>