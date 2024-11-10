<?php
ob_start();
session_start();
include("db/config.php");
include("db/function_xss.php");
// Checking Admin is logged in or not
if( empty($_SESSION['admin']['id'])  ){
	header('location: '.ADMIN_URL.'/index.php');
	exit;
}
$Statement = $pdo->prepare("SELECT * FROM ot_image WHERE 1 order by id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$sum = 0;
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1;
		$id = _e($row['id']);
		$img_name = _e($row['img_name']);
		$caption = _e($row['img_caption']);
		$date = _e($row['img_date']);
		$date =  date('d F, Y',strtotime($date));
		$statuss = _e($row['img_status']);
		$people = _e($row['img_count_people']);
		$rate = _e($row['img_rate']);
		if($rate == '0') {
			$rating = '0' ;
		} else {
			$rating = number_format($rate/$people,2) ;
		}
		if($statuss == 1) {
			// Deactivate Image
			$statuss = "<b>Active</b>";
			$myLink = '<button type="button" name="changePicStatus" id="'.$id.'" class="btn btn-danger btn-sm changePicStatus" data-status="0"><i class="fa fa-ban"></i></button>';
			
		} else {
			// Activate Image
			$statuss = "Not Active";
			$myLink = '<button type="button" name="changePicStatus" id="'.$id.'" class="btn btn-success btn-sm changePicStatus" data-status="1"><i class="fa fa-check-circle"></i></button>';
			
		}
		$editPic = '<button type="button" name="editPic" id="'.$id.'" class="btn btn-default btn-sm editPic"><i class="fa fa-pencil-alt"></i></button>';
		$viewPic = '<button type="button" name="viewPic" id="'.$id.'" class="btn btn-default btn-sm viewPic"><i class="fa fa-eye"></i></button>';
		$editCaption = '<button type="button" name="editCaption" id="'.$id.'" class="btn btn-default btn-sm editCaption"><i class="fa fa-file text-muted"></i></button>';
		$output['data'][] = array( 		
		$sum,
		$date,
		$caption,
		$people,
		$rating,
		$statuss,
		$editCaption,
		$viewPic,
		$editPic,
		$myLink		
		); 	
	}
}
echo json_encode($output);
?>