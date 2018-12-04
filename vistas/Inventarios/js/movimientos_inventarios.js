/* 
 * Controlador de la interfaz grafica para la funcionalidad de movimientos en
 * almacenes del modulo de Inventarios
 * @Autor Mexagon.net
 * @Fecha Enero 2016
 */

$( '#movInventarios_almacenSalida' ).change(function(){
    if( $(this).val() == "" ) {
        $( '#movInventarios_almacenEntrada' ).empty();
    }else{
        /* Almacen destino de acuerdo al almacen de salida */
        $.post( '/Inventarios/cargaAlmacenesEntradaTraspaso/id='+$(this).val()+'/' , function( d ){
            $( '#movInventarios_almacenEntrada' ).empty();
            var arr = JSON.parse( d );
            $.each( $(arr) ,function( key , value ){
               $( '#movInventarios_almacenEntrada' ).append('<option value=' + value.id + '>' + value.clave + '</option>');
            });
        });
        
        /* Layouts disponibles de acuerdo al almacen de salida */
        $.post( '/Inventarios/cargaLayoutsTraspasoAlmacenSalida/id='+$(this).val()+'/' , function( d ){
            $( '#movInventarios_seleccionaLayout' ).empty();
            var arr = JSON.parse( d );
            $.each( $(arr) ,function( key , value ){
               $( '#movInventarios_seleccionaLayout' ).append('<option value=' + value.id + '>' + value.clave + '</option>');
            });
        });
        
    }    
});

$( '#movInventarios_almacenEntrada' ).change(function(){    
});

$( '#movInventarios_seleccionaLayout' ).change(function(){    
});

$( '#movInventarios_botonTraspaso' ).button().click( function() {
    trasladoInventarios();
});

$( '#movInventarios_botonTraspasoInd' ).button().click( function() {
    trasladoInventariosInd();
});

$( '#movInventarios_busquedaSKU' ).autocomplete({
    source: "../../Inventarios/skuAutocomplete/",
    minLength: 2,
    select: function( event, ui ) {
        $( '#movInventarios_busquedaSKUhidden' ).val( ui.item.id );
    }
});

function trasladoInventarios() {
    var almacenEntrada = $( '#movInventarios_almacenEntrada' ).val();
    var almacenSalida  = $( '#movInventarios_almacenSalida' ).val();
    var loteLayout     = $( '#movInventarios_seleccionaLayout' ).val();
    var mensaje = '';
    var ban     = 0;
    
    if( almacenSalida == '' ){
        mensaje += 'No ha seleccionado un almacen de salida<br />';
        ban ++;
    }

    if( almacenEntrada == '' ){
        mensaje += 'No ha seleccionado un almacen de entrada<br />';
        ban ++;
    }
    
    if( almacenEntrada != '' && ( almacenEntrada == almacenSalida ) ){
        mensaje += 'El almacen de entrada no puede ser el mismo que el almacen de salida<br />';
        ban ++;
    }
    
    if( loteLayout == '' ){
        mensaje += 'No ha seleccionado un lote/layout a trasladar';
        ban ++;
    }
    
    if( ban > 0 ){
            dialogoAviso( 'Error al trasladar inventario' , mensaje );
        }else{
            $.post( '/Inventarios/trasladoDeInventarios/' , { almacenSalida:almacenSalida, almacenEntrada:almacenEntrada, loteLayout:loteLayout } , function( resp ){
                dialogoAviso( 'Traslado de Inventario' , resp );
                $( '#movInventarios_almacenEntrada' ).val('');
                $( '#movInventarios_almacenSalida' ).val('');
                $( '#movInventarios_seleccionaLayout' ).val('');
            });
    }
}

function trasladoInventariosInd() {
    var almacenEntrada = $( '#movInventarios_almacenEntrada' ).val();
    var almacenSalida  = $( '#movInventarios_almacenSalida' ).val();
    var sku            = $( '#movInventarios_busquedaSKUhidden' ).val();
    var piezas         = $( '#movInventarios_busquedaSKUPiezas' ).val();
    var mensaje = '';
    var ban     = 0;
    
    if( almacenSalida == '' ){
        mensaje += 'No ha seleccionado un almacen de salida<br />';
        ban ++;
    }

    if( almacenEntrada == '' ){
        mensaje += 'No ha seleccionado un almacen de entrada<br />';
        ban ++;
    }
    
    if( almacenEntrada != '' && ( almacenEntrada == almacenSalida ) ){
        mensaje += 'El almacen de entrada no puede ser el mismo que el almacen de salida<br />';
        ban ++;
    }
    
    if( sku == '' ){
        mensaje += 'No ha proporcionado un SKU a trasladar';
        ban ++;
    }

    if( piezas == '' || piezas == 0 || isNaN(piezas) ){
        mensaje += 'No ha proporcionado la cantidad de piezas a trasladar';
        ban ++;
    }
    
    if( ban > 0 ){
            dialogoAviso( 'Error al trasladar inventario' , mensaje );
        }else{
            $.post( '/Inventarios/trasladoDeInventariosIndividual/' , { almacenSalida:almacenSalida, almacenEntrada:almacenEntrada, sku:sku , piezas:piezas } , function( resp ){
                dialogoAviso( 'Traslado de Inventario' , resp );
                $( '#movInventarios_almacenEntrada' ).val('');
                $( '#movInventarios_almacenSalida' ).val('');
                $( '#movInventarios_busquedaSKU' ).val('');
            });
    }
}

/* Movimiento individual de inventarios */
$( '#movInventariosInd_BuscarSKU' ).button().click( function( e ){
    e.preventDefault();
    sku = $( '#movInventariosInd_skuMover' ).val();
    $.post( '/Inventarios/movIndividualBusquedaSKU/' , { sku:sku } , function( d ){
        $( '#nomInventariosInd_detalleSKUBuscado' ).html( d );
    });
});

function nuevoTraspasoIndividual( indice ) {
    sku            = $( '#movIndividualNuevo_sku_'+indice ).val();
    cliente        = $( '#movIndividualNuevo_cliente_'+indice ).val();
    cantidadMover  = $( '#movIndividualNuevo_cantidadMover_'+indice ).val();
    existencias    = $( '#movIndividualNuevo_existencias_'+indice ).val();
    almacenOrigen  = $( '#movIndividualNuevo_origen_'+indice ).val();
    almacenDestino = $( '#movIndividualNuevo_almacenDestion_'+indice ).val();

    if( parseInt(existencias) < parseInt(cantidadMover) ) {
            dialogoAviso( 'Error al trasladar inventario' , '<center>No hay suficientes existencias para mover la cantidad especificada.</center>' );
        } else if( cantidadMover == 0 ) {
            dialogoAviso( 'Error al trasladar inventario' , '<center>La cantidad a mover debe ser mayor a cero.</center>' );
        } else {
            $.post( '/Inventarios/enviaNuevoTraspasoIndividual/' , {sku:sku, cliente:cliente, cantidadMover:cantidadMover, almacenOrigen:almacenOrigen, almacenDestino:almacenDestino} , function( resp ){
                if( resp == 'OK' ) {
                        dialogoAviso( 'Traslado Individual' , '<center>La solicitud de traslado se ha realizado.</center>' );
                    } else {
                        dialogoAviso( 'Error al trasladar inventario' , '<center>Ocurri&oacute; un error al solicitar el traslado, int&eacute;ntelo m&aacute;s tarde.</center>' );
                }
            });            
    }
}

