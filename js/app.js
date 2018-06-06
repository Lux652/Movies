var oFilmoviModul = angular.module('filmovi-app', ['ngRoute']);


oFilmoviModul.controller('filmoviController', function ($scope,$http,$location) {
    $scope.loggedin = false;
    $scope.loggeduser=null;

    $http.post('action.php', {action_id: 'check_logged_in'})
    .then(
        function(response){
            if(response.data.status == 1){

                $scope.role='user';
                $scope.loggedin = true;


            }
            else{
                $scope.role="guest";
                $scope.loggedin = false;
                $location.path("/");
            }
        },
        function(e){
            console.log('error');
            $scope.ulogiran = false;
        }
    );
     
	$scope.LoadMovies = function()
    {

        
        $http({
            method: 'GET',
            url: 'json.php?json_id=get_movies'
        }).then(function(response) {
            $scope.filmovi=response.data;
        }, function(response) {
            
        });
        };

        


    // $scope.Login = function(){
    //     var oData = {
    //         'action_id': 'login',
    //         'username': $scope.username,
    //         'password': $scope.password
    //     };
    //     $http.post('action.php', oData)
    //         .then(
    //             function(response){
                    
    //                 if(response.data.login_status == 1){
    //                     console.log(oData);
    //                     $scope.loggedin = true;
    //                     $location.path('/home');
    //                 }
    //                 else{
    //                     alert('Neispravno korisničko ime i/ili lozinka!');
    //                 }
                    
    //                 console.log(response);
    //             },
    //             function(e){
    //                 console.log('error');
    //             }
    //         );
    // };

	$scope.myMovies = function()
    {

        console.log("alo");
        $http({
            method: 'GET',
            url: 'json.php?json_id=myMovies'
        }).then(function(response) {
            $scope.filmovi=response.data;
        }, function(response) {
            
        });
        };

        $scope.searchMovies = function()
        {
            $http({
                method: 'GET',            
                url: 'json.php?json_id=search_movies&title='+encodeURIComponent($scope.title.trim())
            }).then(function(response) {
                $scope.filmovi=response.data;
                $scope.prikazi=true;
                console.log(response);
            }, function(response) {
                alert("Traženi film ne postoji")
            });
        };


    $scope.Login = function(){
        var oData = {
            'action_id': 'login',
            'username': $scope.username,
            'password': $scope.password
        };
        $http.post('action.php', oData)
            .then(
                function(response){
                    if(response.data.status == 1){
                        $scope.loggeduser=response.data.user_id;
                        $scope.role="user";
                        $scope.loggedin = true;
                        $location.path('/home');
                    }
                    else{
                        alert("Neispravno korisničko ime i/ili lozinka! Pokušajte ponovno!");
                    }
                    console.log(response);
                },
                function(e){
                    console.log('error');
                }
            );
    };

$scope.Register = function(){
        var oData = {
            'action_id':'register',
            'firstname': $scope.firstname,
            'lastname': $scope.lastname,
            'username': $scope.username,
            'password': $scope.password,
            'email':$scope.email
        };
        $http.post('action.php', oData)
            .then(
                function(response){
                    if(response.data==1){
                        console.log(oData);
                        alert("Uspješna registracija!");
                        $location.path('/login');
                    }
                    else{
                        console.log(oData);
                    }
                    console.log(response);
                }
            );
    };

    $scope.Logout = function(){
        var oData={
            'action_id':'logout'
        };
        $http.post('action.php', {action_id: 'logout'})
        .then(
            function(response){
                $scope.loggedin = false;
                alert('Logout successful');
                $location.path('/');
            },
            function(e){
                console.log('error');
            }
        );


    };

    $scope.addMovie = function(oMovie){
        console.log(oMovie);
        oMovie.action_id = 'add_movie';   
        $http.post('action.php', oMovie)
            .then(
                function(response){
                    console.log(response);
                    if(response.data==1){                      
                        $location.path('/movies');
                    }
                    else{
                        //console.log(oData);                      
                    }
                    //console.log(response);
                }
            );
    };

});


oFilmoviModul.config(function($routeProvider){
	$routeProvider.when('/',{
		templateUrl:'templates/login.html',
		controller:'filmoviController'
	});
	$routeProvider.when('/movies',{
		templateUrl:'templates/movies.html',
		controller:'filmoviController'
	});
	$routeProvider.when('/home',{
		templateUrl:'templates/home.html',
        controller:'filmoviController'
	});
	$routeProvider.when('/register',{
		templateUrl:'templates/register.html',
        controller:'filmoviController'
    });
    $routeProvider.when('/search',{
		templateUrl:'templates/search.html',
        controller:'filmoviController'
	});
	$routeProvider.otherwise({
		template:'Greška'
	});
});
