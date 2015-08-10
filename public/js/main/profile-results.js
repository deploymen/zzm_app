var App = App || angular.module('zapzapApp', []),
	ZZM = ZZM || {};


App.controller('MainController', function ($scope, $http){

	$scope.systems = [];
	$scope.planets = [];
	$scope.plays = [];
	$scope.questions = [];
	$scope.pagination = [];
	$scope.pageTotal = 1;
	$scope.pageSize = 10;
	$scope.page = 1;
	$scope.breadcumbs = [];
	$scope.systemId = '';
	$scope.profileId = '';
	$scope.planetId = '';
	$scope.playId = '';

    $scope.init = function() { 

   		$scope.profileId = ZZM.profileId;
   		$scope.systemId = ZZM.systemId;
   		$scope.planetId = ZZM.planetId;
   		$scope.playId = ZZM.playId;

   		if($scope.systemId == '') {
   			mode = '';
   		} 
   		if($scope.profileId != '' && $scope.systemId != '') {
   			mode = 'system_id';
   		} 
   		if($scope.profileId != '' && $scope.planetId != '') {
   			mode = 'planet_id';
   		}
   		if($scope.profileId != '' && $scope.playId != '') {
   			mode = 'play_id';
   		}

    	$(".result").addClass('hide');
		switch(mode){
			case '': $scope.fetchSystemResult(1, $scope.pageSize); break;  	
			case 'system_id': $scope.fetchPlanetsResult($scope.profileId, $scope.systemId, 1, $scope.pageSize); break;  	
			case 'planet_id': $scope.fetchPlayResult($scope.profileId, $scope.planetId, 1, $scope.pageSize); break;  	
			case 'play_id': $scope.fetchQuestionsResult($scope.profileId, $scope.playId, 1, $scope.pageSize); break;  	
		} 
    }

    $scope.fetchSystemResult = function(page, pageSize){
    	
    	var pageSize = pageSize || $scope.pageSize;

    	page = (page < 1)?1:page;
		page = (page > $scope.pageTotal)?$scope.pageTotal:page;
		$scope.page = page;
		$('li.indicator-list-item:nth-child(1)').addClass('active');
        $http.get('/api/profiles/result/only-system?' + [
            'page=' + page,
            'page_size=' + pageSize,
            'profile_id=' + $scope.profileId
        ].join('&')).success(function(data, status, headers, config) {
            if (data.status == 'success') {
            	$scope.systems = data.data.system;
                //pagination
				$scope.page = +data.data['page'];
				$scope.pageTotal = +data.data['pageTotal'];
				$scope.pagination = [];
				for(var i=1; i<=$scope.pageTotal; i++ ){
					$scope.pagination.push({no: i, active: i==$scope.page});
				} 
                //render
                $scope.showResult('system'); 

            } else {
                alert(data.message);
            }
        });  	
    }  

	$scope.fetchPlanetsResult = function(profile_id, system_id, page, pageSize){

		$('li.indicator-list-item:nth-child(2)').addClass('active');
		$http.get('/api/profiles/result/only-planet?' + [
			'profile_id=' + profile_id,
        	'system_id=' + system_id, 
            'page=' + page,
            'page_size=' + pageSize
        ].join('&')).success(function(data, status, headers, config) {
            if (data.status == 'success') {
            	$scope.planets = data.data.planet;
            	$scope.breadcumbs = data.data.breakcrumb;

            } else {
                alert(data.message);
            }
        }); 

		$scope.showResult('planet');    	
	}

	$scope.fetchPlayResult = function(profile_id, planet_id, page, pageSize){

		$('li.indicator-list-item:nth-child(3)').addClass('active');
		$http.get('/api/profiles/result/only-play?' + [
			'profile_id=' + profile_id,
        	'planet_id=' + planet_id, 
            'page=' + page,
            'page_size=' + pageSize
        ].join('&')).success(function(data, status, headers, config) {
            if (data.status == 'success') {
            	$scope.plays = data.data.play;
            	$scope.breadcumbs = data.data.breakcrumb;

            } else {
                alert(data.message);
            }
        }); 

		$scope.showResult('play');    	
	}

	$scope.fetchQuestionsResult = function(profile_id, play_id, page, pageSize){

		var i, q;
		$('li.indicator-list-item:nth-child(4)').addClass('active');
		$http.get('/api/profiles/result/only-questions?' + [
			'profile_id=' + profile_id,
        	'play_id=' + play_id, 
            'page=' + page,
            'page_size=' + pageSize
        ].join('&')).success(function(data, status, headers, config) {
            if (data.status == 'success') {
            	$scope.questions = data.data.questions;
            	$scope.breadcumbs = data.data.breakcrumb;

            	for(i=0; i<$scope.questions.length; i++ ) {
            		r = $scope.questions[i].result;
            		$scope.answer = r.correct;
            	}

            } else {
                alert(data.message);
            }
        }); 

		$scope.showResult('question'); 

        console.log($scope.questions);   	
	}

	$scope.showResult = function(mode){
		/*//update breadcrumbs
		$scope.breadcumbs.push({
			'mode' : mode,
		    'id': id,
		});

		for(var i=0; i<$scope.breadcumbs.length; i++){
		    if($scope.breadcumbs[i].id == id){
		        $scope.breadcumbs.splice(i+1, 100);
		    }
		} */

		$(".result").addClass('hide');
		switch(mode){
			case 'system': $(".system").removeClass('hide'); break;  	
			case 'planet': $(".planet").removeClass('hide'); break;  	
			case 'play': $(".play").removeClass('hide'); break;  	
			case 'question': $(".question").removeClass('hide'); break;  	
		}
	}


});