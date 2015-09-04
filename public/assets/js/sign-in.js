var App = App || angular.module('detdetacgApp', []);

App.controller('GlobalController', function ($scope, $http){

});

App.controller('MainController', function($scope, $http) {

    $scope.signIn = function() {
alert('123');
        var username = angular.element(".username input").val(),
            password = angular.element(".password input").val();

        if (username == '' || password == '') {
            alert('Please enter both username & password to sign in.');
            return;
        }

        FUNC.showLoading();
        $http.post('/api/sign-in', {
            username: username,
            password: password

        }).success(function(data, status, headers, config) {
            FUNC.hideLoading();
            if (data.status == 'success') {
                location = "/index";
            } else {
                alert('Wrong username/password');
                console.log(data.message);
            }
        });
    }
});