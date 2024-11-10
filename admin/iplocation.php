<?php include("header.php") ; ?>
<div class="app-title">
        <div>
          <h1><i class="fa fa-globe"></i> IP Locations</h1>
          <p>Edit the Rating of Photo.</p>
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
								<div class="page-heading"> <h6>Edit Rating</h6></div>
							</div> <!-- /panel-heading -->
							<div class="panel-body">
								<div class="remove-messages"></div>
								<div class="row">
									<div class="col-md-12">
									  <div class="tile">
										<div class="tile-body">
										  <div class="table-responsive">
											<div class="table-responsive">
												<table class="table table-bordered table-hover" id="manageIpTable">
													<thead>
														<tr>
															<th>S.No.</th>
															<th>IP</th>	
															<th>Country</th>
															<th>Rating</th>
															<th><i class="fa fa-eye"></i></th>
															<th><i class="fa fa-pencil-alt"></i></th>
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
	<!-- Rating Modal -->
<div id="editratingModal" class="modal fade ratingModal">
	<div class="modal-dialog">
		<form method="post" class="editrating_form">
			<div class="modal-content">
				<div class="modal-header ">
					<h4 class="modal-title text-muted"><i class="fa fa-star text-warning"></i> Rate Now !</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group mb-3">
						<div class="form-check form-check-inline">
						
						  <input class="form-check-input" type="radio" name="subRate" id="subRate"  value="1"  required >
						  <label class="form-check-label">1 <img src="<?php echo ADMIN_URL ; ?>/images/1star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate" id="subRate"  value="2" required>
						  <label class="form-check-label">2 <img src="<?php echo ADMIN_URL ; ?>/images/2star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate" id="subRate" value="3" required>
						  <label class="form-check-label">3 <img src="<?php echo ADMIN_URL ; ?>/images/3star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate" id="subRate" value="4" required>
						  <label class="form-check-label">4 <img src="<?php echo ADMIN_URL ; ?>/images/4star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate" id="subRate" value="5" required >
						  <label class="form-check-label">5 <img src="<?php echo ADMIN_URL ; ?>/images/5star.png" class="img-fluid"></label>
						</div>
					</div> 
					<div class="remove-messages"></div>
				</div> 
				<div class="modal-footer"> 
					<input type="hidden" name="rating" id="rating" />
					<input type="hidden" name="pId" id="pId" />
					<input type="hidden" name="btn_action_sb" id="btn_action_sb" value="Submit" />
					<span class="oldRating text-muted"></span>
					<input type="submit" name="action_sb" id="action_sb" class="btn btn-success" value="Submit Rating" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>
<?php include("footer.php") ; ?>