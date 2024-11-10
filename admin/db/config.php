<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Host Name
$dbhost = 'YOUR_DATABASE_HOSTNAME' ;

// Database Name
$dbname = 'YOUR_DATABASE_NAME' ;

// Database Username
$dbuser = 'YOUR_DATABASE_USERNAME' ;

// Database Password
$dbpass = 'YOUR_DATABASE_PASSWORD' ;

// Defining base url , replace https://www.yourwebsite.com/ with your website name
// Whatever your folder name just replace payment/ with yourfoldername/ , Note : put forward slash / at the end of your folder name otherwise script won't work. 
//if you want to put inside your root directory without any folder then your Base URL is https://www.yourwebsite.com/
define("BASE_URL", "https://www.yourwebsite.com/folder_name/");

// Defining Admin url Note : Do not change this otherwise script won't work.
define("ADMIN_URL", BASE_URL . "admin");

try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}
?>