var oFilmoviModul = angular.module('filmovi-app', ['ngRoute']);


oFilmoviModul.controller('filmoviController', function ($scope,$http,$location) {

    $scope.loggedin = false;

     
	$scope.LoadMovies = function()
    {
            
        $scope.otvoriModal = function(sHref)
        {
            $('#modals').removeData('bs.modal');
            $('#modals').modal
            ({
                remote: sHref,
                show: true
            });
        };
        
        $http({
            method: 'GET',
            url: 'json.php?json_id=get_movies'
        }).then(function(response) {
            $scope.filmovi=response.data;
            console.log(response);
        }, function(response) {
            
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
                    
                    if(response.data.login_status == 1){
                        console.log(oData);
                        $scope.loggedin = true;
                        $location.path('/home');
                    }
                    else{
                        alert('Neispravno korisničko ime i/ili lozinka!');
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
                        $location.path('/home');
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
        }
        console.log(oData);


    };


    $scope.addMovie = function(oMovie){
        //console.log(oMovie);
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
	$routeProvider.otherwise({
		template:'Greška'
	});
});
