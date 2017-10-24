'use strict';

describe('Controller: FacultycourseCtrl', function () {

  // load the controller's module
  beforeEach(module('amsApp'));

  var FacultycourseCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    FacultycourseCtrl = $controller('FacultycourseCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(FacultycourseCtrl.awesomeThings.length).toBe(3);
  });
});
