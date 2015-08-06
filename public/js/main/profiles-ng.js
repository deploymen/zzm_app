var App = App || angular.module('zapzapProfile', []),
	ZZM = ZZM || {};

App.service();

App.controller('ProfileController', function ($scope, $http){
	$scope.profileId = '';
	$scope.playId = '';

	$scope.init = function(){
		$scope.profileId = ZZM.profileId;
   		$scope.playId = ZZM.playId;

   		// $scope.profiles = 

   		// $http.get('/api/profiles').
   		// 	success()
	}
});