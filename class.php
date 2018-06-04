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
    public $genre="N/A";
    public $rating="N/A";
    public $poster="N/A";

    public function __construct($ID=null,$Title=null,$Genre=null,$Rating=null,$Poster=null){
        $this->ID=$id;
        $this->Title=$title;
        $this->Genre=$genre;
        $this->Rating=$rating;
        $this->Poster=$poster;

    }
}
class Movie{
    public $ID="N/A";
    public $Title="N/A";
    public $Rating="N/A";
    public $Poster="N/A";

    public function __construct($ID=null,$Title=null,$Rating=null,$Poster=null){
        $this->ID=$ID;
        $this->Title=$Title;
        $this->Rating=$Rating;
        $this->Poster=$Poster;
    }
}

?>