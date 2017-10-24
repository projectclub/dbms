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
  .module('amsApp', ['ui.router'])
  .config(['$stateProvider', '$urlRouterProvider', function($stateProvider, $urlRouterProvider){
  	$urlRouterProvider.otherwise('/');

  	$stateProvider
  		.state('home', {
  			url: '/',
  			templateUrl: 'views/main.html',
  			controller: 'MainCtrl as auth'
  		})
  		.state('facultyhome', {
  			url:'/facultyhome/:username/:account_type',
  			templateUrl: 'views/facultyhome.html'
  		})
  		;

  }]);