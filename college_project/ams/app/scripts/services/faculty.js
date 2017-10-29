'use strict';

/**
 * @ngdoc service
 * @name amsApp.faculty
 * @description
 * # faculty
 * Service in the amsApp.
 */
angular.module('amsApp')
  .service('faculty', ['$rootScope', '$http', function ($rootScope, $http) {
    // AngularJS will instantiate a singleton by calling "new" on this function

  	var vm =this;

    this.getFacultyCourse = function(faculty_id, year) { 
    	return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/facultycourse/'+faculty_id+'/'+year+'/',
		    	}).then(function(response) { 
		    		//on success
					console.log(String(response.data));

		    		alert("inside" + response.data);
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});
    	});
    };	
        this.getFaculty = function(faculty_id) { 
    	return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/faculty/'+faculty_id+'/',
		    	}).then(function(response) { 
		    		//on success
					console.log(String(response.data));

		    		alert("inside" + response.data);
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});
    	});
    };

  }]);
