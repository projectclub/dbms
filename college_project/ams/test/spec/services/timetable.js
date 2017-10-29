'use strict';

describe('Service: timetable', function () {

  // load the service's module
  beforeEach(module('amsApp'));

  // instantiate service
  var timetable;
  beforeEach(inject(function (_timetable_) {
    timetable = _timetable_;
  }));

  it('should do something', function () {
    expect(!!timetable).toBe(true);
  });

});
