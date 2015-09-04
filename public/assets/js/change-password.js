var App = App || angular.module('cashApp', []);

App.controller('MainController', function ($scope, $http){

    $scope.changePassword = function() {

        var password1 = angular.element("#password1").val(),
            password2 = angular.element("#password2").val(),
            password0 = angular.element("#password0").val();

        if (password1 == '' || password2 == '' || password0 == '') {
            alert('Fill in all fields to proceed.');
            return;
        }

        if(password1.length < 6){
            alert('Password have to be atleast 6 characters.');
            return;
        }      

        if(password1 != password2){
            alert('New password are not match.');
            return;
        }

        $http.post('/api/change-password', {
            password0: password0,
            password1: password1

        }).success(function(data, status, headers, config) {
            if (data.status == 'success') {
                alert('Your password has changed successfully.');
                location = "/";
            } else {
                alert(data.message);
            }

        });
    }
});