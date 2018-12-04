/* 
 * Interaccion de interfaz grafica con controlador en la configuracion de
 * cuenta SMTP
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Diciembre 2015
 */

/*
 * Oculta el contenedor de envio de prueba de correo electronico
 */
$('#sistema_configSMTP_contenedorPrueba').hide();

/*
 * Oculta el dialogo de cargando del envio de prueba de correo electronico
 */
$('#sistema_configSMTP_contenedorPruebaEnviando').hide();

/*
 * Guarda la configuracion dada de alta por el usuario
 */
$('#sistema_configSMTP_btnGuarda').button().click( function(){
    if( $('#sistema_configSMTP_testing').val() == false ){
            dialogoAviso( 'Error al guardar configuraci&oacute;n' , 'Para guardar su confguracion es necesario realizar una prueba exitosa' );
        }else{
            $.post( '../Sistema/guardaSMTP/'+$('#sistema_formConfig').serialize()+'/' , function( mensaje ) {
                dialogoAviso( 'Configuraci&oacute;n SMTP' , mensaje );
            });
    }
    return false;
});

/*
 * Boton que envia la prueba de configuracion de correo electronico
 */
$('#sistema_configSMTP_pruebaEnvia').button().click( function() {
    if( ! patronEmail.test( $('#sistema_configSMTP_enviarPruebaA').val() ) ){
        dialogoAviso( 'Error al enviar prueba' , 'No se ha proporcionado un correo electr&oacute;nico v&aacute;lido' );
        return false;
    }
    $('#sistema_configSMTP_contenedorPruebaEnviando').show();
    $('#sistema_configSMTP_testing').val( true );
    $('#sistema_configSMTP_testing').val( false );

    $.post( '../Sistema/testSMTP/' , $('#sistema_formConfig').serialize() , function( mensaje ){
        if( mensaje == 1 ){
                /* Envio de prueba correcto */
                dialogoAviso( 'Configuraci&oacute;n SMTP' , 'Correo enviado exitosamente, puede guardar su configuraci&oacute;n' );
            }else{
                /* Error al realizar el envio de pruebas */
                dialogoAviso( 'Configuraci&oacute;n SMTP' , 'Error al hacer prueba de env&iacute;o, revise su configuraci&oacute;n.[' + mensaje + ']' );
        }
        ocultaElementosEnvioPrueba();
    });

    return false;
});

/*
 * Funcion que oculta los elementos de envio de correo de pruebas 
*/
function ocultaElementosEnvioPrueba() {
    $('#sistema_configSMTP_contenedorPrueba').hide();
    $('#sistema_configSMTP_contenedorPruebaEnviando').hide();
    $('#sistema_configSMTP_enviarPruebaA').val( "" );
}

/*
 * Boton que cancela el envio de prueba de correo electronico
 */
$('#sistema_configSMTP_pruebaCancela').button().click( function(){
    ocultaElementosEnvioPrueba();
    return false;
});

/*
 * Boton que abre el dialogo para hacer el envio de prueba de correo electronico
 */
$('#sistema_configSMTP_btnPrueba').button().click( function(){
    $('#sistema_configSMTP_contenedorPrueba').show();
    return false;
});
