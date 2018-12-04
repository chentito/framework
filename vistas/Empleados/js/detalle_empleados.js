/*
 *  * Controlador de la interfaz grafica del detalle de empleados
 *   * con las funcionalidades del sistema
 *    * @Autor Mexagon.net / Jose Gutierrez
 *     * @Fecha Febrero 2016
 *      */

$('#altaEmpleados_ImagenAdjuntarUpdate').button().change(function(e){ return adjuntaImagen(); });

function adjuntaImagen(){
    abreModalSistema();
    $( '#detalleEmpleadosIndividual' ).submit();
    
    return false;
}


function resultadoUpdateImagenEmpleados( mensaje ) {
    cierraModalSistema();
    if(mensaje == "1"){ msg = "La imagen ha sido actualizada correctamente."; }
    else{ msg = "Ocurrio un error, por favor intente mas tarde."; }
    dialogoAviso( 'Detalle Empleado' , msg );
    var date = new Date();
    $("#imgEmpleado").attr("src","/Empleados/generaImagenEmpleado/id="+$('#altaEmpleadosInd_cveEmpleadoUpdate').val()+"|date="+date.getTime()+"/");
}