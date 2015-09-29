var App = App || angular.module('zapzapApp', []);

App.controller('MainController', function ($scope, $http){

	$scope.systems = [];
	$scope.planets = [];
	$scope.plays = [];
	$scope.questions = [];
	$scope.system_pagination = [];
	$scope.play_pagination = [];
	$scope.pageTotal = 1;
	$scope.pageSize = 10;
	$scope.page = 1;
	$scope.pageSystem = {};
	$scope.pagePlay = {};
	$scope.breadcumbs = [];

    $scope.init = function() {        
        $scope.fetchSystemResult(1, $scope.pageSize);
    }

    $scope.fetchSystemResult = function(page, pageSize){
    	
    	var pageSize = pageSize || $scope.pageSize;

    	page = (page < 1)?1:page;
		page = (page > $scope.pageTotal)?$scope.pageTotal:page;
		$scope.page = page;

		if(!(page in $scope.pageSystem)){

	        $http.get('/api/game/profile/'+VARS.id+'/result/system-planet/progress?' + [
	            'page=' + page,
	            'page_size=' + pageSize
	        ].join('&')).success(function(data, status, headers, config) {
	            if (data.status == 'success') {
	                //pagination
					$scope.page = +data.data['page'];
					$scope.pageTotal = +data.data['pageTotal'];
	            	//buffer
	                $scope.pageSystem[page] = data.data.system;
	                //render
	                $scope.renderSystem(data.data.system);

	            } else {
	                alert(data.message);
	            }
	        });  	
		} else{
			$scope.renderSystem($scope.pageSystem[page]);				
		}
    }

	$scope.renderSystem = function(system){
		var resultList, i, s;
		$scope.systems = system;
		$scope.showResult('system');  

		$scope.system_pagination = [];
		for(var i=1; i<=$scope.pageTotal; i++ ){
			$scope.system_pagination.push({no: i, active: i==$scope.page});
		}     	 
	}    

	$scope.renderPlanets = function(planets, name){
		$scope.planets = planets;
		$scope.showResult('planet', name);    	
	}

	$scope.fetchPlayResult = function(page, pageSize, planetid, planetname){

    	$scope.planetid = planetid;
    	$scope.planetname = planetname;

    	var pageSize = pageSize || $scope.pageSize;

    	page = (page < 1)?1:page;
		page = (page > $scope.pageTotal)?$scope.pageTotal:page;
		$scope.page = page;

		if(!(page in $scope.pagePlay)){

	        $http.get('/api/game/profile/'+VARS.id+'/result/system-planet/planet/'+$scope.planetid+'?' + [
	            'page=' + page,
	            'page_size=' + pageSize
	        ].join('&')).success(function(data, status, headers, config) {
	            if (data.status == 'success') {
	                //pagination
					$scope.page = +data.data['page'];
					$scope.pageTotal = +data.data['pageTotal'];
	            	//buffer
	                $scope.pagePlay[page] = data.data.results;
	                //render
	                $scope.renderPlay(data.data.results, $scope.planetname);

	            } else {
	                alert(data.message);
	            }
	        });  	
		} else{
			$scope.renderPlay($scope.pagePlay[page], $scope.planetname);				
		}
    }

    $scope.renderPlay = function(plays, name){
		$scope.plays = plays;
		$scope.showResult('play', name);   

		$scope.play_pagination = [];
		for(var i=1; i<=$scope.pageTotal; i++ ){
			$scope.play_pagination.push({no: i, active: i==$scope.page});
		}  	
	}

	$scope.renderQuestions = function(questions, answer, name){
		$scope.questions = questions;
		$scope.answer = answer;
		$scope.showResult('question', name);    	
	}

	$scope.showResult = function(mode, name){
		//update breadcrumbs
		$scope.breadcumbs.push({
			'mode' : mode,
		    'name': name,
		});

		for(var i=0; i<$scope.breadcumbs.length; i++){
		    if($scope.breadcumbs[i].name == name){
		        $scope.breadcumbs.splice(i+1, 100);
		    }
		} 

		$(".result").addClass('hide');
		switch(mode){
			case 'system': $(".system").removeClass('hide'); break;  	
			case 'planet': $(".planet").removeClass('hide'); break;  	
			case 'play': $(".play").removeClass('hide'); break;  	
			case 'question': $(".question").removeClass('hide'); break;  	
		}
	}

});