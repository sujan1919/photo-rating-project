<?php

include("db/config.php");
include("db/function_xss.php");

if(isset($_POST['btn_action_view']))
{
	if($_POST['btn_action_view'] === 'fetch_data')
	{
		if( isset($_POST['picId'])){
			$picId = filter_var($_POST['picId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_image = $pdo->prepare("select * from ot_image where id = ?");
			$fetch_image->execute(array($picId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			
			$rating = 0 ;
			foreach($imageData as $row) {
				$people = _e($row['img_count_people']) ;
				$rate = _e($row['img_rate']);
				if($rate != 0) {
					$rating = _e(number_format($rate/$people,2)) ;
				}
				$output['imageId'] = _e($row['id']) ;
				$output['people'] = _e($people) ;
				$output['rate'] = _e($rate) ;
			}
			
			echo json_encode($output);
		}
	}
}
?>