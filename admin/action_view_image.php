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
if(isset($_POST['btn_action_view']))
{
	if($_POST['btn_action_view'] === 'fetch_image')
	{
		if( isset($_POST['picId'])){
			$picId = filter_var($_POST['picId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_image = $pdo->prepare("select * from ot_image where id = ?");
			$fetch_image->execute(array($picId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			$output = '';
			foreach($imageData as $row) {
				$image_name = _e($row['img_name']) ;
				$caption = _e($row['img_caption']) ;
			}
			$output = '<a href="'.ADMIN_URL.'/upload/'.$image_name.'" class="spotlight" data-title="'.$caption.'"><img src="'.ADMIN_URL.'/upload/'.$image_name.'" class="img-fluid cur img-h" ></a>' ;
			echo ($output);
		}
	}
	if($_POST['btn_action_view'] === 'fetch_replace_image')
	{
		if( isset($_POST['picId'])){
			$picId = filter_var($_POST['picId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_image = $pdo->prepare("select * from ot_image where id = ?");
			$fetch_image->execute(array($picId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			$output = '';
			foreach($imageData as $row) {
				$image_name = _e($row['img_name']) ;
				$caption = _e($row['img_caption']) ;
			}
			$output = '<div class="row"><div class="col-lg-12 col-md-12"><div class="form-group"><label>Caption <small>(Optional : Max Length = 100)</small></label><input type="text" name="caption" id="caption" class="form-control" maxlength="100" value="'.$caption.'"/></div></div><div class="col-lg-12 col-md-12 text-center"><a href="'.ADMIN_URL.'/upload/'.$image_name.'" class="spotlight" data-title="'.$caption.'"><img src="'.ADMIN_URL.'/upload/'.$image_name.'" class="img-fluid cur img-h" ></a></div></div>' ;
			echo ($output);
		}
	}
	if($_POST['btn_action_view'] === 'changePicStatus')
	{
		if( isset($_POST['picId'])){
			$picId = filter_var($_POST['picId'], FILTER_SANITIZE_NUMBER_INT) ;
			$status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT) ;
			if($picId) { 
				$update = $pdo->prepare("UPDATE ot_image SET img_status=?   WHERE id=?");
				$result_new = $update->execute(array($status,$picId));
				if($result_new) {
					echo 'Success : Photo status changed.' ;		
				}
			}
		}
	}
	if($_POST['btn_action_view'] === 'fetch_caption')
	{
		if( isset($_POST['picId'])){
			$picId = filter_var($_POST['picId'], FILTER_SANITIZE_NUMBER_INT) ;
			$fetch_image = $pdo->prepare("select * from ot_image where id = ?");
			$fetch_image->execute(array($picId));
			$imageData = $fetch_image->fetchAll(PDO::FETCH_ASSOC);
			foreach($imageData as $row) {
				$output['picId'] = _e($row['id']);
				$output['caption'] = _e($row['img_caption']) ;
			}
			echo json_encode($output);
		}
	}
}
?>