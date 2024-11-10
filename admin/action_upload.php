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

if(!empty($_FILES['uploadFile']))
{
	$targetDir = "upload/"; 
	$allowTypes = array('gif', 'jpg', 'png', 'jpeg'); 
	$fileName = filter_var($_FILES["uploadFile"]["name"], FILTER_SANITIZE_STRING) ;
	$temp = explode(".", $fileName);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	$targetFilePath = $targetDir.$newfilename; 
	// Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
	$tmpFileName = filter_var($_FILES["uploadFile"]["tmp_name"], FILTER_SANITIZE_STRING) ;
	$date = filter_var(date("Y-m-d"), FILTER_SANITIZE_STRING) ;
	$caption = filter_var($_POST['caption'], FILTER_SANITIZE_STRING) ;
	if(in_array($fileType, $allowTypes)){ 
        // Upload file to the server 
        if(move_uploaded_file($tmpFileName , $targetFilePath)){ 
			$upd = $pdo->prepare("insert into ot_image (img_caption, img_name, img_date) values ('".$caption."','".$newfilename."','".$date."')");
			$upd->execute();
        } 
    } 
}

?>