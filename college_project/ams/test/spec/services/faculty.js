'use strict';

describe('Service: faculty', function () {

  // load the service's module
  beforeEach(module('amsApp'));

  // instantiate service
  var faculty;
  beforeEach(inject(function (_faculty_) {
    faculty = _faculty_;
  }));

  it('should do something', function () {
    expect(!!faculty).toBe(true);
  });

});
