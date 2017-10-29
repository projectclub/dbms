'use strict';

/**
 * @ngdoc function
 * @name amsApp.controller:FacultyhomeCtrl
 * @description
 * # FacultyhomeCtrl
 * Controller of the amsApp
 */
angular.module('amsApp')
  .controller('FacultyhomeCtrl',['$rootScope','$stateParams','faculty', function ($rootScope, $stateParams ,faculty) {
	var vm =this;
	this.getUserdata=function(){
		   faculty.getFaculty($stateParams.username)
	      .then(function(data){
	          $rootScope.$user["id"]=$stateParams.username;
	          $rootScope.$user["gender"]=data[$stateParams.username]['gender'];
	          $rootScope.$user["username"]=data[$stateParams.username]['faculty_name'];
	          if($rootScope.$user["gender"]=='m')
	            $rootScope.$user.avatar="avatar3.png"
	          else
	            $rootScope.$user.avatar="avatar4.png"
	        console.log("faculty"+$rootScope.$user["username"]);
	        angular.element(document.getElementById('nav_dropdown')).scope().$applyAsync();		
	      });
	  }
  }]);
