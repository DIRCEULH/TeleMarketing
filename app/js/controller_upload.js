'use strict';

angular.module('myApp', ['angularFileUpload', 'angularUtils.directives.dirPagination'])

    .controller('customersCtrl', ['$scope', 'FileUploader', '$http', '$window', function ($scope, FileUploader, $http,$window) {

        $scope.clientes = [];
        $scope.cgc = [];
        $scope.logado = window.sessionStorage.getItem('user').toUpperCase();

        $scope.log = function (cgc, nome) {

            var usuario = $scope.logado;
            var datalog = new Date();
            var dia = datalog.getDate();
            var mes = datalog.getMonth() + 1;
            var ano = datalog.getFullYear();

            var horas = new Date().getHours();
            if (horas < 10) {
                horas = "0" + horas;
            }
            var minutos = new Date().getMinutes();
            if (minutos < 10) {
                minutos = "0" + minutos;
            }

            var dataa =  [dia, mes, ano].join('/');

            var horaa = [horas, minutos].join(':');

            var dataatual = dataa +' '+ horaa ;
            
            var cgc = cgc;
            var nome = nome;

            var dados = {usuario,dataatual,cgc,nome};

            //console.log(dados);

            $http.post('../src/log.rest.php', dados

            ).then(
                function (response) {
                    $scope.logs = response.data;
                    console.log($scope.logs);

                }).catch(function (err) {
                    bootbox.alert('<font color= "red"><i class="fa fa-bug" aria-hidden="true"></i> Error!! ');
                    window.setTimeout(function () {
                        bootbox.hideAll();
                    }, 2000);
                })
                .finally(function () {
                   

                });

            }

        $scope.anexos = function () {

            var cgc = $scope.cgc;

            var dados = { cgc };

            $scope.loading = true;

            $http.post('../src/quantidade_arquivos.rest.php', dados

            ).then(
                function (response) {
                    $scope.total = response.data;
                    console.log($scope.total);             
                  
                }).catch(function (err) {

                }).finally(function () {
                    $scope.loading = false;
                });
        }

        $scope.janela_arquivos = function (cgc, nome, logado) {

            $window.open('../src/arquivos.rest.php?cgc='+cgc+'&nome='+nome+'&logado='+logado+'','','status=no,Width=1500,Height=420,left=40,top=375');
        }

        $scope.loadingupload = true; 
        $scope.carregar = function () {
            var cgc = $scope.cgc
            var dados = { cgc };
            if (cgc != '') {
                $scope.loading2 = true; 
                $http.post('../src/clientes.rest.php', dados
                ).then(
                    function (response) {
                        $scope.clientes = response.data;
                        //console.log($scope.clientes);
                        $scope.loading2 = false; 
                        $scope.loadingupload = false; 
                        var grupo = $scope.clientes;
                        for (var g in grupo) {
                            var result = grupo[g];
                            var cnpj = result.CGC;  
                            uploader = $scope.uploader = new FileUploader({ url: '../src/upload.rest.php?cgc=' + cnpj + '' });

                            $scope.uploader.onCompleteItem = function(fileItem, response, status,headers) {
                                var grupo = response;
                                for (var g in grupo) {
                                    var result = grupo[g];
                                    var validacao = result.answer;
                                    var extensao = result.extensao;
                                    //console.log(validacao);
                                }

                                
                                if(validacao == '0'){

                             
                                    bootbox.alert('<font color= "red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Esta extensão ' + extensao + ' não é valida!!! A imagem não foi salva!!! <font>');
                                    window.setTimeout(function () {
                    
                                        bootbox.hideAll();
                                    }, 6000);
                                
                                 } else {

                                   
                                    bootbox.dialog({
                                        message: ' <font color= "green"><i class="fa fa-check-square-o" aria-hidden="true"></i> Arquivo ' + extensao + ' salvo com sucesso!!! <font>',
                                        closeButton: false	,
                                        size: 'small'
                                    });
                                    window.setTimeout(function () {
                                        bootbox.hideAll();
                                    }, 2000);


                                 }
                            }

                        }

                        
                        $scope.uploader.onAfterAddingFile = function (fileItem) {


                            if(fileItem.file.size > 4893954){
                                bootbox.alert('<font color= "red"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> O arquivo excedeu o limite de tamanho de 2M!!!  <font>');
                                window.setTimeout(function () {
                
                                    bootbox.hideAll();
                                    $scope.carregar();
                                }, 2000);
                               
                             }



                        }

                        if (!cnpj) {
                            bootbox.alert('<font color= "red"><i class="fa fa-bug" aria-hidden="true"></i> Nada encontrado com este CNPJCPF!! ');
                            window.setTimeout(function () {
                                bootbox.hideAll();
                            }, 2000);

                        }


                    }).catch(function (err) {
                        bootbox.alert('<font color= "red"><i class="fa fa-bug" aria-hidden="true"></i> Nada encontrado com este CNPJCPF!! ');
                        window.setTimeout(function () {
                            bootbox.hideAll();
                        }, 2000);
                    })
                    .finally(function () {
                        $scope.loading2 = false;

                    });
            } else {
                bootbox.alert('<font color= "red"><i class="fa fa-bug" aria-hidden="true"></i> Campo Pesquisa obrigatório!! ');
                window.setTimeout(function () {
                    bootbox.hideAll();
                }, 2000);
            }
        }
    


        var uploader = $scope.uploader = new FileUploader({ url: '../src/upload.rest.php' });
        //console.log(uploader);

        //$scope.carregar ();

        // FILTERS
        // a sync filter
        uploader.filters.push({
            name: 'syncFilter',
            fn: function (item /*{File|FileLikeObject}*/, options) {
                //console.log('syncFilter');
                return this.queue.length < 10;
            }
        });

        // an async filter
        uploader.filters.push({
            name: 'asyncFilter',
            fn: function (item /*{File|FileLikeObject}*/, options, deferred) {
                //console.log('asyncFilter');
                setTimeout(deferred.resolve, 1e3);

            }

        });

        $scope.cadastroinbox = function (cgc,nome,email,telefone,cep,endereco,bairro, cidade,uf,idclifor){

            var cgc = cgc;
            var nome = nome;
            var email = email;
            var telefone = telefone;
            var cep = cep;
            var endereco = endereco;
            var bairro = bairro;
            var cidade = cidade;
            var uf = uf;
            var idclifor = idclifor;
            var feedback_cliente = $scope.feedbackc;
            var feedback_empresa = $scope.feedbacke;
            var logado = $scope.logado;
            var status_origem = $scope.statuso;
            var status_feedback = $scope.statusf;

     
            var dados = {cgc,nome,email,telefone,cep,endereco,bairro, cidade,uf,idclifor,feedback_cliente,feedback_empresa,logado,status_origem,status_feedback};
             //console.log(dados);
             
             $scope.loading = true;

             if( feedback_cliente != null && feedback_empresa != null  && status_origem != null && status_feedback != null   ){
             $http.post(
                 '../src/cadastroinbox.rest.php',dados
         
             ).then(
                 function (response) {
                     $scope.cadastroinbox = response.data;
                     //console.log($scope.clientes);
                     bootbox.alert('<font color= "green"><i class="fa fa-check" aria-hidden="true"></i>  Salvo com sucesso!! ');
                     window.setTimeout(function () {
                         bootbox.hideAll();
                         window.location = 'index.html';
                     }, 2000);

                   
      
                 }).catch(function (err) {
 
                 }).finally(function () {
                     $scope.loading = false;
                 });

                } else {

                    bootbox.alert('<font color= "red"><i class="fa fa-bug" aria-hidden="true"></i>Rever campos obrigatórios!! ');
                    window.setTimeout(function () {
                        bootbox.hideAll();
                    }, 2000);
            
                }
         }
  

        // CALLBACKS

        uploader.onWhenAddingFileFailed = function (item /*{File|FileLikeObject}*/, filter, options) {
            console.info('onWhenAddingFileFailed', item, filter, options);
            $scope.anexos();
        };
        uploader.onAfterAddingFile = function (fileItem) {
            console.info('onAfterAddingFile', fileItem);
            $scope.anexos();
        };
        uploader.onAfterAddingAll = function (addedFileItems) {
            console.info('onAfterAddingAll', addedFileItems);
            $scope.anexos();
        };
        uploader.onBeforeUploadItem = function (item) {
            console.info('onBeforeUploadItem', item);
            $scope.anexos();
        };
        uploader.onProgressItem = function (fileItem, progress) {
            console.info('onProgressItem', fileItem, progress);
            $scope.anexos();
        };
        uploader.onProgressAll = function (progress) {
            console.info('onProgressAll', progress);
            $scope.anexos();
        };
        uploader.onSuccessItem = function (fileItem, response, status, headers) {
            console.info('onSuccessItem', fileItem, response, status, headers);
            $scope.anexos();
        };
        uploader.onErrorItem = function (fileItem, response, status, headers) {
            console.info('onErrorItem', fileItem, response, status, headers);
            $scope.anexos();
        };
        uploader.onCancelItem = function (fileItem, response, status, headers) {
            console.info('onCancelItem', fileItem, response, status, headers);
            $scope.anexos();
        };
        uploader.onCompleteItem = function (fileItem, response, status, headers) {
            console.info('onCompleteItem', fileItem, response, status, headers);
            $scope.anexos();

            if (response.answer == 'File transfer extension failed') {
                bootbox.alert('<font color= "red"> Esta extensão ' + response.extensao + ' não é valida!!! A imagem não foi salva <font>');
                window.setTimeout(function () {

                    bootbox.hideAll();
                }, 6000);
            }
        };
        uploader.onCompleteAll = function () {
            console.info('onCompleteAll');
            bootbox.alert('<font color= "green"> Arquivo enviado com sucesso!! ');
            window.setTimeout(function () {

                bootbox.hideAll();
            }, 1000);
            $scope.anexos();
        };

        console.info('uploader', uploader);

    }]);
