'use strict';

/**
 * @ngdoc function
 * @name amsApp.controller:AttendanceCtrl
 * @description
 * # AttendanceCtrl
 * Controller of the amsApp
 */
angular.module('amsApp')
  .controller('AttendanceCtrl',['$stateParams', '$state','course', 'faculty' , '$mdpDatePicker', '$mdpTimePicker','$mdToast',
    'timetable',function ($stateParams, $state, course, faculty,  $mdpDatePicker, $mdpTimePicker ,$mdToast, timetable) {
  		
  		var vm=this;
  		
		//Class info
  		this.course_id = $stateParams.course_id;
  		this.courses;  		
  		faculty.getFacultyCourse($stateParams.username ,2017).then(function(data){
			vm.courses=data;
			alert("after"+data);
	  		angular.element(document.getElementById('courselist')).scope().$applyAsync();			
		});

	    this.classDate = new Date();
	/*    this.isOpen = false;*/
	    this.component_val;
	    this.fromTime;
	    this.toTime;

  		this.daymap={'mon' : 1,'tue' : 2,'wed' : 3,'thu' : 4,'fri' : 5,'sat': 6, 'sun': 0};
		this.filterDay=-1;
		this.filterDate = function(date) {
	      /*return moment(date).date() % 7 != 0;*/
	      if(vm.filterDay == -1|| vm.filterDay > 6)
	      	return false;
	      else
		      return moment(date).day()!= vm.filterDay;
	    };
	    this.classTypeChange = function(selectedOption) {
	    	alert("yo alert: "+selectedOption+" Selected");
	    	vm.component_val=selectedOption;
	  		this.getStudentList(selectedOption);
	    };

	    //Student List
	    this.proxy_marking=false;
  		this.orderBy='rollno';
  		this.students=[];
  		this.students_proxy=[];
  		this.m_avtar="avatar2.png";
  		this.f_avtar="avatar6.png";
  		this.attendanceButtonState=Array();
  		this.attendanceButtonState["state"]=0;
  		this.attendanceButtonState["state_text"]=['', 'Mark Attendance', 'Attendance Saved', 'Update Attendance'];

  		this.getStudentList =function(course_component_id)
  		{
  			course.getCourseEnrollment(course_component_id).then(function(data){
			vm.students=data;

  			console.log(vm.students);
  			vm.attendanceButtonState["state"]=1;
  			vm.students_proxy=[];  			
	  		vm.loadAttendence();
	  		angular.element(document.getElementById('studentlistview')).scope().$applyAsync();		

  			});
  		}
  		/*this.getStudentList(1);*/
  		this.setOrderBY =function(val){
  			vm.orderBy=val;
  		}

  		this.markProxy= function(rollno){
  			if(vm.proxy_marking==false)
  				vm.proxy_marking=true;
  			var roll_index = vm.students.findIndex(function(element) { return (element.rollno ==rollno); });
  			if(typeof (vm.students[roll_index].proxy) === 'undefined' || vm.students[roll_index].proxy =='P')
  			{
  				vm.students[roll_index].proxy='A';
  			}
  			else if(vm.students[roll_index].proxy =='A')
  			{
  				vm.students[roll_index].proxy='P';
  			}
  			alert("rollno"+rollno+ " name: " + vm.students[roll_index].name );

  		}

  	this.saveAttendance=function() {
  		if(typeof(vm.fromTime)=="undefined"||typeof(vm.toTime)=="undefined"){
  			vm.showInfoErrorToast();
  			return;
  		}
  		var param = {'course_faculty_year_id' : vm.component_val,
           'date': ( vm.classDate.getFullYear()+"-"+vm.classDate.getMonth()+"-"+vm.classDate.getDate() ),
           'start_time': (vm.fromTime.getHours()+ ":" +vm.fromTime.getMinutes()+ ":"+vm.fromTime.getSeconds() ),
           'end_time': ( vm.toTime.getHours()+ ":" +vm.toTime.getMinutes()+ ":"+vm.toTime.getSeconds() )
	    };	    
	    alert("param: "+ JSON.stringify(param));
	    console.log("param: "+ JSON.stringify(param));
  		timetable.addClass(param).then(function(data) {
  			console.log("class: "+ JSON.stringify(data));
	  		alert("alert pop up"+ JSON.stringify(data));


	  		if(typeof(data["class_id"])!="undefined") {
	  			var callback_arrlen=vm.students.length;
	  			var callback_counter=0;

	  			vm.students.forEach( function(element){
	  				var studentProxyParam=Array();
	  				studentProxyParam["class_id"]=data["class_id"];
	  				studentProxyParam["rollno"]=element.rollno;
	  				if(typeof(element.proxy)!="undefined")
		  				studentProxyParam["proxy"]=element.proxy;
		  			else if(vm.attendanceButtonState["state"]==2 || vm.attendanceButtonState["state"]== 3){
		  				var set_proxy = vm.students_proxy.find(function(nested_element){
		  					return nested_element.rollno == element.rollno;
			  				});
		  				if(set_proxy&&(set_proxy.proxy=='P')&&(set_proxy.proxy=='A'))
			  				studentProxyParam["proxy"]= set_proxy.proxy;
  						else
	  						studentProxyParam["proxy"]="P";
		  			}
		  			else{
		  				studentProxyParam["proxy"]="P";
		  				alert(JSON.stringify(studentProxyParam));
		  			}
		  			console.log(studentProxyParam.proxy	+":"+studentProxyParam.rollno);
	  				timetable.addAttendance(studentProxyParam)
	  				.then(function(response) {
		  				console.log("attendance marked:"+JSON.stringify(studentProxyParam.proxy));
						
					//callback	
		  				if(++callback_counter==callback_arrlen){
		  					vm.loadAttendence();
		  				}

		  			},function(response,param)
		  			{
		  				console.log("attendance marked failed:"+JSON.stringify(studentProxyParam)+	":"+JSON.stringify(studentProxyParam));
		  				console.log("insert failed--------------------"+JSON.stringify(param)+JSON.stringify(response));
		  				timetable.updateAttendance(studentProxyParam)
				    	.then(function(response){
				    		console.log("updated");
				    		//callback	
			  				if(++callback_counter==callback_arrlen){
			  					vm.loadAttendence();
			  				}
			    		},function(response){
		    				console.log("update failed--------------------");
		    					//callback	
				  				if(++callback_counter==callback_arrlen){
				  					vm.loadAttendence();
				  				}
			    		});
		  			}
		  			);
			  	});
			  		  		vm.attendanceButtonState["state"]=2;
	  		}
  		});
  	}

  	this.loadAttendence = function(){
  		alert("loading Attendance............");
		vm.attendanceButtonState["state"]=1;
		vm.students_proxy=[];
		vm.students.forEach(function(element){
			if(typeof(element["proxy"])!=="undefined")
				delete element["proxy"];
		});	
  		var param = {'course_faculty_year_id' : vm.component_val,
           'date': ( vm.classDate.getFullYear()+"-"+vm.classDate.getMonth()+"-"+vm.classDate.getDate() ),
           'start_time': (vm.fromTime.getHours()+ ":" +vm.fromTime.getMinutes()+ ":"+vm.fromTime.getSeconds() ),
           'end_time': ( vm.toTime.getHours()+ ":" +vm.toTime.getMinutes()+ ":"+vm.toTime.getSeconds() )
	    };	
	    alert("param: "+ JSON.stringify(param));
	    console.log("param: "+ JSON.stringify(param));
  		timetable.checkClass(param).then(function(data){;
  			console.log("check: "+ JSON.stringify(data));
	  		alert("alert check pop up"+ JSON.stringify(data));
	  		if(typeof(data[0]["class_id"]) != "undefined")
	  		{
	  			var attendance= Array();
	  			timetable.getAttendance(data[0]["class_id"]).then(function(data) {
	  				vm.students_proxy=data;
	  				console.log("attendance:"+JSON.stringify(data));
	  			angular.element(document.getElementById('studentlistview')).scope().$applyAsync();	
	  			});
	  			vm.attendanceButtonState["state"]=3;
	  			///
	  		}
  		});

  	}
 this.showInfoErrorToast = function() {
    var pinTo = "bottom right";

    $mdToast.show(
      $mdToast.simple()
        .textContent('Invalid Date!')
        .position(pinTo )
        .hideDelay(3000)
    );
  };
  	this.popup = function(){
  		alert("popup alert");
  	}
  	/*this.loadTimetable =function(course_id)
	{
		alert("loading");
		faculty.setCourse($stateParams.username, course_data);
		$state.go("facultyhome.attendance.timetable");
	};
	this.loadAttendenceview =function(course_id, course_data)
	{
		alert("sdfasdf");
		faculty.setCourse(course_id, course_data);
		$state.go("facultyhome.attendance.studentlist");
	}*/
	this.loadAttendenceTable = function(){
		$state.go("facultyhome.attendance.table");
	}

  }]);
