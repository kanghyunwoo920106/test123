<script>
	var memberstatus = <?php echo json_encode($jsoncode, true)?>;
</script>
<script id="innerform" type="text/template">
	<div class="innerform">
		<div class="row clearfix">
			<div class="col-md-2 col-sm-3 col-xs-4">
				<div class="st_text_wrap1">이름 변경</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-5">
				<form name="form_name_<%=idx%>">
				<input type="hidden" name="idx" value="<%=idx%>">
				<div class="form-group form-float">
					<div class="form-line">
						<input type="text" class="form-control" name="changeName" value="<%=user_name%>">
					</div>
				</div>
				</form>
			</div>
			<div class="col-md-1 col-sm-2 col-xs-3">
				<button type="button" class="btn btn-warning" onclick="changeName(<%=idx%>)">변경</button>
			</div>
		</div>
        <div class="row clearfix">
			<div class="col-md-2 col-sm-3 col-xs-4">
				<div class="st_text_wrap1">비밀번호변경</div>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-5">
				<form name="form_pw_<%=idx%>">
				<input type="hidden" name="idx" value="<%=idx%>">
				<div class="form-group form-float">
					<div class="form-line">
						<input type="text" class="form-control" name="changepw">
					</div>
				</div>
				</form>
			</div>
			<div class="col-md-1 col-sm-2 col-xs-3">
				<button type="button" class="btn btn-danger" onclick="changepw(<%=idx%>)">변경</button>
			</div>
		</div>
    </div>		
</script>
<script>
	var memberstatus = <?php echo json_encode($jsoncode, true)?>;
</script>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>LIST</strong></small></h3>
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
                        <table id="datatable_member" class="table table-striped table-bordered bulk_action" style="width:100%">
                            <colgroup>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col width="150px">
                                <col width="80px">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th>idx</th>
                                    <th>아이디</th>
                                    <th>이름</th>
                                    <th>가입방식</th>
                                    <th>상태</th>
                                    <th>가입일</th>
                                    <th>상태변경</th>
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
	<form id="ad_login_form" name="ad_login_form">
		<input type="hidden" id="user_idx" name="user_idx" value="">
	</form>
</div>

<!-- 회원 상세 -->
<div class="modal fade" id="userDetail" tabindex="-1" role="dialog" aria-labelledby="userDetail" aria-hidden="true">
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

