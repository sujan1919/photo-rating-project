<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0"); 
require_once('db/config.php') ;
require_once('db/function_xss.php') ;
if(!empty($_POST["id"])){
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
$limitsql = "SELECT start_lim,load_lim FROM ot_admin WHERE id = '1'" ;
$limit_statement = $pdo->prepare($limitsql);
$limit_statement->execute(); 
$limitF = $limit_statement->fetchAll(PDO::FETCH_ASSOC);
foreach($limitF as $lim) {
	$startLimit = _e($lim['start_lim']);
	$loadLimit = _e($lim['load_lim']);
}
$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ip = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP);
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ip = filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP);
} else {
	$ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
}
$sql = "SELECT count(*) as number_rows FROM ot_image WHERE img_status='1' and id < ".$id." order by id desc " ;
$admin_post = $pdo->prepare($sql);
$admin_post->execute(); 
$post_fetch = $admin_post->fetchAll(PDO::FETCH_ASSOC);
foreach($post_fetch as $row) {
	$totalRows = _e($row['number_rows']);
}
$statement = $pdo->prepare("select * from ot_image WHERE img_status='1' and id < ".$id." order by id desc Limit ".$loadLimit."");
$statement->execute();
$total = $statement->rowCount();
$image = $statement->fetchAll(PDO::FETCH_ASSOC);
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
				<span class="star<?php echo $Id ; ?> <?php echo $color ; ?>">
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
<?php if($totalRows > $loadLimit){ ?>
	<div class="show_more_new" id="show_more_new<?php echo $Id; ?>">
		<div class="col text-center p-2">
			<div id="loader-icon"><img src="<?php echo BASE_URL ; ?>admin/images/loader.gif" class="img-fluid img-loader" /></div>
			<button id="<?php echo $Id; ?>" class="show_more btn <?php echo $btn ; ?> <?php echo $border ; ?> btn-sm" >Load More</button>
		</div>
	</div>
<?php
	} else {
?>
		<div class="col text-center p-2"><button  class="disabled btn btn-danger btn-sm <?php echo $border ; ?>" >No More Images</button></div>
<?php
	}
}
?>

