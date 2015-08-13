<<<<<<< HEAD
var App = App || angular.module('zapzapProfile', []),
	ZZM = ZZM || {};

App.service('profileService', function($http, $q){
	var deferred = $q.defer();
	
	$http.get('/api/profiles').then(function(data){
		deferred.resolve(data);
	});

	this.getProfiles = function(){
		return deferred.promise;
	}
});

App.controller('ProfileController', function ($scope, profileService){
	$scope.profileId = '';
	$scope.playId = '';

	var promise = profileService.getProfiles();

	promise.then(function(data){
		$scope.gameprofiles = data['data'].data.list;
		// console.log($scope.gameprofiles);
	});
	
});
=======
// var App = App || angular.module('zapzapProfile', []),
// 	ZZM = ZZM || {};

// App.service();

// App.controller('MainController', function ($scope, $http){
// 	$scope.profileId = '';
// 	$scope.playId = '';

// 	$scope.init = function(){
// 		$scope.profileId = ZZM.profileId;
//    		$scope.playId = ZZM.playId;

//    		$scope.profiles = 

//    		$http.get('/api/profiles').
//    			success(){

//    			}
// 	}
// });
>>>>>>> adds clickable code for best_score to profiles.js
