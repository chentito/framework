/* 
 * Funcionalidades para el acceso al sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */
var pathSite = $('#absolutePathSite').val();

/*
 *  * Funcion que envia los parametros de acceso al sistema 
 *   * @returns {Boolean}
 *    */
function verificaLogin() {
    var usr      = $('#candidato_login_usr').val();
    var pswd     = $('#candidato_login_passwd').val();
    var remember = $('#candidato_login_remember_me').is(':checked');

    $.post( pathSite + '/home/verificaAccesoCandidatos/usr='+usr+'|passwd='+pswd+'|remember='+remember+'/' , function( acceso ){
        if( acceso == 1 ){
                location.replace('/Home/');
            }else{
                dialogoAviso( 'Error de acceso' , acceso );
                $("#home_login_form").trigger( 'reset' );
        }
    });
    
    return false;
}

