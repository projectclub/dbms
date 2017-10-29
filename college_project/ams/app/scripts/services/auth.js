'use strict';

/**
 * @ngdoc service
 * @name amsApp.auth
 * @description
 * # auth
 * Service in the amsApp.
 */
angular.module('amsApp')
  .service('auth', ['$rootScope', '$http', function ($rootScope, $http) {
    
    this.getAuth = function(username, pass){
    	
    	return new Promise(function(resolve, reject){
    		//async operation
		    $http({
		    	 method: 'GET',
		    	 url: $rootScope.$baseBackendUrl+'ams/auth/'+username+'/'+pass+'/',
		    	}).then(function(response) { 
		    		//on success
					console.log(String(response.data.username));
					console.log(String(response.data.accout_type));

		    		alert("inside" + response.data.username);
		    		resolve( response.data);
		    	}, function(response) {
		    		//on error
		    		console.log(response.data, response.status);
		    		reject( "error");
		    	});
/*    		setTimeout(function(){
    			resolve(input + 10);
    		}, 500);*/
    	});


    };
  }]);
