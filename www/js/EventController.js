'use strict';

eventsApp.controller('EventController',
function EventController($scope) {
    $scope.event = {
	name: 'asdf',
	date: '1/1/2013',
	time: '20:30:00 PM'
    }
})
