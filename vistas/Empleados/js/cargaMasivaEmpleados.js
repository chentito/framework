/*
 * Controlador de la interfaz grafica de la alta masiva de empleados
 * con las funcionalidades del sistema
 * @Autor Mexagon.net / Jose Gutierrez
 * @Fecha Febrero 2016
 */

//var x = 1;
//var max_fields = 20;
//var wrapper = $(".input_fields_wrap");
$('#altaEmpleados_botonAdjuntaLayout').button();
$('#altaEmpleados_LayoutAdjuntar').button();

function procesaAltaMasivaLayoutEmpleados() {
    banError = 0;
    mensaje  = '';
    
    if( $('#altaEmpleados_comboClientes').val() == '' ){
        mensaje += 'No ha seleccionado un cliente<br>';
        banError ++;
    }
    
    if( $('#altaEmpleados_LayoutAdjuntar').val() == '' ){
        mensaje += 'No ha seleccionado un layout<br>';
        banError ++;
    }
    
    if( banError > 0 ){
            dialogoAviso( 'Error al procesar Layout' , mensaje );
        }else{
            abreModalSistema();
            $( '#altaEmpleados_Formulario' ).submit();
    }

    return false;
}

function resultadoProcesoLayoutEmpleados( mensaje ) {
    cierraModalSistema();
    dialogoAviso( 'Alta de Layout' , mensaje );
    $( '#altaEmpleados_Formulario' ).trigger( 'reset' );
}
