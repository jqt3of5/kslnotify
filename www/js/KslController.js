'use strict';

kslApp.controller('KslController',
function KslController($scope, $http) {
    $scope.notification = {email:"", name:"", url:""};
    $scope.emailStatusClass = '';
    $scope.nameStatusClass = '';
    $scope.urlStatusClass = '';

    //page constants
    $scope.privacy_policy = "privacy_policy"
    $scope.contact = "contact"
    $scope.add_new = "add_new"
    $scope.after_submit = "after_submit"
    $scope.page = $scope.add_new

    $scope.submitNotification = function()
    {
	if (validate())
	{
	    //submit the notification object to the server
	    $http.post('addNotification.php',$scope.notification, {})
		.then(function success(response) {
		    $scope.page=$scope.after_submit
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
	$scope.page = $scope.add_new
    }
    $scope.showContact = function()
    {
	$scope.page = $scope.contact
    }
    $scope.showPrivacyPolicy = function()
    {
	$scope.page = $scope.privacy_policy
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


