
var app = angular.module('myApp', []);

app.controller('customersLunch', function ($scope, $http) {

   $scope.logado = window.sessionStorage.getItem('user');


   $scope.lunch = function () {

    var usuario = window.sessionStorage.getItem('user');

    var data = { usuario };

    $http.post("../src/lunch.rest.php", data)
        .then(function (response) {
            $scope.result_lunch = response.data;
            //console.log($scope.result_lunch);

        });

}

$scope.lunch();

$scope.status = function () {

    var usu = window.sessionStorage.getItem('user');

    var data = { usu };
    $http.post("../src/status_reserva.rest.php", data)
        .then(function (response) {
            $scope.status_reserva = response.data;
            //console.log($scope.status_reserva);

            if ($scope.status_reserva.length > 0) {
                $scope.status = true;

            } else {
                $scope.status = false;
            }

        });
}

$scope.status();
        
        $scope.reservar = function(usuario, nome, email){

            var usu = usuario;
            var nom = nome;
            var ema = email;

            data = {usu, nom, ema};
			console.log(data);

            if(usu != '' && nom != ''){

            $http.post("../src/reservar.rest.php", data)
            .then(function (response) {
                $scope.reservar = response.data;
                console.log($scope.reservar);
                var horas = new Date().getHours();
                 if(horas < 10){
                 horas = '0' + horas;
                 }
                var minutos = new Date().getMinutes();
                 if(minutos < 10){
                 minutos = '0' + minutos;
                 }
                var horario = horas+':'+minutos;
                var diaseman = new Date();
                var diadasemana = diaseman.getDay();
                 
                 
                if(horario > '09:45'){

                    bootbox.alert({
                        title: "<font color= 'red'>Atenção!!!</font>",
                        message: "<font color= 'red'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Você excedeu o horário de reserva (09:45)!!</font>",
                        callback: function () {
                            console.log('excedeu o horário !');
                        }
                    });

                }else if(diadasemana == '0'|| diadasemana == '6'){
                  
                  
                    bootbox.alert({
                        title: "<font color= 'red'>Atenção!!!</font>",
                        message: "<font color= 'red'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Reseva apenas de segunda a sexta!!</font>",
                        callback: function () {
                            console.log(' apenas de segunda a sexta!');
                        }
                    });
                  
                  
                  }else if($scope.reservar.length > 0 ){
                           
                                             
                    bootbox.alert({
                        title: "<font color= 'red'>Atenção!!!</font>",
                        message: "<font color= 'red'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> Você já realizou a reserva!!</font>",
                        callback: function () {
                            console.log(' Já reservado!');
                        }
                    });
                           
                           
                 }else{

                bootbox.alert('<font color= "green"><i class="fa fa-check-circle-o" aria-hidden="true"></i> Reserva confirmada!!</font>');
                window.setTimeout(function(){
                bootbox.hideAll();
                window.location = 'index.html';
        
                }, 2000);
                  
            }
            });

        }

        }

        $scope.acesso_admin = function () {

            bootbox.prompt("Digite a palavra Chave!",
                function (result) {
                    if (result == 'ADM') {
                        window.location = 'relatorio_lunch.html';
                    } else if (result == null) {
    
                    } else {
                        $scope.acesso_admin();
                    }
                });
    
        }

});
