/*
 * Eventos de la intetfaz grafica del listado de movimientos para la creacion
 * de vales de entrada/salida de inventarios
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Mayo 2017
 */

$( '#valeEntradaSalida_fechaMovimiento' ).datepicker({
    dateFormat:'yy-mm-dd'
});

$( '#valeEntradaSalida_fechaPedido' ).datepicker({
    dateFormat:'yy-mm-dd'
});

function generaValeEntradaSalida() {
    id  = $( '#ListadoMovimientosES' ).jqGrid ( 'getGridParam' , 'selrow' );
    mov = $( '#ListadoMovimientosES' ).jqGrid( 'getCell' , id , 'tipo' );

    if( id == undefined ){
        dialogoAviso( 'Error visualizar lote' , 'No ha seleccionado un elemento' );
    }else{
        $( '#contenedorVentanaDatosVale' ).remove();
        $( 'body' ).append( '<div id="contenedorVentanaDatosVale" name="contenedorVentanaDatosVale" title="Vale de '+mov+'"></div>' );
        $( '#contenedorVentanaDatosVale' ).load( '/Inventarios/ValeEntradasInventario/id='+id+'/' ).dialog({
            modal:true, draggable: false, closeOnEscape: false, resizable:false, width:'750',height:'355',
            buttons:{
                'Guardar Informacion y Genera PDF':function() {
                    msjError = "<center><b>La informaci&oacute;n est&aacute; incompleta:</b></center><br>";
                    ban = 0;
                    if( $( '#valeEntradaSalida_noPedido' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado el N&uacute;mero de Pedido.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_fechaPedido' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado la fecha de Pedido.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_solicitante' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado el nombre del solicitante.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_autorizante' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado el nombre del autorizante.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_nombreRecoge' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado el nombre de la persona que recoge el pedido.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_nombreRecibe' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado el nombre de la persona que solicita el pedido.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_nombreGuardia' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado el nombre del guardia.<br>";
                        ban ++;
                    }
                    if( $( '#valeEntradaSalida_fechaMovimiento' ).val() == '' ) {
                        msjError += "&bull;No ha proporcionado la fecha en que se realiza el movimiento.<br>";
                        ban ++;
                    }
                    if( ban > 0 ){
                        dialogoAviso( 'Error al crear vale' , msjError );
                    } else {
                        datos = $( '#formDatosValeEntrada_Inventarios' ).serialize();
                        $.post( '/Inventarios/guardaInformacionVale/?'+datos , function( r ) {
                            if( r == '1' ) {
                                    msj = "<center>La informacion se ha guardado correctamente</center>";
                                    location.replace( '/Inventarios/generaValeEntradaSalida/id='+id+'/' );
                                } else {
                                    msj = "<center>Ocurri&oacute; un error al guardar la informaci&oacute;n</center>";
                            }
                            $( this ).dialog( 'close' );
                            $( this ).dialog( 'destroy' );
                            $( '#contenedorVentanaDatosVale' ).remove();
                            dialogoAviso( 'Informaci&oacute;n Vale' , msj );
                        });
                    }
                },
                'Cancelar': function() {
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( this ).remove();
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}

function verificaTipoMovimiento() {
    idMov = $( '#valeEntradaSalida_IDMovimiento' ).val();
    creado = $( '#valeEntradaSalida_creado' ).val();
    if( creado == "1" ) {
        $.post( '/Inventarios/obtieneMotivoMovimiento/id='+idMov+'/' , function( val ) {
            $( '#valeEntradaSalida_motivoMovimiento' ).val( val );
        });
    }
}

function valeMasivo() {
    alert("vale masivo...");
}