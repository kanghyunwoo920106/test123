<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3><strong>LIST</strong></h3>
        </div>
		<div class="title_right">
			<div class="col-md-5 col-sm-5   form-group pull-right top_search">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Go!</button>
					</span>
                </div>
            </div>
        </div>
	</div>
	<div class="x_content">		
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable_doc_user" class="table table-striped table-bordered bulk_action">
						<colgroup>
							<col width="80px">
							<col width="150px">
							<col>
							<col>                                
							<col width="150px">
						</colgroup>
						<thead>
							<tr>
								<th>idx</th>
								<th>등록자</th>
								<th>문서코드</th>
								<th>제목</th>								
								<th>등록일</th>                                    
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 공지사항 상세 -->
<div class="modal fade" id="userDocDetail" tabindex="-1" role="dialog" aria-labelledby="userDocDetail" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<input type="hidden" id="boardIdx" value="">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userDocTitle">제목</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">				
				<div class="row clearfix">					
					<div id="ss" style="width:760px;height:420px"></div>					
				</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
