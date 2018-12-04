/*
 * Controlador de la interfaz grafica de la alta de usuarios
 * con las funcionalidades del sistema
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */
$( '#altaInventariosInd_fechaIngreso' ).datepicker({
    dateFormat:'yy-mm-dd'
});

var x = 1;
var max_fields = 20;
var wrapper = $(".input_fields_wrap");
$('#altaInventarios_botonGuardaItemLote').button().click(function(e){ return adjuntaImagen(); });
$('#altaInventarios_botonAdjuntaLayout').button();
$('#altaInventarios_LayoutAdjuntar').button();
$("#altaInventarios_ImagenAdjuntar").button();
$('#altaInventariosIndBotonMasLote').button({
    icons: {
      primary: "ui-icon-plus"
    },
    text: false
}).click(function(e){
    e.preventDefault();
    if(x < max_fields){
        x++;
        $(wrapper).append('<tr id="lote'+x+'"><td>Serie:</td><td><input type="text" id="altaInventariosIndLote_serie[]" name="altaInventariosIndLote_serie[]" maxlength="200" /></td><td>Estado:</td><td><input type="text" id="altaInventariosIndLote_estado[]" name="altaInventariosIndLote_estado[]" maxlength="200" /></td><td><button id="delLote'+x+'" onclick="eliminarLote('+x+'); return false;" class="remove_field">Quitar'+x+'</button></td></tr>');
	$('#delLote'+x).button({
            icons: {
              primary: "ui-icon-minus"
            },
            text: false
        });
    }
});

function eliminarLote(x){
    var nombreTR = "lote"+x;
    $('#'+nombreTR).remove().fadeOut(800);
    return false;
}

function adjuntaImagen(){
 //   abreModalSistema();
   // $( '#inventarioIndividual' ).submit();
//    return false;
    $("#altaInventarios_comboAlmacenes1").val($("#altaInventarios_comboAlmacenes").val());
    $("#altaInventarios_comboClientes1").val($("#altaInventarios_comboClientes").val());

    banError = 0;
    mensaje  = '';

    if( $("#altaInventarios_comboAlmacenes").val() == '' ){
        mensaje += 'No ha seleccionado un alamc&eacute;n<br>';
        banError ++;
    }

    if( $("#altaInventarios_comboClientes").val() == '' ){
        mensaje += 'No ha seleccionado un cliente<br>';
        banError ++;
    }
    
    if( $("#altaInventariosInd_nombre").val() == '' ){
        mensaje += 'Favor de ingresar el nombre<br>';
        banError ++;
    }

    if( $("#altaInventarios_descripcion").val() == '' ){
        mensaje += 'Favor de ingresar la descripci&oacute;n<br>';
        banError ++;
    }
    
    if( $("#altaInventariosInd_marca").val() == '' ){
        mensaje += 'Favor de ingresar la marca<br>';
        banError ++;
    }
    
    if( $("#altaInventariosInd_sku").val() == '' ){
        mensaje += 'Favor de ingresar el sku<br>';
        banError ++;
    }
    
    if( $("#altaInventariosInd_modelo").val() == '' ){
        mensaje += 'Favor de ingresar el modelo<br>';
        banError ++;
    }
    
    if( $("#altaInventariosInd_cantidad").val() == '' ){
        mensaje += 'Favor de ingresar la cantidad<br>';
        banError ++;
    }


    if( banError > 0 ){
        dialogoAviso( 'Inventario Individual' , mensaje );
    }else{
        abreModalSistema();
        $( '#inventarioIndividual' ).submit();
    }

    return false;
}

function guardaItemLoteInventario(){
    var rutaFinal = $("#altaInventariosInd_rutaFinalImg").val();
    var comboAlmacen = $("#altaInventarios_comboAlmacenes").val();
    var comboCliente = $("#altaInventarios_comboClientes").val();    
    var datosFormEntradaIndividual = $("#inventarioIndividual").serialize();
	
    //Validamos datos obligatorios}
    if(comboAlmacen == "" || comboCliente == ""){	
    	msg = "Por favor seleccione Almacen y Cliente.";
        dialogoAviso( 'Carga Individual Inventario' , msg );
    }else{	
        //Ejecutamos ajax para guardar datos del item capturado en base de datos
        $.post( "../Inventarios/guardaItemLote/"+datosFormEntradaIndividual+"/", {comboAlmacen: comboAlmacen, comboCliente: comboCliente, rutaFinal: rutaFinal}, function( mensaje ){ 
		alert(mensaje);
    		if(mensaje == "1"){
    	            msg = "Su informaci&oacute;n ha sido guardada correctamente.";
                    dialogoAviso( 'Carga Individual Inventario' , msg );
                     //Vaciamos datos form
                     $("#altaInventarios_comboAlmacenes").val("");
                     $("#altaInventarios_comboClientes").val("");
		    
                     $("#inventarioIndividual").get(0).reset();
                }else{
                    msg = "Error al guardar informaci&oacute;n, por favor intente mas tarde.";
                    dialogoAviso( 'Carga Individual Inventario' , msg );
                }
    	});
    }
//    return false;
}

