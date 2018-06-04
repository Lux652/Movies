<?php
include "connection.php";
session_start();

$sPostData = file_get_contents("php://input");
$oPostData = json_decode($sPostData);
$sActionID= $oPostData->action_id;


switch($sActionID)
{
	case 'login':
	$Username = $oPostData->username;
    $Password = $oPostData->password;
	$sQuery = "SELECT * FROM user WHERE username='$Username' AND password='$Password'";
	$oRecord = $oConnection->query($sQuery);
	$row = $oRecord->fetch();
	$count = $oRecord->rowCount();

	$oExportData = array();
	if( $count>0 )
	{
		$oExportData['login_status'] = 1;
		$oExportData['id'] = $row['id'];
		$oExportData['firstname'] = $row['firstname'];
		$oExportData['lastname'] = $row['lastname'];
		$oExportData['username'] = $row['username'];
		$oExportData['email'] = $row['email'];

	}
	else
	{
		$oExportData['login_status'] = 0;
	}

	echo json_encode($oExportData);
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
	$User_ID=$_SESSION['id'];

	var_dump($oPostData);
	$sQuery = "INSERT INTO movie (title, poster, rating, user_id) VALUES (:title, :poster, :rating, :user_id)";
	$oStatement = $oConnection->prepare($sQuery);
	$oData = array(
		'title' => $Title,
		'poster' => $Poster,
		'rating' => $Rating,
		'user_id'=> $User_ID
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

	case 'show_saved_movies':

	break;

	case 'logout':
		session_destroy();
	break;

	case 'check_logged_in':
		if( isset($_SESSION['user']) )
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	break;
}

?>