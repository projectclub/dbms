'use strict';

/**
 * @ngdoc function
 * @name amsApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the amsApp
 */
angular.module('amsApp')
  .controller('MainCtrl', ['$state','auth', function ($state, auth) {
  	var vm = this;
  	this.user_info=[];
	this.user_info.username ="username";
	this.user_info.account_type = "Notset";
	this.user_info = { account_type: "notset", username: "user"};

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
				$state.go("facultyhome", vm.user_info);
			}
		});
		/*alert(this.user_info.username);*/
	};
}]);
