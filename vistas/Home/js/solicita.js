/* 
 * Funcionalidades para el acceso al sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */
var pathSite = $('#absolutePathSite').val();

/*
 * Funcion que envia los parametros de recuperacion de contrasena al sistema
 * @returns {Boolean}
 */
function solicitaPassword() {
    var email   = $( '#solicita_email_usr' ).val();
    var nombre  = $( '#solicita_nombre_usr' ).val();
    var usuario = $( '#solicita_email_usr' ).val().split( '@' );
    var pass    = generaContrasenia();
    var err     = '';
    var ban     = 0;
    
    if( nombre == "" ) {
        err += '&bull;No ha proporcionado su nombre<br>';
        ban ++;
    }
    if( email == "" ) {
        err += '&bull;No ha proporcionado una cuenta de correo';
        ban ++;
    }

    if( ban > 0 ) {
        dialogoAviso( 'Error solicitud de Acceso' , err );
    } else {
        $.post( pathSite + '/Home/solicitaAcceso/email='+email+'|nombre='+escape(nombre)+'|usuario='+usuario[0]+'|pass='+pass+'/' , function( respuesta ){
            if( respuesta=='1' )respuesta="Los datos de acceso se han enviado a su correo electronico.";
            dialogoAviso( 'Solicitud de Acceso' , respuesta );
            $("#solicita_login_form").trigger( 'reset' );
        });
    }
    return false;
}

function generaContrasenia() {
    numeros      = [ 0 , 1 , 2 , 3 , 4 , 5 , 6 , 7 , 8 , 9 ];
    letras       = [ 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'];
    var password = '';

    for( i = 0 ; i < 6 ; i ++ ) {
        password += letras[Math.floor(Math.random() * letras.length)];
    }

    for( j = 0 ; j < 3 ; j ++ ) {
        password += numeros[Math.floor(Math.random() * numeros.length)];
    }

    return password;
}