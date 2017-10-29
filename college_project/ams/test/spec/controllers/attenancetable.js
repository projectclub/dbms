'use strict';

describe('Controller: AttenancetableCtrl', function () {

  // load the controller's module
  beforeEach(module('amsApp'));

  var AttenancetableCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    AttenancetableCtrl = $controller('AttenancetableCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(AttenancetableCtrl.awesomeThings.length).toBe(3);
  });
});
