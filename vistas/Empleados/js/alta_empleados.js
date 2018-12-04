/*
 *  * Controlador de la interfaz grafica de la alta de empleados
 *   * con las funcionalidades del sistema
 *    * @Autor Mexagon.net / Jose Gutierrez
 *     * @Fecha Enero 2016
 *      */

$('#altaEmpleados_botonGuardaEmpleado').button().click(function(e){ return adjuntaImagen(); });
$('#altaEmpleados_botonAdjuntaLayout').button();
$('#altaEmpleados_LayoutAdjuntar').button();
$('#altaEmpleados_ImagenAdjuntar').button();
$('#altaEmpleadosInd_fechaNacimiento').datepicker( {dateFormat:"yy-mm-dd", changeYear: true, minDate: -24600, monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"], dayNamesMin: ["Dom","Lun","Mar","Mie","Jue","Vie","Sab"]} ).datepicker();


function validaEmail(value){
    var exp = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
    if(exp.test(value)){
        return true;
    }else{
        return false;
    }
}

function validaCURP(value){
    if(value.length != 18){
        return false;
    }else{
        var exp = /^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$/;
        if(exp.test(value)){
            return true;
        }else{
            return false;
        }
    }
}

function validaRFC(value,colname){
    if(value.length != 12 && value.length != 13){
        return false;
    }else{
        var exp = /^[A-Z,\u00d1,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]?[A-Z,0-9]?[0-9,A-Z]?$/;
        if(exp.test(value)){
            return true;
        }else{
            return false;
        }
    }
}

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
    }else{
        extension  = '.csv';
        extension2 = '.xls';
        ext = ($('#altaEmpleados_LayoutAdjuntar').val().substring($('#altaEmpleados_LayoutAdjuntar').val().lastIndexOf("."))).toLowerCase();
        if( extension != ext && extension2 != ext ){
            mensaje += 'El archivo seleccionado no es CSV ni XLS<br>';
            banError ++;
        }
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

function adjuntaImagen(){
    $("#altaEmpleados_comboClientes1").val($("#altaEmpleados_comboClientes").val());
    
    banError = 0;
    mensaje  = '';
    
    if( $("#altaEmpleados_comboClientes").val() == '' ){
        mensaje += 'No ha seleccionado un cliente<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_nombre").val() == '' ){
        mensaje += 'Favor de ingresar el nombre<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_aPaterno").val() == '' ){
        mensaje += 'Favor de ingresar el apellido paterno<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_aMaterno").val() == '' ){
        mensaje += 'Favor de ingresar el apellido materno<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_email").val() == '' ){
        mensaje += 'Favor de ingresar el email<br>';
        banError ++;
    }else{
        statusEmail = validaEmail($("#altaEmpleadosInd_email").val());
        if(statusEmail == false){
            mensaje += 'Favor de ingresar un email correcto<br>';
            banError ++;
        }
    }
    if( $("#altaEmpleadosInd_nss").val() == '' ){
        mensaje += 'Favor de ingresar el NSS<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_fechaNacimiento").val() == '' ){
        mensaje += 'Favor de ingresar la fecha de nacimiento<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_lugarNacimiento").val() == '' ){
        mensaje += 'Favor de ingresar el lugar de nacimiento<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_estadoCivil").val() == '' ){
        mensaje += 'Favor de ingresar el estado civil<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_curp").val() == '' ){
        mensaje += 'Favor de ingresar la CURP<br>';
        banError ++;
    }else{
        statusCurp = validaCURP($("#altaEmpleadosInd_curp").val());
        if(statusCurp == false){
            mensaje += 'Favor de ingresar una CURP correcta<br>';
            banError ++;
        }
    }
    if( $("#altaEmpleadosInd_rfc").val() == '' ){
        mensaje += 'Favor de ingresar un RFC<br>';
        banError ++;
    }else{
        statusRFC = validaRFC($("#altaEmpleadosInd_rfc").val());
        if(statusRFC == false){
            mensaje += 'Favor de ingresar un RFC correcto<br>';
            banError ++;
        }
    }
    if( $("#altaEmpleadosInd_codigoPostal").val() == '' ){
        mensaje += 'Favor de ingresar un codigo postal<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_calle").val() == '' ){
        mensaje += 'Favor de ingresar la calle<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_noExterior").val() == '' ){
        mensaje += 'Favor de ingresar el n&uacute;mero exterior<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_noInterior").val() == '' ){
        mensaje += 'Favor de ingresar el n&uacute;mero interior<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_colonia").val() == '' ){
        mensaje += 'Favor de ingresar la colonia<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_estado").val() == '' ){
        mensaje += 'Favor de ingresar el estado<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_localidad").val() == '' ){
        mensaje += 'Favor de ingresar la localidad o ciudad<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_municipio").val() == '' ){
        mensaje += 'Favor de ingresar delegaci&oacute;n o municipio<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_puesto").val() == '' ){
        mensaje += 'Favor de ingresar el puesto<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_ruta").val() == '' ){
        mensaje += 'Favor de ingresar la ruta<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_banco").val() == '' ){
        mensaje += 'Favor de ingresar el banco<br>';
        banError ++;
    }
    if( $("#altaEmpleadosInd_cuenta").val() == '' ){
        mensaje += 'Favor de ingresar la cuenta<br>';
        banError ++;
    }

    if( banError > 0 ){
        dialogoAviso( 'Empleados Individual' , mensaje );
    }else{
        abreModalSistema();
        $( '#empleadosIndividual' ).submit();
    }

    return false;
}

function seleccionaCargaMasivaEmpleados( elemento ) {
    if( $( elemento ).prop( 'checked' ) ){
            $( '#altaEmpleados_MetodoEntradaMasiva' ).attr( 'disabled' , false );
            $( '#altaEmpleados_MetodoEntradaIndividual' ).attr( 'disabled' , true );
            $( '#altaEmpleados_seleccionaEntradaIndividual' ).attr( 'checked' , false );
            $( '#contenedorCargaIndividualEmpleados' ).hide();
            $( '#contenedorCargaMasivaEmpleados' ).show('fast');
        }else{
            $( '#altaEmpleados_MetodoEntradaMasiva' ).attr( 'disabled' , true );
            $( '#altaEmpleados_seleccionaEntradaIndividual' ).attr( 'checked' , true );
            $( '#altaEmpleados_MetodoEntradaIndividual' ).attr( 'disabled' , false );
            $( '#contenedorCargaIndividualEmpleados' ).show('fast');
            $( '#contenedorCargaMasivaEmpleados' ).hide();
    }
}

function seleccionaCargaIndividualEmpleados( elemento ) {
    if( $( elemento ).prop( 'checked' ) ){
            $( '#altaEmpleados_MetodoEntradaIndividual' ).attr( 'disabled' , false );            
            $( '#contenedorCargaIndividualEmpleados' ).show('fast');
            $( '#contenedorCargaMasivaEmpleados' ).hide();
            $( '#altaEmpleados_MetodoEntradaMasiva' ).attr( 'disabled' , true );
            $( '#altaEmpleados_seleccionaEntradaMasiva' ).attr( 'checked' , false );
            $( '#altaEmpleados_botonGuardaEmpleado' ).attr( 'disabled' , false );
        }else{
            $( '#altaEmpleados_MetodoEntradaIndividual' ).attr( 'disabled' , true );
            $( '#contenedorCargaIndividualEmpleados' ).hide();
            $( '#contenedorCargaMasivaEmpleados' ).show('fast');
            $( '#altaEmpleados_MetodoEntradaMasiva' ).attr( 'disabled' , false );
            $( '#altaEmpleados_seleccionaEntradaMasiva' ).attr( 'checked' , true );
    }
}

function buscaDatosSepomex(value){
    var cp = value;
    $.post( "/Empleados/buscaDatosSepomex/",
        {cp:cp},
        function( mensaje ){
            var json = $.parseJSON(mensaje);
            var comboColonia = "";
            var comboMunicipio = "";
            var comboEstado = "";
            var comboCiudad = "";
            $(json).each(function(i,val){
                $.each(val,function(k,v){
                    if(k == "colonia"){
                        comboColonia += "<option value=\'"+v+"\'>"+v+"</option>";
                    }
                    if(k == "estado"){
                        comboEstado = v;
                    }
                    if(k == "municipio"){
                        comboMunicipio = v;
                    }
                    if(k == "ciudad"){
                        comboCiudad = v;
                    }
                });
            }); 
            $("#altaEmpleadosInd_colonia").html(comboColonia);
            $("#altaEmpleadosInd_estado").val(comboEstado);
            $("#altaEmpleadosInd_municipio").val(comboMunicipio);
            $("#altaEmpleadosInd_localidad").val(comboCiudad);
        }
    );
}

function resultadoProcesoEmpleado( mensaje ){    
    cierraModalSistema();    
    $("#altaEmpleadosInd_rutaFinalImg").val(mensaje);
    if(mensaje == "1"){ msg = "La informaci&oacute;n ha sido guardada correctamente."; }
    else{ msg = "Ocurrio un error, por favor intente mas tarde."; }
    dialogoAviso( 'Empleados Individual' , msg );    
    $("#altaEmpleados_comboClientes").val("");
    $("#empleadosIndividual").get(0).reset();
}

/*function select_row( id ){    
    $('body').append( '<div id="muestraDetalleEmpleado" title=".:: Detalle Empleado ::."></div>' );
    $('#muestraDetalleEmpleado').load('/Empleados/muestraDetalleEmpleado/id='+id+'/').dialog({
        modal:true, draggable:false, closeOnEscape: false, resizable:false,width:800,height:520,
        buttons:{
            'Cerrar':function(){
                $( this ).dialog( 'close' );
                $( this ).dialog( 'destroy' );
                $( '#muestraDetalleEmpleado' ).remove();
            },
            'Descargar PDF':function(){
                window.location = '/Empleados/generaPDFEmpleado/id='+id+'/';
            }
        }
    });
}*/

function muestraDetalleEmpleado(){
    id = $( '#CatalogoEmpleados' ).jqGrid ( 'getGridParam' , 'selrow' );
    if( id == undefined ){
        dialogoAviso( 'Error captura informacion' , 'No ha seleccionado un empleado' );
    }else{
        $('body').append( '<div id="muestraDetalleEmpleado" title=".:: Detalle Empleado ::."></div>' );
        $('#muestraDetalleEmpleado').load('/Empleados/muestraDetalleEmpleado/id='+id+'/').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:800,height:520,
            buttons:{
                'Cerrar':function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#muestraDetalleEmpleado' ).remove();
                },
                'Descargar PDF':function(){
                    window.location = '/Empleados/generaPDFEmpleado/id='+id+'/';
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}

function editaEmpleados() {
    id = $( '#CatalogoEmpleados' ).jqGrid ( 'getGridParam' , 'selrow' );
    if( id == undefined ){
        dialogoAviso( 'Error captura informacion' , 'No ha seleccionado un empleado' );
    }else{
        $( 'body' ).append( '<div title=".:: Editar Empleado ::." id="empleadoDetalleModal" name="empleadoDetalleModal" ></div>' );
        $( '#empleadoDetalleModal' ).load( '/Empleados/editarDatosEmpleado/id='+id+'/' ).dialog({
            modal:true,width:850,height:640,draggable:false,resizable:false, closeOnEscape:false,
            buttons:{
                'Cancelar':function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#empleadoDetalleModal' ).remove();
                },
                'Guardar': function(){
                    datos = $( '#editaEmpleado_form' ).serialize();
                    d = datos.replace( /&/g , '|' );
                    $.post( '/Empleados/guardaDatosEmpleadoEdita/'+encodeURIComponent(d)+'/' , function( r ){
                        if( r ){ msj = 'Informaci&oacute;n guardada correctamente'; }
                        else{ msj = 'Error al guardar la informaci&oacite;n, intente m&aacute;s tarde'; }
                        dialogoAviso( 'Captura Datos Empleado' , msj );
                        $( this ).dialog( 'close' );
                        $( this ).dialog( 'destroy' );
                        $( '#empleadoDetalleModal' ).remove();
			$( '#CatalogoEmpleados' ).trigger('reloadGrid');
                    });
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}
