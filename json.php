<?php
session_start();
header('Content-type: text/json');
header('Content-type: application/json; charset=utf-8');
include "connection.php";

$sJsonID="";
$user_id="";
$title="";


if(isset($_GET['json_id']))
{
	$sJsonID=$_GET['json_id'];
}
if(isset($_GET['user_id']))
{
	$user_id=$_GET['user_id'];
}
if(isset($_GET['title']))
{
    $title=$_GET['title'];
}

$oJson=array();
switch($sJsonID)
{
	case 'myMovies':
	$User_ID=$_SESSION['userID'];
	$sQuery="SELECT * FROM movie WHERE user_id=$User_ID";
	$oRecord=$oConnection->query($sQuery);
	
	while($oRow=$oRecord->fetch(PDO::FETCH_BOTH))
	{
		$oSaved_movie=new saved_Movie(
				$oRow['id'],
				$oRow['title'],
				$oRow['rating'],
				$oRow['poster'],
				$oRow['user_id'],
				$oRow['user_rating']
			);
		array_push($oJson,$oSaved_movie);
	}
	break;

	case 'get_movies':
			$sCurloptUrl="http://api.themoviedb.org/3/movie/popular?page=1&language=en-US&api_key=9aac4d1664cdcf018243622a66c90bf9";
			$headers=['Content-Type: application/json'];
			$curl = curl_init();
			curl_setopt_array($curl,array(
			CURLOPT_RETURNTRANSFER=>1,
			CURLOPT_HTTPGET=>true,
			CURLOPT_SAFE_UPLOAD=>true,
			CURLOPT_HTTPHEADER=>$headers,
			CURLOPT_URL=>$sCurloptUrl
			));
			$oResponse=curl_exec($curl);
			curl_close($curl);
			$oResponse=json_decode($oResponse, true);
			 foreach($oResponse['results'] as $oFilmovi)
			 {
				$oJson[]=new Movie(
					$oFilmovi['id'],
					$oFilmovi['title'],
					$oFilmovi['vote_average'],
					$oFilmovi['poster_path']
				);
			 }		
	break;
	// $sCurloptUrl='https://api.themoviedb.org/3/search/movie?include_adult=false&page=1&query=batman&language=en-US&api_key=9aac4d1664cdcf018243622a66c90bf9';
	case 'search_movies':
			$sCurloptUrl='http://api.themoviedb.org/3/search/movie?include_adult=false&page=1&query='.rawurlencode($title).'&language=en-US&api_key=9aac4d1664cdcf018243622a66c90bf9';
			$headers=['Content-Type: application/json'];
			$curl = curl_init();
			curl_setopt_array($curl,array(
			CURLOPT_RETURNTRANSFER=>1,
			CURLOPT_HTTPGET=>true,
			CURLOPT_SAFE_UPLOAD=>true,
			CURLOPT_HTTPHEADER=>$headers,
			CURLOPT_URL=>$sCurloptUrl
			));
			$oResponse=curl_exec($curl);
			curl_close($curl);
			$oResponse=json_decode($oResponse, true);
			 foreach($oResponse['results'] as $oFilmovi)
			 {
				$oJson[]=new Movie(
					$oFilmovi['id'],
					$oFilmovi['title'],
					$oFilmovi['vote_average'],
					$oFilmovi['poster_path']
				);
			 }		
	break;
}
echo json_encode($oJson);
?>