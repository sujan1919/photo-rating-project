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
$Statement = $pdo->prepare("SELECT ot_rating.id as ID, image_id, user_ip, user_rating, img_name FROM ot_rating left join ot_image on (ot_image.id = ot_rating.image_id) WHERE 1 order by ot_rating.id desc");
$Statement->execute(); 
$total = $Statement->rowCount();    
$result = $Statement->fetchAll(PDO::FETCH_ASSOC); 
$sum = 0;
$country = "Localhost";
$output = array('data' => array());
if($total > 0) {
	$statuss = "";
	foreach($result as $row) {
		$sum = $sum + 1;
		$id = _e($row['ID']);
		$img_name = _e($row['img_name']);
		$ip = _e($row['user_ip']);
		$image_id = _e($row['image_id']);
		$rating = _e($row['user_rating']);
		
		$ipInfo = grabIpInfo($ip);
        $ipJsonInfo = json_decode($ipInfo);
		if(isset($ipJsonInfo)){
        	$country = $ipJsonInfo->name;
		}
		$editPic = '<button type="button" name="editRating" id="'.$id.'" class="btn btn-default btn-sm editRating" data-status="'.$rating.'"><i class="fa fa-pencil-alt"></i></button>';
		$viewPic = '<button type="button" name="viewPic" id="'.$image_id.'" class="btn btn-default btn-sm viewPic"><i class="fa fa-eye"></i></button>';
		$output['data'][] = array( 		
		$sum,
		$ip,
		$country,
		$rating,
		$viewPic,
		$editPic	
		); 	
	}
}
echo json_encode($output);

function grabIpInfo($ip)
{

  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, "https://api.ipgeolocationapi.com/geolocate/" . $ip);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

  $returnData = curl_exec($curl);

  curl_close($curl);

  return $returnData;

}
?>
