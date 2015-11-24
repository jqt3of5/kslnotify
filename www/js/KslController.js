'use strict';

kslApp.controller('KslController',
function KslController($scope, $http) {
    $scope.submitted = false;
    $scope.notification = {email:"", name:"", url:""};
    $scope.emailStatusClass = '';
    $scope.nameStatusClass = '';
    $scope.urlStatusClass = '';

    $scope.submitNotification = function()
    {
	if (validate())
	{
	    //submit the notification object to the server
	    $http.post('addNotification.php',$scope.notification, {})
		.then(function success(response) {
		    $scope.submitted = true	    
		}, function error(response) {
		    //oho, error!
		});
	}
    }
    $scope.createAnother = function()
    {
	$scope.emailStatusClass = '';
	$scope.nameStatusClass = '';
	$scope.urlStatusClass = '';
	$scope.notification = {email:"", name:"", url:""};
	$scope.submitted = false
    }
    function validate()
    {
	var result = true;
	if ($scope.notification.email == false)
	{
	    $scope.emailStatusClass = 'error';
	    result = false;
	}
	if($scope.notification.name == false)
	{
	    $scope.nameStatusClass = 'error';
	    result = false;
	}
	if($scope.notification.url == false)
	{
	    $scope.urlStatusClass = 'error';
	    result = false;
	}
	return result;
    }
})


