var app = angular.module('myApp', []);

app.controller('customersCtrl', function ($scope, $http) {


    $scope.login = function () {

        result_login = [];

        var users = $scope.users.toUpperCase();
        var password = $scope.password;
        var datas = { users, password };

        //console.log(datas);

        if (users != null || password != null) {

            $http.post("../src/login.rest.php", datas)
                .then(function (response) {
                $scope.result_login = response.data;
                    //console.log($scope.result_login);
					
					var grupo = $scope.result_login;
					
					for( var g in grupo){
						
						var autentic = grupo[g];
						
						var result_usuario = autentic.autenticacao;	
						
					}
                    //console.log(result_usuario);

                    if (result_usuario == 'ok') {
                        
                       window.sessionStorage.setItem('user', $scope.users);
                       //bootbox.alert('Ok!!');
                       window.location = "../app/index.html";
                       

                    } else{


                        bootbox.alert('Senha ou usuario incorreto!!');

                    }

                });

        } else {
            bootbox.alert('Digite usuário e senha!!');
        }


    }

});
