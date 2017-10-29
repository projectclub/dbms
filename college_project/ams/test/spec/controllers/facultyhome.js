'use strict';

describe('Controller: FacultyhomeCtrl', function () {

  // load the controller's module
  beforeEach(module('amsApp'));

  var FacultyhomeCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    FacultyhomeCtrl = $controller('FacultyhomeCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(FacultyhomeCtrl.awesomeThings.length).toBe(3);
  });
});
