'use strict';

/**
 * @ngdoc function
 * @name amsApp.controller:TimetableCtrl
 * @description
 * # TimetableCtrl
 * Controller of the amsApp
 */
angular.module('amsApp')
  .controller('TimetableCtrl', [ '$scope', '$stateParams', 'timetable' ,function ($scope, $stateParams, timetable) {
	  
	var vm=this;
	/*this.classDate = $scope.attendance.classDate;*/
	/*this.classDate = this.$parent.classDate;*/
/*    this.isOpen = $parent.isOpen;
    this.class_type=$parent.class_type;
    this.fromTime = $parent.fromTime;
    this.toTime = $parent.toTime;*/

	this.timetableToggle_val='-';
	this.timetableToggle =function(){
		if(vm.timetableToggle_val=='-')
			vm.timetableToggle_val='+';
		else
			vm.timetableToggle_val='-';
	};


	console.log($stateParams.username);
	timetable.getFacultyTimetable($stateParams.username,2017).then(function(data){
	vm.timetabledata=data;
	console.log(vm.timetabledata);

	//map
	var ttbl_map = vm.timetabledata.map(function(tag) {
		var tmp_arr = new Array();
		tmp_arr.push(tag["day"]);
		tmp_arr.push(tag["type"]);
		tmp_arr.push(new Date(tag["start_time"] - (3.5*60*60*1000) ));
		tmp_arr.push(new Date(tag["end_time"] - (3.5*60*60*1000) ));
		return tmp_arr;
	});
		vm.data=ttbl_map;
		console.log(ttbl_map);
			google.charts.load('current', {'packages':['timeline']});
		google.charts.setOnLoadCallback(drawTimetable);
	});


		/*	this.data= [
				[ 'mon', 'oopd',  new Date(0, 0, 0, 9, 0, 0),  new Date(0, 0, 0, 10, 0, 0) ],
				[ 'tue', 'oopd',   new Date(0, 0, 0, 10, 0, 0),  new Date(0, 0, 0, 11, 0, 0) ],
				[ 'wed', 'em',     new Date(0, 0, 0, 9, 0, 0),  new Date(0, 0, 0, 10, 0, 0) ],
				[ 'thu', 'em',    new Date(0, 0, 0, 10, 0, 0),  new Date(0, 0, 0, 12, 0, 0) ],
				[ 'fri', 'oopd',  new Date(0, 0, 0, 9, 0, 0),  new Date(0, 0, 0, 11, 0, 0) ],
				[ 'fri', 'current',  new Date(0, 0, 0, 9, 0, 0),  new Date(0, 0, 0, 12, 0, 0) ],
				[ 'sat', 'em',     new Date(0, 0, 0, 16, 0, 0),  new Date(0, 0, 0, 17, 0, 0) ]
			];*/

	function drawTimetable() {
		$(document).ready(function() {
			var container = document.getElementById('class_timtable');
			var chart = new google.visualization.Timeline(container);
			var dataTable = new google.visualization.DataTable();

			dataTable.addColumn({ type: 'string', id: 'Day' });
			dataTable.addColumn({ type: 'string', id: 'dummy bar label' });
			/*dataTable.addColumn({ type: 'string', role: 'tooltip' });*/
			dataTable.addColumn({ type: 'date', id: 'Start' });
			dataTable.addColumn({ type: 'date', id: 'End' });
			dataTable.addRows(vm.data);
			// Set chart option
			var options = {
					// width:500,
					// height:350,
					  // hAxis: {
					  //   minValue: new Date(1509102000000),
					  //   maxValue: new Date(1509104000000)
					  // }
					// enableInteractivity : false,
					// tooltip: { trigger: 'none' }
				};

			// The select handler 
			function selectHandler() {
			    var selectedItem = chart.getSelection()[0];
			    if (selectedItem) {
			      var day = dataTable.getValue(selectedItem.row, 0);	
			      var value1 = dataTable.getValue(selectedItem.row, 1);
			      var startTime = dataTable.getValue(selectedItem.row, 2);
			      var endTime = dataTable.getValue(selectedItem.row, 3);
			      $scope.attendance.fromTime = startTime;
			      $scope.attendance.toTime = endTime;
			      $scope.attendance.filterDay = $scope.attendance.daymap[day];
			      alert('The user selected ' + startTime +endTime+ $scope.attendance.classDate +
			      	$scope.attendance.filterDate($scope.attendance.classDate));

		  		angular.element(document.getElementById('class_details')).scope().$applyAsync();
			  }
		    }
			//Listener 
			google.visualization.events.addListener(chart, 'select', selectHandler);

			chart.draw(dataTable, options);
		});
	}


  }]);