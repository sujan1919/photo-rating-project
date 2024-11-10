<?php include("header.php") ; ?>
<div class="container mar-top">
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="row">
				<div class="col-lg-3 col-md-3"></div>
				<div class="col-lg-6 col-md-6">
					<div class="card">
                		<div class="card-header bg-secondary text-white text-center"><h4> Set Limits of Announcements.</h4></div>
                		<div class="card-body">
							<form method="post" id="limit_validation" class="limit_validation">
								<div class="form-group">
									<label> Dark Mode for Users*</label>
									<select class="form-control" name="darkMode" id="darkMode" required>
									<option value="1" <?php if($darkMode == '1'){ echo $sub = 'selected = "selected" ' ; } else { echo $sub = '' ; } ?> >On</option>
									<option value="0" <?php if($darkMode == '0'){ echo $sub = 'selected = "selected" ' ; } else { echo $sub = '' ; } ?> >Off</option>
									</select>
								</div>
								<div class="form-group">
									<label for="startLimit"> How much No. of Images Show By Default*</label>
									<input type="number" class="form-control" name="startLimit" id="startLimit" min="2" max="15" value="<?php echo $startLimit ; ?>" required>
								</div>
								<div class="form-group">
									<label for="loadLimit">How much No. of Image Show after Load More Button Press*</label>
									<input type="number" class="form-control" name="loadLimit" id="loadLimit" min="2" max="15" value="<?php echo $loadLimit ; ?>" required>
								</div>
								<div class="col-md-12 text-center">
									<div class="remove-messages"></div>
								<input type="hidden" name="limit_submit_pr" value="Submit" />
								<input type="submit" id="limit_submit" name="limit_submit" class="btn btn-primary text-center form_submit" value="Save Changes" />
								</div>
							</form>
                		</div>
           			 </div>
				</div>
				<div class="col-lg-3 col-md-3"></div>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php") ; ?>