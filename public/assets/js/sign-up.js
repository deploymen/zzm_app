var App = angular.module('cashApp', []);

App.controller('MainController', function($scope, $http) {

    $scope.signUp = function() {
        var name = angular.element(".name input").val(),
            username = angular.element(".username input").val(),
            password1 = angular.element(".password1 input").val(),
            password2 = angular.element(".password2 input").val();

        if (name == '' || username == '' || password1 == '' || password2 == '') {
            alert('You have to fill up all fields to complete the sign up');
            return;
        }    

/*        if (!/^(([A-Za-z0-9]+_+)|([A-Za-z0-9]+\-+)|([A-Za-z0-9]+\.+)|([A-Za-z0-9]+\++))*[A-Za-z0-9]+@((\w+\-+)|(\w+\.))*\w{1,63}\.[a-zA-Z]{2,6}$/.test(email)) {
            alert('Invalid email address.');
            return;
        }*/

        if(!/^\w{6,30}$/.test(username)){
            alert('Username have to be at least 6 alphanumeric(only) characters.');
            return;
        }

        if(password1.length < 6){
            alert('Password have to be at least 6 characters.');    
            return;
        }        

        if(password1 != password2){
            alert('Both passwords are not match.');
            return;
        }

        $http.post('/api/sign-up', {
            name: name,
            email: '',
            username: username,
            password: password1
        }).success(function(data, status, headers, config) {
            if (data.status == 'success') {
                alert('Your account has successfullly created. Welcome!');
                location = "/";
            } else {
                alert(data.message);
                console.log(data.message);
            }
        });
    }

});
