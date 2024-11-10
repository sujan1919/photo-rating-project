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
if(isset($_POST['btn_action_sb']))
{
	if($_POST['btn_action_sb'] == 'Submit')
	{
		if( isset($_POST['subRate']) && isset($_POST['rating']) && isset($_POST['pId']) ){
			$rating = filter_var($_POST['rating'], FILTER_SANITIZE_NUMBER_INT) ;
			$pId = filter_var($_POST['pId'], FILTER_SANITIZE_NUMBER_INT) ;
			$subRate = filter_var($_POST['subRate'], FILTER_SANITIZE_NUMBER_INT) ;
			
			$imgStatement = $pdo->prepare("select image_id from ot_rating where id = '".$pId."'") ;
			$imgStatement->execute();
			$imageFetch = $imgStatement->fetchAll(PDO::FETCH_ASSOC);
			foreach($imageFetch as $img) {
				$imageId = _e($img['image_id']) ;
			}
			
			$upd = $pdo->prepare("update ot_rating set user_rating = '".$subRate."' where id = '".$pId."'");
			$upd->execute() ;
			
			$fetch_image = $pdo->prepare("select img_count_people, img_rate, img_total_rating from ot_image where id = ?");
			$fetch_image->execute(array($imageId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			foreach($imageData as $row) {
				$people = _e($row['img_count_people']) ;
				$rate = _e($row['img_rate']);
				$ratingOld = _e($row['img_total_rating']);
			}
			$newTotalRating = $rate - $rating ;
			$newTotalRating = $newTotalRating + $subRate ;
			
			$newRating = _e(number_format($newTotalRating/$people,2)) ; 
			
			//Save New Rating into Database
			$statement = $pdo->prepare("update ot_image set  img_rate = '".$newTotalRating."' , img_total_rating = '".$newRating."' where id = '".$imageId."'") ;
			$statement->execute();
			echo "Rating Edited Successfully.";
		}
	} else {
		echo "Error in Submit. Try Again." ;
	}
}
?>