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
if(isset($_POST['btn_action_cap']))
{
	if($_POST['btn_action_cap'] === 'Submit')
	{
		if(!empty($_POST['imgId']) && !empty($_POST['caption']) ){
			$imageId = filter_var($_POST['imgId'], FILTER_SANITIZE_NUMBER_INT) ;
			$caption = filter_var($_POST['caption'], FILTER_SANITIZE_STRING) ;
			$ins = $pdo->prepare("update ot_image set img_caption = '".$caption."' where id = '".$imageId."'");
			$ins->execute();
			if($ins) {
				echo "Caption Edited Successfully";
			} else {
				echo "Error : Caption cannot be Empty.";
			}
		}
	}
}
?>