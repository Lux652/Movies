<?php
include "connection.php";
session_start();

$sPostData = file_get_contents("php://input");
$oPostData = json_decode($sPostData);
$sActionID= $oPostData->action_id;
if(isset($_POST['action_id']))
{
    $sActionID=$_POST['action_id'];
}


switch($sActionID)
{
	case 'login':
	$Username = $oPostData->username;
	$Password = $oPostData->password;
	
	$sQuery = "SELECT * FROM user WHERE username='$Username' AND password='$Password'";
	$oRecord = $oConnection->query($sQuery);
	$row = $oRecord->fetch();
	$count = $oRecord->rowCount();

	if( $count>0 )
	{
		$_SESSION['userID']=$row['id'];
		$_SESSION['username']=$row['username'];
		echo json_encode(array(
			"status" => 1,
			"user_id" =>$_SESSION['userID']
		));
	}
	else
	{
		echo json_encode(array(
			"status" => 0
		));
	}
	break;


	case 'register':
	$Username = $oPostData->username;
	$Password = $oPostData->password;
	$FirstName=$oPostData->firstname;
	$LastName=$oPostData->lastname;
	$Email=$oPostData->email;
	$sQuery = "INSERT INTO user (firstname, lastname, username, password, email) VALUES (:firstname, :lastname, :username, :password, :email)";
	$oStatement = $oConnection->prepare($sQuery);
	$oData = array(
		'firstname' => $FirstName,
		'lastname' => $LastName,
		'username' => $Username,
		'password' => $Password,
		'email' => $Email
	);
	try
	{
		//$oStatement=$oConnection->prepare($sQuery);
		$oStatement->execute($oData);
		echo 1;
	}
	catch(PDOException $error)
	{
		echo $error;
		echo 0;
	}
	break;

	case 'add_movie':
	$Title = $oPostData->Title;
	$Poster = $oPostData->Poster;
	$Rating=$oPostData->Rating;
	$UserRating=$oPostData->UserRating;
	$User_ID=$_SESSION['userID'];

	$sQuery = "INSERT INTO movie (title, poster, rating, user_id, user_rating) VALUES (:title, :poster, :rating, :user_id, :user_rating)";
	$oStatement = $oConnection->prepare($sQuery);
	$oData = array(
		'title' => $Title,
		'poster' => $Poster,
		'rating' => $Rating,
		'user_id' => $User_ID,
		'user_rating'=> $UserRating
	);
	try
	{
		$oStatement->execute($oData);
		echo 1;
	}
	catch(PDOException $error)
	{
		echo $error;
		echo 0;
	}
	break;


	case 'logout':
		session_destroy();
	break;
	case 'check_logged_in':
	if(isset($_SESSION['userID'])){
		echo json_encode(array(
			"status" => 1,
			"user_id" => $_SESSION['userID']
		));
	}
	else{
		echo json_encode(array(
			"status" => 0
		));
	}
	break;
}
?>