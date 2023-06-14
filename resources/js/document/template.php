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
			<div class="row_left" style="width:90%">
			</div>
			<div class="row_right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#noticeWrite" onclick="resetNoticeD()">작성</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<div class="card-box table-responsive">
					<table id="datatable_notice" class="table table-striped table-bordered bulk_action">
						<colgroup>
							<col width="80px">
							<col width="100px">
							<col>                                
							<col width="150px">
						</colgroup>
						<thead>
							<tr>
								<th>idx</th>
								<th>CATE</th>
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

<!-- -->
<div class="modal fade" id="noticeWrite" tabindex="-1" role="dialog" aria-labelledby="noticeWrite" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="noticeWriteModalLabel">공지사항</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="notice_form">
					<input type="hidden" id="board_idx" value="">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">제목:</label>
						<input type="text" class="form-control" id="notice-title">
					</div>
					<div class="form-group">
						<label for="message-text" class="col-form-label">내용:</label>
						<textarea class="form-control" id="notice-text" style="height:400px"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="addButton" onclick="addNotice()">저장</button>
				<button type="button" class="btn btn-primary" id="modifyButton" style="display:none" onclick="modifyNotice()">수정</button>
			</div>
		</div>
	</div>
</div>

<!-- 공지사항 상세 -->
<div class="modal fade" id="noticeDPop" tabindex="-1" role="dialog" aria-labelledby="noticeDetail" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
		<input type="hidden" id="boardIdx" value="">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="noticeTitle">제목</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">				
				<div class="row clearfix">
					<b>내용 : </b>
					<div id="noticeContents"></div>					
				</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" onclick="modifyNotice()">수정</button>
			</div>
		</div>
	</div>
</div>