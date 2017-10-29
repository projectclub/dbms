'use strict';

/**
 * @ngdoc function
 * @name amsApp.controller:FacultycourseCtrl
 * @description
 * # FacultycourseCtrl
 * Controller of the amsApp
 */
angular.module('amsApp')
  .controller('FacultycourseCtrl', ['$scope','$state', '$stateParams','faculty' , function ($scope, $state, $stateParams, faculty) {
  	var vm =this;
	$scope.facultyh.getUserdata();

	this.getFacultyCourses = function(){
		faculty.getFacultyCourse($stateParams.username, 2017).then(function(data){
			vm.courses=data;
			alert("after"+data);
	  		angular.element(document.getElementById('courselist')).scope().$applyAsync();		
		});
		/*alert(this.user_info.username);*/
	};
	this.getFacultyCourses();
	console.log($stateParams);

	this.loadAttendence =function(course_id, course_data)
	{
		alert("sdfasdf");
		$state.go("facultyhome.attendance",{"course_id":course_id});
	}
  }]);
