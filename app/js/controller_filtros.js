var app = angular.module('myApp', ['angularUtils.directives.dirPagination']);

app.controller('customersFiltro', function ($scope, $http, $window) {

	$scope.logado = window.sessionStorage.getItem('user').toUpperCase();

	console.log($scope.logado);

	$scope.Refrech = function () {

		window.location = 'filtro.html';

		
	}
	// abrir modalv - feedback
	$scope.abrir_modal = function (feedback) {

        var feedback = feedback;
  
                bootbox.dialog({
                    message: feedback ,
                    buttons: {
                        cancel: {
                            label: "<i class='fa fa-times'></i> Fechar",
                            className: 'btn-danger',

                        },
           
								} 
							});
           
   }
	// quantidade anexos
	$scope.anexos = function (cpf) {
		var cgc = cpf;
		var dados = { cgc };
		$scope.loading = true;
		$http.post('../src/quantidade_arquivos.rest.php', dados
		).then(
			function (response) {
				$scope.total = response.data;
				//console.log($scope.total); 
				var grupo = $scope.total;
				for (var g in grupo) {
					var result = grupo[g];
					var quantidade = result.quantidade;

					//console.log(quantidade);

                 if(quantidade > 0){

					$scope.janela_arquivos = function (cgc, nome, logado) {

						$window.open('../src/arquivos.rest.php?cgc='+cgc+'&nome='+nome+'&logado='+logado+'','','status=no,Width=1500,Height=420,left=40,top=375');
					} 

				 } else {
					bootbox.dialog({
						message: '<font color="red"><i class="fa fa-exclamation-triangle" aria-hidden="true"> Cliente não possui anexos!!!</i></font>',
						closeButton: false	,
						size: 'small'
					});
					window.setTimeout(function () {
						bootbox.hideAll();
					}, 2000);		
				}
				}
			  
			}).catch(function (err) {

			}).finally(function () {
				$scope.loading = false;
			});
	}

	$scope.carregar = function (statusfeedback) {

		var statusfeed = statusfeedback;

		var data = { statusfeed };
		//console.log(data);
		$scope.loading = true;

		$http.post(
			'../src/filtro.rest.php', data
		).then(
			function (response) {
				$scope.feedback = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {
				$scope.loading = false;
			});
	}

	$scope.carregar();

	$scope.statusbom = function () {

		$http.post(
			'../src/statusbom.rest.php',
		).then(
			function (response) {
				$scope.bom = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {

			});
	}
	$scope.statusbom();

	$scope.statusexcelente = function () {
        
		$http.post(
			'../src/statusexcelente.rest.php',
		).then(
			function (response) {
				$scope.excelente = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {
			
			});
	}
	$scope.statusexcelente();

	$scope.statusruim = function () {

		$http.post(
			'../src/statusruim.rest.php',
		).then(
			function (response) {
				$scope.ruim = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {

			});
	}
	$scope.statusruim();

	$scope.statusregular = function () {

		$http.post(
			'../src/statusregular.rest.php',
		).then(
			function (response) {
				$scope.regular = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {

			});
	}
	$scope.statusregular();

	$scope.statuspessimo = function () {

		$http.post(
			'../src/statuspessimo.rest.php',
		).then(
			function (response) {
				$scope.pessimo = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {

			});
	}
	$scope.statuspessimo();

	$scope.statusavaliar = function () {

		$http.post(
			'../src/statusavaliar.rest.php',
		).then(
			function (response) {
				$scope.avaliar = response.data;
				//console.log($scope.feedback);
			}).catch(function (err) {

			}).finally(function () {

			});
	}
	$scope.statusavaliar();

	$scope.updatestatus = function (idcadastro ,statusf) {
		
		var idcadastro = idcadastro;
		var status_feedback = statusf ;
		var data = { idcadastro, status_feedback };

		$http.post(
			'../src/updatestatus.rest.php', data
		).then(
			function (response) {
				$scope.update = response.data;
				//console.log($scope.feedback);
				//$window.location = 'filtro.html';
			}).catch(function (err) {

			}).finally(function () {
				$scope.statusavaliar();$scope.statusexcelente();$scope.statusbom();$scope.statusregular();$scope.statusruim();$scope.statuspessimo();
			});
	}



});




