<?php include("header.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-check"></i>Active Photos</h1>
          <p>Add / Edit / Deactivate Photos.</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
 <div class="container-fluid mar-top">
      	<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="row">
		   			<div class="col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="page-heading"> <h6>Manage Photo</h6></div>
								<button class="btn btn-success btn-sm  m-1" id="add_pic"><i class="fa fa-plus-square"></i> Add Photo</button>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
										  <div class="table-responsive">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageactivePicsTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>Date</th>
															<th>Caption</th>	
															<th>Rated By</th>
															<th>Rating</th>
															<th>Status</th>
															<th><i class="fa fa-pencil-alt"></i> Caption</th>
															<th><i class="fa fa-eye"></i></th>
															<th><i class="fa fa-pencil-alt"></i></th>
															<th><i class="fa fa-ban"></i></th>
														</tr>
													</thead>
												</table><!-- /table -->
											</div>
										  </div>
										</div>
									</div>
								</div>
							</div> <!-- /panel-body -->
					</div> <!-- /panel -->	
					</div>
				</div>
			</div>
		</div>
	</div><!-- page-content" -->
	<!-- Picture Modal -->
	<div id="picModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form action="<?php echo ADMIN_URL; ?>/action_upload.php" method="post" id="uploadImage">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-image'></i> Add Photo</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Image* <small>(Only .jpeg, .jpg, .png & .gif allowed, 10 MB Allowed)</small></label>
									<input type="file" name="uploadFile" id="uploadFile" class="form-control" required/>
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
								<label>Caption <small>(Optional : Max Length = 100)</small></label>
									<input type="text" name="caption" id="caption" class="form-control" maxlength="100"/>
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
								<div class="progress">
									<div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div id="targetLayer"></div>
							</div>
						</div>						
					</div>
					<div class="modal-footer">
    					<input type="submit" name="action_pic" id="action_pic" class="action_pic btn btn-success" value="Upload"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	<!-- Replace Picture Modal -->
	<div id="replacepicModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form action="<?php echo ADMIN_URL; ?>/action_upload_replace.php" method="post" id="uploadReplaceImage">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-image'></i> Replace Photo or Caption</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
									<label>Image* <small>(Only .jpeg, .jpg, .png & .gif allowed, 10 MB Allowed)</small></label>
									<input type="file" name="uploadReplaceFile" id="uploadReplaceFile" class="form-control"/>
								</div>
							</div>
							<div class="col-lg-12 col-md-12">
							<span class="viewReplaceImage"></span>
							</div>
							
							<div class="col-lg-12 col-md-12">
								<div class="progress">
									<div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<div id="targetLayer"></div>
							</div>
						</div>						
					</div>
					<div class="modal-footer">
						<small>Click On Photo to View</small>
						<input type="hidden" name="pid" id="pid" >
    					<input type="submit" name="action_pic_replace" id="action_pic_replace" class="action_pic_replace btn btn-success" value="Replace"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
	<!-- View Picture Modal -->
	<div id="viewpicModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-image'></i> Photo</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row text-center">
							<div class="col-lg-12 col-md-12">
								<span class="myImage"></span>
							</div>
						</div>						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    	</div>
    </div>
	<!-- Caption Modal -->
	<div id="editcaptionModal" class="modal fade " data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog">
    		<form method="post" id="captionImage">
    			<div class="modal-content">
    				<div class="modal-header">
						<h4 class="modal-title"><i class='fa fa-pencil-alt'></i> Edit Caption</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
    				</div>
    				<div class="modal-body">
						<div class="row">
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
								<label>Caption* <small>(Max Length = 100)</small></label>
									<input type="text" name="caption" id="editcaption" class="form-control" maxlength="100" required/>
								</div>
							</div>
						</div>						
					</div>
					<div class="modal-footer">
						<input type="hidden" name="imgId" id="imgId">
						<input type="hidden" name="btn_action_cap" id="btn_action_cap" value="Submit">
    					<input type="submit" name="action_cap" id="action_cap" class="action_cap btn btn-success" value="Edit"  />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>
<?php include("footer.php") ; ?>