function seleccionaCargaMasiva( elemento ) {
    if( $( elemento ).prop( 'checked' ) ){
            $( '#altaInventarios_MetodoEntradaMasiva' ).attr( 'disabled' , false );
            $( '#altaInventarios_MetodoEntradaIndividual' ).attr( 'disabled' , true );
            $( '#altaInventarios_seleccionaEntradaIndividual' ).attr( 'checked' , false );
            $( '#contenedorCargaIndividual' ).hide();
            $( '#contenedorCargaMasiva' ).show('fast');
        }else{
            $( '#altaInventarios_MetodoEntradaMasiva' ).attr( 'disabled' , true );
            $( '#altaInventarios_seleccionaEntradaIndividual' ).attr( 'checked' , true );
            $( '#altaInventarios_MetodoEntradaIndividual' ).attr( 'disabled' , false );
            $( '#contenedorCargaIndividual' ).show('fast');
            $( '#contenedorCargaMasiva' ).hide();
    }
}

function seleccionaCargaIndividual( elemento ) {
    if( $( elemento ).prop( 'checked' ) ){
            $( '#altaInventarios_MetodoEntradaIndividual' ).attr( 'disabled' , false );            
            $( '#contenedorCargaIndividual' ).show('fast');
            $( '#contenedorCargaMasiva' ).hide();
            $( '#altaInventarios_MetodoEntradaMasiva' ).attr( 'disabled' , true );
            $( '#altaInventarios_seleccionaEntradaMasiva' ).attr( 'checked' , false );
            $( '#altaInventariosIndBotonMasLote' ).attr( 'disabled' , false );
        }else{
            $( '#altaInventarios_MetodoEntradaIndividual' ).attr( 'disabled' , true );
            $( '#contenedorCargaIndividual' ).hide();
            $( '#contenedorCargaMasiva' ).show('fast');
            $( '#altaInventarios_MetodoEntradaMasiva' ).attr( 'disabled' , false );
            $( '#altaInventarios_seleccionaEntradaMasiva' ).attr( 'checked' , true );
    }
}

function procesaAltaMasivaLayout() {
    banError = 0;
    mensaje  = '';

    if( $('#altaInventarios_comboAlmacenes').val() == '' ){
        mensaje += 'No ha seleccionado un alamc&eacute;n<br>';
        banError ++;
    }

    if( $('#altaInventarios_comboClientes').val() == '' ){
        mensaje += 'No ha seleccionado un cliente<br>';
        banError ++;
    }
    
    if( $('#altaInventarios_LayoutAdjuntar').val() == '' ){
        mensaje += 'No ha seleccionado un layout<br>';
        banError ++;
    }else{
        extension  = '.csv';
        extension2 = '.xls';
        ext = ($('#altaInventarios_LayoutAdjuntar').val().substring($('#altaInventarios_LayoutAdjuntar').val().lastIndexOf("."))).toLowerCase(); 
        if( extension != ext && extension2 != ext ){
            mensaje += 'El archivo seleccionado no es CSV ni XLS<br>';
            banError ++;
        }
    }

    if( banError > 0 ){
            dialogoAviso( 'Error al procesar Layout' , mensaje );
        }else{
            abreModalSistema();
            $( '#altaInventarios_Formulario' ).submit();
    }

    return false;
}

function resultadoProcesoLayut( mensaje ) {
    cierraModalSistema();
    dialogoAviso( 'Alta de Layout' , mensaje );
    $( '#altaInventarios_Formulario' ).trigger( 'reset' );
}

function resultadoProcesoImagen( mensaje ){
    cierraModalSistema();
    $("#altaInventariosInd_rutaFinalImg").val(mensaje);    
    if(mensaje == "1"){ msg = "La informaci&oacute;n ha sido guardada correctamente."; }
    else{ msg = "Ocurrio un error, por favor intente mas tarde."; }
    dialogoAviso( 'Inventario Individual' , msg );
    $("#altaInventarios_comboAlmacenes").val("");
    $("#altaInventarios_comboClientes").val("");
    $("#inventarioIndividual").get(0).reset();
}

function muestraDetallePorLayout() {
    id = $( '#HistorialLayoutsProcesados' ).jqGrid ( 'getGridParam' , 'selrow' );
    if( id == undefined ){
        dialogoAviso( 'Error visualizar lote' , 'No ha seleccionado un elemento' );
    }else{
        location.replace('/Inventarios/detalleLayoutDescarga/id='+id+'/');
    }
}
