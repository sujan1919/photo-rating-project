<?php
require_once("admin/db/config.php");
require_once("admin/db/function_xss.php");
$limitsql = "SELECT start_lim,load_lim FROM ot_admin WHERE id = '1'" ;
$limit_statement = $pdo->prepare($limitsql);
$limit_statement->execute(); 
$limitF = $limit_statement->fetchAll(PDO::FETCH_ASSOC);
foreach($limitF as $lim) {
	$startLimit = _e($lim['start_lim']);
	$loadLimit = _e($lim['load_lim']);
}
$sql = "SELECT * FROM ot_image WHERE img_status='1' order by id desc LIMIT $startLimit" ;
$image_statement = $pdo->prepare($sql);
$image_statement->execute(); 
$image = $image_statement->fetchAll(PDO::FETCH_ASSOC);
$total = $image_statement->rowCount();
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP);
} else {
	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
}
$darkMode = count_darkmode($pdo) ;
$bg = "";
$color = "text-muted";
$btn = "btn-light";
$border = "";
if($darkMode == '0') {
	$bg = "bg-dark" ;
	$color = "text-white";
	$border = "border border-white";
	$btn = "btn-dark";
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Photo/Image Rating</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<meta name="description" content="Photo/Image Rating">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>admin/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>admin/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>admin/css/custom.css">
	<link rel="icon" href="<?php echo BASE_URL; ?>admin/favicon.png" type="image/png">
</head>

<body class="myColor <?php echo $bg ; ?>">
<!-- Navbar-->
    <header class="app-header justify-content-center"><a href=""><img src="<?php echo BASE_URL; ?>admin/images/siteLogo.png" class="img-fluid" alt="Image Rating"></a>
    </header>
	<div class="container-fluid mt-5">
    	<div class="row">
	  		<div class="col-lg-12 col-md-12">
				<div class="row">
					<div class="col-md-4 col-lg-4"></div>
					<div class="col-md-4 col-lg-4">
						<div class="announce-res mt-3">
						<?php
						foreach($image as $img) {
							$Id = _e($img['id']);
							$image_name = _e($img['img_name']);
							$people = _e($img['img_count_people']);
							$rate = _e($img['img_rate']);
							$date = _e($img['img_date']);
							$date =  date('d F, Y',strtotime($date));
							$caption = _e($img['img_caption']) ;
							$rating = '0';
							if($rate != '0') {
								$rating = _e(number_format($rate/$people,2)) ;
							}
						?>
							<div class="card-deck mb-3 text-center  ">
								<div class="card mb-3 box-shadow basic-my-div shadow-lg <?php echo $bg ; ?> <?php echo $border ; ?>">
									<div class="card-header <?php echo $border ; ?>">
										<h5 class="my-0 font-weight-normal <?php echo $color ; ?>"><?php echo $date ; ?></h5>
									</div>
									<div class="card-body <?php echo $border ; ?>" >
										<a href="<?php echo BASE_URL ; ?>admin/upload/<?php echo $image_name ; ?>" class="spotlight" <?php if(!empty($caption)){ ?>data-title="<?php echo $caption ; ?>" <?php } ?>><img src="<?php echo BASE_URL ; ?>admin/upload/<?php echo $image_name ; ?>" class="img-fluid img-h" ></a>
									</div>
									<div class="card-footer text-muted <?php echo $border ; ?>">
										<?php
										$ip_statement = $pdo->prepare("select * from ot_rating where image_id = ? and user_ip = ?");
										$ip_statement->execute(array($Id,$ip)) ;
										$ratingBefore = $ip_statement->rowCount();
										
										?>
										<span class="star<?php echo $Id ; ?>  <?php echo $color ; ?>">
											<?php 
											if($rating == '0') {
											
												if($ratingBefore == 0){
												?>
												<a href="#!" class="openRating myLink" id="<?php echo $Id ; ?>">
												<img src="<?php echo BASE_URL ; ?>admin/images/blankStar.png" class="img-fluid img-star mt-n1" >
												</a>
												<?php
												} else {
												?>
												<img src="<?php echo BASE_URL ; ?>admin/images/blankStar.png" class="img-fluid img-star mt-n1" >
												<?php
												}
											} else {
											echo $rating ;
												if($ratingBefore == 0){
											?>
												<a href="#!" class="openRating myLink" id="<?php echo $Id ; ?>">
												<img src="<?php echo BASE_URL ; ?>admin/images/fillStar.png" class="img-fluid img-star mt-n1" >
												</a>
												<?php
												} else {
												?>
												<img src="<?php echo BASE_URL ; ?>admin/images/fillStar.png" class="img-fluid img-star mt-n1" >
												<?php
												}
											}
										?>
										<?php
										if($rating != '0') {
											echo "(".$people.")" ;
										}
										
										?>
										</span>
										<span class="<?php echo $color ; ?> newStar<?php echo $Id ; ?>"></span>
									</div>
								</div>
							</div>
							
						<?php
						}
						?>
							<div class="show_more_new" id="show_more_new<?php if(!empty($Id)) {echo $Id;} ?>">
								<div class="col text-center p-2">
									<div id="loader-icon"><img src="<?php echo BASE_URL ; ?>admin/images/loader.gif" class="img-fluid img-loader" /></div>
									<?php if(!empty($Id)) { ?><button id="<?php echo $Id; ?>" class="show_more btn <?php echo $btn ; ?> <?php echo $border ; ?> btn-sm" >Load More</button><?php } ?>
								</div>
							</div>
							</div>
						</div>
					<div class="col-md-4 col-lg-4"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- Rating Modal -->
<div id="ratingModal" class="modal fade ratingModal">
	<div class="modal-dialog">
		<form method="post" class="rating_form">
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
						
						  <input class="form-check-input" type="radio" name="subRate"  value="1" required >
						  <label class="form-check-label">1 <img src="<?php echo BASE_URL ; ?>admin/images/1star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate"  value="2" required>
						  <label class="form-check-label">2 <img src="<?php echo BASE_URL ; ?>admin/images/2star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate"  value="3" required>
						  <label class="form-check-label">3 <img src="<?php echo BASE_URL ; ?>admin/images/3star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate"  value="4" required>
						  <label class="form-check-label">4 <img src="<?php echo BASE_URL ; ?>admin/images/4star.png" class="img-fluid"></label>
						</div>
						<div class="form-check form-check-inline">
						  <input class="form-check-input" type="radio" name="subRate" value="5" required >
						  <label class="form-check-label">5 <img src="<?php echo BASE_URL ; ?>admin/images/5star.png" class="img-fluid"></label>
						</div>
					</div> 
					<div class="remove-messages"></div>
				</div> 
				<div class="modal-footer"> 
					<input type="hidden" name="userip" id="userip"  value="<?php echo $ip ; ?>" />
					<input type="hidden" name="imageId" id="imageId" />
					<input type="hidden" name="btn_action_sb" id="btn_action_sb" value="Submit" />
					<input type="submit" name="action_sb" id="action_sb" class="btn btn-success" value="Submit Rating" />
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="<?php echo BASE_URL; ?>admin/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>admin/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>admin/js/spotlight.bundle.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>admin/js/errorMsg.js"></script>


</body>
</html>
