<?php
function _e($string) {
	return htmlentities(strip_tags($string), ENT_QUOTES, 'UTF-8');
}
function count_darkmode($pdo)
{	
	$query = "SELECT * FROM ot_admin WHERE dark_mode ='0'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}

function count_total_photos($pdo)
{	
	$query = "SELECT * FROM ot_image WHERE 1";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_active_photos($pdo)
{	
	$query = "SELECT * FROM ot_image WHERE img_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_deactive_photos($pdo)
{	
	$query = "SELECT * FROM ot_image WHERE img_status='0'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	return _e($total) ;
	
}
function count_total_avg_rating($pdo)
{	
	$query = "SELECT sum(img_count_people) as People , sum(img_rate) as Rate FROM ot_image WHERE img_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$avgRating = 0 ;
	if($total > 0) {
		foreach($result as $row) {
			$people = _e($row['People']) ;
			$rate = _e($row['Rate']) ;
		} 
		if(!empty($rate)) {
			$avgRating = number_format($rate/$people,2) ;
		} else {
			$avgRating = 0 ;
		}
		return _e($avgRating) ; 
	} else {
		return _e($avgRating) ; 
	}
	
}
function count_total_people($pdo)
{	
	$query = "SELECT sum(img_count_people) as People FROM ot_image WHERE img_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$people = 0 ;
	if($total > 0) {
		foreach($result as $row) {
			$people = _e($row['People']) ;
		}
		if(!empty($people)) {
			return _e($people) ; 
		} else {
			return 0 ;
		}
	} else {
		return _e($people) ; 
	}
	
}
function count_total_stars($pdo)
{	
	$query = "SELECT sum(img_rate) as Rate FROM ot_image WHERE img_status='1'";
	$statement = $pdo->prepare($query);
	$statement->execute();
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	$stars = 0 ;
	if($total > 0) {
		foreach($result as $row) {
			$stars = _e($row['Rate']) ;
		}
		if(!empty($stars)) {
			return _e($stars) ;
		} else {
			return 0;
		} 
	} else {
		return _e($stars) ; 
	}
	
}

?>