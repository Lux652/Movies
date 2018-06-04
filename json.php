<?php
header('Content-type: text/json');
header('Content-type: application/json; charset=utf-8');
include "connection.php";

$sJsonID="";
$user_id="";

if(isset($_GET['json_id']))
{
	$sJsonID=$_GET['json_id'];
}
if(isset($_GET['user_id']))
{
	$user_id=$_GET['user_id'];
}

if(isset($_GET['movie_id']))
{
	$movie_id=$_GET['movie_id'];
}

$oJson=array();
switch($sJsonID)
{
	case 'get_all_users':
		$sQuery="SELECT * FROM user";
		$oRecord=$oConnection->query($sQuery);
		
		while($oRow=$oRecord->fetch(PDO::FETCH_BOTH))
		{
			$oUser=new User(
					$oRow['id'],
					$oRow['username'],
					$oRow['password'],
					$oRow['firstname'],
					$oRow['lastname'],
					$oRow['email']
				);
			array_push($oJson,$oUser);
		}
		break;

	case 'get_saved_movies':
	$sQuery="SELECT * FROM saved_movies";
	$oRecord=$oConnection->query($sQuery);
	
	while($oRow=$oRecord->fetch(PDO::FETCH_BOTH))
	{
		$oSaved_movie=new saved_Movie(
				$oRow['ID'],
				$oRow['Title'],
				$oRow['Genre'],
				$oRow['Rating'],
				$oRow['Poster'],
				$oRow['user_ID'],
				$oRow['omdb_ID'],
				$oRow['omdb_Rating']
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
	
}
echo json_encode($oJson);
?>