<?php

include("db/config.php");
include("db/function_xss.php");

if(isset($_POST['btn_action_sb']))
{
	if($_POST['btn_action_sb'] == 'Submit')
	{
		if( isset($_POST['subRate']) && isset($_POST['userip']) && isset($_POST['imageId']) ){
			$imageId = filter_var($_POST['imageId'], FILTER_SANITIZE_NUMBER_INT) ;
			$userip = filter_var($_POST['userip'], FILTER_VALIDATE_IP) ;
			$subRate = filter_var($_POST['subRate'], FILTER_SANITIZE_NUMBER_INT) ;
			
			//Save User IP Address into Database
			$ins = $pdo->prepare("insert into ot_rating (image_id, user_ip, user_rating) values('".$imageId."', '".$userip."', '".$subRate."')");
			$ins->execute() ;
			
			$fetch_image = $pdo->prepare("select * from ot_image where id = ?");
			$fetch_image->execute(array($imageId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			foreach($imageData as $row) {
				$people = _e($row['img_count_people']) ;
				$rate = _e($row['img_rate']);
			}
			$people = $people + 1 ;
			$rate = $rate + $subRate ;
			$rating = _e(number_format($rate/$people,2)) ; 
			
			//Save New Rating into Database
			$statement = $pdo->prepare("update ot_image set img_count_people = '".$people."' , img_rate = '".$rate."' , img_total_rating = '".$rating."' where id = '".$imageId."'") ;
			$statement->execute();
			$output = '';
			$output = array( 
							'imageId' => $imageId,
							'rating' => $rating,
							'people' => $people
							) ;
			echo json_encode($output);
		}
	} else {
		echo "Error in Submit. Try Again." ;
	}
}
?>