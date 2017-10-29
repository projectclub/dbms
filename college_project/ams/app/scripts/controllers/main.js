'use strict';

/**
 * @ngdoc function
 * @name amsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the amsApp
 */
angular.module('amsApp')
  .controller('MainCtrl', ['$rootScope','$state', 'auth', function ($rootScope, $state, auth) {
  	var vm = this;
  	this.left=true;
  	this.user_info=[];
	this.user_info.username ="username";
	this.user_info.account_type = "Notset";
	this.user_info = { account_type: "notset", username: "user"};
	this.login_invalid=false;
	$rootScope.$user=[];
/*  	auth.getAuth().then(function(data) {

		alert(data);
	});*/
	
/*	this.user_info=auth.getAuth();*/


	this.login = function(user, pass){
		auth.getAuth(user, pass).then(function(data){
			vm.user_info=data;
			alert("after"+data.username);
			  		angular.element(document.getElementById('loginfo')).scope().$applyAsync();		
			if(data.account_type=="faculty")	{		  		
				alert("faculty alert");
				$state.go("facultyhome.home", vm.user_info);
				vm.login_invalid=false;
			}
			else{
				vm.login_invalid=true;
				angular.element(document.getElementById('loginfo')).scope().$applyAsync();		
			}
		},function(data){
				vm.login_invalid=true;
				angular.element(document.getElementById('loginfo')).scope().$applyAsync();		
		});
		/*alert(this.user_info.username);*/
	};

}]);
