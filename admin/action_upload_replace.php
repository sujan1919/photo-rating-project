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

if(!empty($_POST['pid']) && !empty($_FILES['uploadReplaceFile']))
{
	$imgId = filter_var($_POST['pid'], FILTER_SANITIZE_NUMBER_INT) ;
	$caption = filter_var($_POST['caption'], FILTER_SANITIZE_STRING) ;
	$statement = $pdo->prepare("select img_name from ot_image where id = '".$imgId."'");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row) {
		$image_name = _e($row['img_name']) ;
	} 
	$targetDir = "upload/"; 
	
	$allowTypes = array('gif', 'jpg', 'png', 'jpeg'); 
	$fileName = filter_var($_FILES["uploadReplaceFile"]["name"], FILTER_SANITIZE_STRING) ;
	$temp = explode(".", $fileName);
	$newfilename = round(microtime(true)) . '.' . end($temp);
	$targetFilePath = $targetDir.$newfilename; 
	// Check whether file type is valid 
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
	$tmpFileName = filter_var($_FILES["uploadReplaceFile"]["tmp_name"], FILTER_SANITIZE_STRING) ;
	if(in_array($fileType, $allowTypes)){ 
		//delete old image
		unlink($targetDir.$image_name);
        // Upload file to the server 
        if(move_uploaded_file($tmpFileName , $targetFilePath)){ 
			$upd = $pdo->prepare("update ot_image set img_caption = '".$caption."' , img_name = '".$newfilename."' where id = '".$imgId."'");
			$upd->execute();
        } 
    } 
} 

?>