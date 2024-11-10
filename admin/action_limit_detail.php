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
if($_POST['limit_submit_pr']){
	if($_POST['limit_submit_pr'] == 'Submit') {
		$startLimit = filter_var($_POST['startLimit'], FILTER_SANITIZE_NUMBER_INT) ;
		$loadLimit = filter_var($_POST['loadLimit'], FILTER_SANITIZE_NUMBER_INT) ;
		$darkMode = filter_var($_POST['darkMode'], FILTER_SANITIZE_NUMBER_INT) ;
		$statement = $pdo->prepare("update ot_admin set start_lim = '".$startLimit."' , load_lim = '".$loadLimit."' , dark_mode='".$darkMode."' where id = '1'");
		$statement->execute() ;
		$form_message = "Settings Updated Successfully.";
		$output = array( 
						'form_message' => $form_message,
						'startLimit' => $startLimit,
						'loadLimit' => $loadLimit,
						'darkMode' => $darkMode
					) ;
		echo json_encode($output);
		
	}
} 
?>
