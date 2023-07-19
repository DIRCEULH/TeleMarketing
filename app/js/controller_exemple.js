var app = angular.module('myApp', []);

app.controller('customersCtrl', function ($scope, $http) {


   $scope.logado = window.sessionStorage.getItem('user');

});