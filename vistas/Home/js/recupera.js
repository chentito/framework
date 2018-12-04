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
function recuperaPassword() {
    var email = $('#recupera_email_usr').val();

    $.post( pathSite + '/Home/recuperaAcceso/email='+email+'/' , function( respuesta ){
        dialogoAviso( 'Error de acceso' , respuesta );
        $("#recupera_login_form").trigger( 'reset' );
    });

    return false;
}
