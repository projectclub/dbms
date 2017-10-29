'use strict';

/**
 * @ngdoc service
 * @name amsApp.course
 * @description
 * # course
 * Service in the amsApp.
 */
angular.module('amsApp')
  .service('course',[ '$rootScope','$http', function ($rootScope, $http) {
    // AngularJS will instantiate a singleton by calling "new" on this function
    this.getCourse = function(course_id) { 
    	return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/course/'+course_id+'/',
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

    this.getCourseEnrollment =function(course_component_id) {
    	return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/facultycourseenrollment/'+course_component_id+'/',
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
    }
  }]);
