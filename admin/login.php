<?php
ob_start();
session_start();
require_once("db/config.php");
require_once("db/function_xss.php");
require_once("db/CSRF_Protect.php");
$csrf = new CSRF_Protect();
if( !empty($_POST['email']) && !empty($_POST['password']) ){
	$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) ;
	$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING) ;
	$userAuthentication =  $pdo->prepare("SELECT * FROM ot_admin WHERE adm_email=?");
	$userAuthentication->execute(array($email));
	$user_ok = $userAuthentication->rowCount();
	$userData = $userAuthentication->fetchAll(PDO::FETCH_ASSOC);
	if($user_ok > 0) {
		foreach($userData as $row){
			$auth_pass = _e($row['adm_password']) ;
		}
			if(password_verify($password, $auth_pass)) {
				$_SESSION['admin'] = $row ;
				header("location: ".ADMIN_URL."/dashboard.php");
			} else {
				$_SESSION['error_message'] = 'Either wrong Email or Password. Try Again.';
				header("location: ".ADMIN_URL."/index.php");
			}
	}
	else {
		$_SESSION['error_message'] = 'Either wrong Email or Password. Try Again.';
		header("location: ".ADMIN_URL."/index.php");
	}

} else {
	$_SESSION['error_message'] = 'Email/Password cannot be empty.';
	header("location: ".ADMIN_URL."/index.php");
}
?>