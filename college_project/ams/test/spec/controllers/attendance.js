'use strict';

describe('Controller: AttendanceCtrl', function () {

  // load the controller's module
  beforeEach(module('amsApp'));

  var AttendanceCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AttendanceCtrl = $controller('AttendanceCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(AttendanceCtrl.awesomeThings.length).toBe(3);
  });
});
