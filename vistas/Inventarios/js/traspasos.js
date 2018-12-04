/* 
 * Interfaz grafica para el control de aceptacion de inventarios
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Noviembre 2016
 */

function procesarTraslado() {
    id      = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getGridParam' , 'selrow' );
    origen  = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'origen');
    destino = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'destino');
    layout  = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'layout');
    sku     = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'sku');
    total   = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'total');
    estado  = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'estado');
    comment = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getCell', id, 'comentarios');
    
    if( id == undefined ){
        dialogoAviso( 'Error al procesar taslado' , 'No ha seleccionado una opci&oacute;n' );
    }else{
        $('body').append( '<div id="procesaTrasladoInventario" title=".:: Inventarios | Procesar Traslado ::."></div>' );
        $('#procesaTrasladoInventario').load('/Inventarios/procesarTrasladoIndividual/id='+id+'|sku='+sku+'|comentarios='+escape(comment)+'|total='+total+'|layout='+escape(layout)+'|origen='+escape(origen)+'|destino='+escape(destino)+'/').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:700,height:200,
            buttons:{
                'Trasladar':function() {
                    if( estado == 'Trasladado' ){
                        dialogoAviso('Traslado de Inventarios','<center>El traslado ya se ha procesado</center>');
                    } else {
                        $.post( '/Inventarios/aplicarTraslado/id='+id+'|comentarios='+escape($('#observacionesTrasladoAplicar').val())+'/' , function( d ){                            
                            dialogoAviso('Traslado de Inventarios','<center>Inventario trasladado correctamente</center>');
                        });
                    }
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#procesaTrasladoInventario' ).remove();
                },
                'Declinar':function() {
                    if( estado == 'Trasladado' ){
                        dialogoAviso('Traslado de Inventarios','<center>El traslado ya se ha procesado</center>');
                    } else {
                        $.post( '/Inventarios/rechazaTraslado/id='+id+'|comentarios='+escape($('#observacionesTrasladoAplicar').val())+'/' , function( d ){                            
                            dialogoAviso('Traslado de Inventarios','<center>Traslado rechazado</center>');
                        });
                    }
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#procesaTrasladoInventario' ).remove();
                },
                'Cerrar':function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#procesaTrasladoInventario' ).remove();
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}

function descargarFormato() {
    id = $( '#ListadoAutorizacionesTraslados' ).jqGrid ('getGridParam' , 'selrow' );
    $( '#descargaValeSalidaMercancia' ).remove();

    if( id == undefined ){
        dialogoAviso( 'Error al procesar taslado' , 'No ha seleccionado una opci&oacute;n' );
    } else {
        $( 'body' ).append( '<div title="Vale de Salida de Mercanc&iacute;a" id="descargaValeSalidaMercancia" name="descargaValeSalidaMercancia"></div>' );
        $( '#descargaValeSalidaMercancia' ).load( '/Inventarios/generaFormatoSalida/id='+id+'/' ).dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:500,height:300,
            buttons:{
                'Aceptar':function() {
                    infoForm = $( '#valeSalida_FORM' ).serialize();
                    location.replace( '/Inventarios/generaValeSalida/?'+infoForm+'/' );
                },
                'Cancelar':function() {
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( this ).remove();
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}
