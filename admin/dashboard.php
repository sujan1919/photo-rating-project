<?php include("header.php") ; ?>

<div class="app-title">
        <div>
          <h1><i class="fa fa-laptop"></i> Dashboard Analysis</h1>
          <p>Rating Analysis only on Active Photos. </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        </ul>
 </div>
 <div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Photo Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-image fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Photos</h5>
              <p><b><?php echo count_total_photos($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-check fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Active Photos</h5>
              <p><b><?php echo  count_total_active_photos($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small danger coloured-icon"><i class="icon fa fa-times fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Deactive Photos</h5>
              <p><b><?php echo count_total_deactive_photos($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
</div>
<div class="row">
 		<div class="col-lg-12 col-md-12">
				<h5 class="border-bottom text-muted">Rating Analysis</h5>
			</div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small warning coloured-icon"><i class="icon fa fa-star fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Average Rating</h5>
              <p><b><?php echo count_total_avg_rating($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-lg-4">
          <div class="widget-small info coloured-icon"><i class="icon fa fa-users fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Rated By</h5>
              <p><b><?php echo count_total_people($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4">
          <div class="widget-small primary coloured-icon"><i class="icon fa fa-list-ol fa-3x"></i>
            <div class="info">
              <h5 class="font-italic text-muted">Total Stars</h5>
              <p><b><?php echo count_total_stars($pdo) ; ?></b></p>
            </div>
          </div>
        </div>
        
      </div>

<?php include("footer.php") ; ?>