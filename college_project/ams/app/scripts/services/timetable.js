'use strict';

/**
 * @ngdoc service
 * @name amsApp.timetable
 * @description
 * # timetable
 * Service in the amsApp.
 */
angular.module('amsApp')
  .service('timetable',[ '$rootScope', '$http', function ($rootScope, $http) {
    // AngularJS will instantiate a singleton by calling "new" on this function

  	var vm =this;

    this.getFacultyTimetable = function(faculty_id, year) {
     
    	return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/FacultyTimetable/'+faculty_id+'/',
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

    this.getClass = function(course_component_val) {
    	    return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/list/Class/'+course_component_val+'/',
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
    this.checkClass = function(param) {
    	    return new Promise(function(resolve, reject){
    		//async operation
		    return $http.post($rootScope.$baseBackendUrl+'ams/list/Classes/', param )
			    .then(function (response) {
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});
    	});
    }

    this.addClass = function(param) {
    	return new Promise(function(resolve, reject){
    		//async operation
			  /* $http({
		    	 method: 'POST',
		    	 url: $rootScope.$baseBackendUrl+'ams/create/class/',
		    	 data: {course_faculty_year_id : 32 , date: '2017-11-09' , start_time: '07:00:00', end_time: '08:00:00'},
		    	 headers: {
		    	 	'Content-Type': 'application/json; charset=utf-8'
		    	 }
		    	}).then(function(response) { 
		    		//on success
					console.log(String(response.data));
					console.log(response.data, response.status);
		    		alert("inside" + response.data);
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});*/

/*			   	$.post($rootScope.$baseBackendUrl+'ams/create/class/',
			        {
			          course_faculty_year_id: 32,
			           date: '2017-11-09',
			           start_time: '07:00:00',
			           end_time: '08:00:00'
			        },
			        function(data,status){
			        	alert("Data: " + data + "\nStatus: " + status);
			            console.log("Data: " + data + "\nStatus: " + status);
			        });

			     	$.ajax( {
			     		method: "POST",
			     		url: $rootScope.$baseBackendUrl+'ams/create/class/',
				        data:{
				            course_faculty_year_id: 32,
				           date: '2017-11-09',
				           start_time: '07:00:00',
				           end_time: '08:00:00'
			    		}
				    }).done(function(response,status){
				        	alert("Data: " + response  + "\nStatus: " + status);
				            console.log("Data: " + response  + "\nStatus: " + status);
		        });*/
				/*  $http({
		            method: 'POST',
		            url: $rootScope.$baseBackendUrl+'ams/create/class/',
		            data: {		  
		               course_faculty_year_id: 32,
			           date: '2017-11-09',
			           start_time: '07:00:00',
			           end_time: '08:00:00'
			       },
		            headers: {
				        "Content-Type": "application/json; charset=utf-8"
				        Content-Type: 'x-www-form-urlencoded'

				    }
			        }).then(function (response) {
			            console.log(response);
			        }, function (response) {
			            console.log(response);
		        });   */

/*			    var data = {
			        course_faculty_year_id: 48,
		           date: '2017-11-09',
		           start_time: '07:00:00',
		           end_time: '08:00:00'
			    };*/			    
			    return $http.post($rootScope.$baseBackendUrl+'ams/create/Class/', param)
			    .then(function (response) {
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});
    	});
    }
    this.getAttendance = function(class_id) {
    	    return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/list/Attendance/'+class_id+'/',
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
    this.addAttendance = function(param) {
    	return new Promise(function(resolve, reject){
    		//async operation		    
			    return $http.post($rootScope.$baseBackendUrl+'ams/create/Attendance/', param)
			    .then(function (response) {
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response, response.status);
		    		return reject( "error", param);
		    		console.log(JSON.stringify(param.rollno)+"after__________");
		    		return param;
		    	});
    	});
    }
    this.updateAttendance = function(param) {
    	return new Promise(function(resolve, reject){
    		//async operation		    
			    return $http.post($rootScope.$baseBackendUrl+'ams/update/Attendance/', param)
			    .then(function (response) {
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});
    	});
    }

        
  }]);
    
