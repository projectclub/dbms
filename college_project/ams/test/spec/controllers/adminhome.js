'use strict';

describe('Controller: AdminhomeCtrl', function () {

  // load the controller's module
  beforeEach(module('amsApp'));

  var AdminhomeCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AdminhomeCtrl = $controller('AdminhomeCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(AdminhomeCtrl.awesomeThings.length).toBe(3);
  });
});
