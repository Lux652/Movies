<?php

class Configuration
{
	public $host="localhost";
	public $dbName="filmovi";
	public $username="root";
	public $password="";	
}


class User
{
	public $id="N/A";
	public $username="N/A";
	public $password="N/A";
	public $firstname="N/A";
	public $lastname="N/A";
	public $email="N/A";

	public function __construct($id=null,$username=null,$password=null,$firstname=null,$lastname=null,$email=null)
	{
        $this->id=$id;
        $this->username=$username;
        $this->password=$password;
        $this->firstname=$firstname;
		$this->lastname=$lastname;
	    $this->email=$email;
	}
}

class saved_Movie{
    public $id="N/A";
    public $title="N/A";
    public $rating="N/A";
    public $poster="N/A";
    public $user_id="N/A";
    public $user_rating="N/A";

    public function __construct($id=null,$title=null,$rating=null,$poster=null,$user_id=null,$user_rating=null){
        $this->id=$id;
        $this->title=$title;
        $this->rating=$rating;
        $this->poster=$poster;
        $this->user_id=$user_id;
        $this->user_rating=$user_rating;

    }
}
class Movie{
    public $ID="N/A";
    public $Title="N/A";
    public $Rating="N/A";
    public $Poster="N/A";
    public $Date="N/A";

    public function __construct($ID=null,$Title=null,$Rating=null,$Poster=null,$Date=null){
        $this->ID=$ID;
        $this->Title=$Title;
        $this->Rating=$Rating;
        $this->Poster=$Poster;
        $this->Date=$Date;
    }
}

?>