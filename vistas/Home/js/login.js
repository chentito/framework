/* 
 * Funcionalidades para el acceso al sistema
 * @Autor Carlos Reyes
 * @Fecha Octubre 2018
 */

$(document).ready(function(){
    $( '#btn-login' ).click( function( e ){
        e.preventDefault();
        $( '#btn-login' ).button( 'loading' );
        verificaLogin();
    });
});
var pathSite = $('#absolutePathSite').val();


/*
 * Funcion que envia los parametros de acceso al sistema 
 * @returns {Boolean}
 */
function verificaLogin() {
    var usr      = $('#home_login_usr').val();
    var pswd     = $('#home_login_passwd').val();
    var remember = $('#home_login_remember_me').is(':checked');

    $.post( '/Home/verificaAcceso/usr='+usr+'|passwd='+pswd+'|remember='+remember+'/' , function( acceso ){
        if( acceso == 1 ) {
                location.replace('/Home/');
            }else{
                $( '#btn-login' ).button( 'reset' );
                $( '#login-alert' ).css( 'display' , 'block' );
                $( '#login-alert' ).html( acceso );
                $( '#loginForm' ).trigger( 'reset' );
                setTimeout( ocultaMensajeError , 15000 );
        }
    });
    
    return false;
}

function ocultaMensajeError() {
    $( '#login-alert' ).css( 'display' , 'none' );
    $( '#login-alert' ).html( '' );
}
