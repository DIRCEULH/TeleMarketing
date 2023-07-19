
    var usuario_logado = window.sessionStorage.getItem('user');

    if(usuario_logado == null){

      window.location = 'login.html';
    }
