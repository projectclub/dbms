'use strict';

/**
 * @ngdoc overview
 * @name amsApp
 * @description
 * # amsApp
 *
 * Main module of the application.
 */
angular
  .module('amsApp', ['ui.router', 'ngMaterial', 'ngMessages', 'ngAnimate', 'ngAria', 'mdPickers'])

  .run(['$rootScope', '$state', '$stateParams', '$http','faculty',  function($rootScope, $state, $stateParams, $http, faculty) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
    $rootScope.$baseBackendUrl="http://localhost/college_project/ams/backend/";

        // Use x-www-form-urlencoded Content-Type
    $http.defaults.headers.post["Content-Type"] = 'application/x-www-form-urlencoded;charset=utf-8';
    /**
     * The workhorse; converts an object to x-www-form-urlencoded serialization.
     * @param {Object} obj
     * @return {String}
     */ 
     $rootScope.$http_param =Array();
    $rootScope.$http_param.param = function(obj) {
      var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

      for(name in obj) {
        value = obj[name];

        if(value instanceof Array) {
          for(i=0; i<value.length; ++i) {
            subValue = value[i];
            fullSubName = name + '[' + i + ']';
            innerObj = {};
            innerObj[fullSubName] = subValue;
            query += param(innerObj) + '&';
          }
        }
        else if(value instanceof Object) {
          for(subName in value) {
            subValue = value[subName];
            fullSubName = name + '[' + subName + ']';
            innerObj = {};
            innerObj[fullSubName] = subValue;
            query += param(innerObj) + '&';
          }
        }
        else if(value !== undefined && value !== null)
          query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
      }

      return query.length ? query.substr(0, query.length - 1) : query;
    };
    
    // Override $http service's default transformRequest
     $http.defaults.transformRequest = [function(data) {
       return angular.isObject(data) && String(data) !== '[object File]' ? $rootScope.$http_param.param(data) : data;
     }];

    //////////////////////////////////
    $rootScope.$user=Array();

  /*  if($state.includes("facultyhome"))
    {*/
/*      $rootScope.$user["username"]="something";
      $rootScope.$user["avatar"]="avatar3.png";*/

      


  }])

  .config(['$stateProvider', '$urlRouterProvider','$mdThemingProvider', function($stateProvider, $urlRouterProvider, $mdThemingProvider){

    $mdThemingProvider.theme('default')
    .primaryPalette('blue-grey');

  	$urlRouterProvider.otherwise('/');

  	$stateProvider
  		.state('home', {
  			url: '/',
  			templateUrl: 'views/main.html',
  			controller: 'MainCtrl as auth'
  		})
  		.state('facultyhome', {
        abstract:true,
  			url:'/facultyhome/:username/:account_type',
  			templateUrl: 'views/facultyhome.html',
        controller: 'FacultyhomeCtrl as facultyh'
  		})
      .state('facultyhome.home', {
        url:'',
        templateUrl: 'views/facultycourse.html',
        controller: 'FacultycourseCtrl as facultyCourses'
      })
  		.state('facultyhome.attendance', {
  			url:'/attendance/:course_id',
        /*abstract:true,*/
  			templateUrl: 'views/attendance.html',
        controller: 'AttendanceCtrl as attendance'
  		})
      .state('facultyhome.attendance.table', {
        url:'/table',
        /*abstract:true,*/
        templateUrl: 'views/attendancetable.html',
        controller: 'AttendancetableCtrl as attendancetable'
      })
/*      .state('facultyhome.attendance.studentlist', {
        url:'/studentlist',
        templateUrl: 'views/studentlist.html'
      })
      .state('facultyhome.attendance.timetable', {
        url:'/timetable',
        templateUrl: 'views/timetable.html',
        controller: 'TimetableCtrl as timetable'
      })*/
  		;
  		console.log($urlRouterProvider);
  }]);

  