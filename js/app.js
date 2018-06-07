var oFilmoviModul = angular.module('filmovi-app', ['ngRoute']);


oFilmoviModul.config(function ($routeProvider) {
    $routeProvider.when('/', {
        templateUrl: 'templates/login.html',
        controller: 'filmoviController'
    });
    $routeProvider.when('/movies', {
        templateUrl: 'templates/movies.html',
        controller: 'filmoviController'
    });
    $routeProvider.when('/home', {
        templateUrl: 'templates/home.html',
        controller: 'filmoviController'
    });
    $routeProvider.when('/register', {
        templateUrl: 'templates/register.html',
        controller: 'filmoviController'
    });
    $routeProvider.when('/search', {
        templateUrl: 'templates/search.html',
        controller: 'filmoviController'
    });
    $routeProvider.otherwise({
        template: 'Greška'
    });
});

oFilmoviModul.controller('filmoviController', function ($scope, $http, $location) {
    $scope.loggedin = false;

    $http.post('action.php', {
            action_id: 'check_logged_in'
        })
        .then(
            function (response) {
                if (response.data.status == 1) {
                    $scope.loggedin = true;
                } else {
                    $scope.loggedin = false;
                }
            },
            function (e) {
                console.log('error');
            }
        );

    $scope.LoadMovies = function () {
        $http({
            method: 'GET',
            url: 'json.php?json_id=get_movies'
        }).then(function (response) {
                $scope.filmovi = response.data;
            },
            function (response) {
                console.log('error');
            });
    };

    $scope.myMovies = function () {
        $http({
            method: 'GET',
            url: 'json.php?json_id=myMovies'
        }).then(function (response) {
                $scope.filmovi = response.data;
            },
            function (response) {
                console.log('error');
            });
    };

    $scope.searchMovies = function () {
        $http({
            method: 'GET',
            url: 'json.php?json_id=search_movies&title=' + $scope.title
        }).then(function (response) {
            $scope.filmovi = response.data;
        }, function (response) {
            alert("Traženi film ne postoji")
        });
    };

    $scope.Login = function () {
        var oData = {
            'action_id': 'login',
            'username': $scope.username,
            'password': $scope.password
        };
        $http.post('action.php', oData)
            .then(
                function (response) {
                    if (response.data.status == 1) {
                        $scope.loggedin = true;
                        $location.path('/home');
                        alert("Pozdrav " + $scope.username + "!");
                    } else {
                        alert("Neispravno korisničko ime i/ili lozinka! Pokušajte ponovno!");
                    }
                    console.log(response);
                },
                function (e) {
                    console.log('error');
                }
            );
    };

    $scope.Register = function () {
        var oData = {
            'action_id': 'register',
            'firstname': $scope.firstname,
            'lastname': $scope.lastname,
            'username': $scope.username,
            'password': $scope.password,
            'email': $scope.email
        };
        $http.post('action.php', oData)
            .then(
                function (response) {
                    if (response.data == 1) {
                        console.log(oData);
                        alert("Uspješna registracija!");
                        $location.path('/');
                    } else {
                        console.log(oData);
                    }
                    console.log(response);
                }
            );
    };

    $scope.Logout = function () {
        var oData = {
            'action_id': 'logout'
        };
        $http.post('action.php', {
                action_id: 'logout'
            })
            .then(
                function (response) {
                    $scope.loggedin = false;
                    alert('Uspješno ste se odjavili!');
                    $location.path('/');
                },
                function (e) {
                    console.log('error');
                }
            );
    };

    $scope.addMovie = function (oMovie) {
        console.log(oMovie);
        oMovie.action_id = 'add_movie';
        $http.post('action.php', oMovie)
            .then(
                function (response) {
                    console.log(response);
                    alert("Uspješno ste dodali " + oMovie.Title + "!\nOcjena: " + oMovie.UserRating);
                }
            );
    };
});