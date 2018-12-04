/* 
 * Archivo para interaccion del sistema con la interfaz grafica del modulo de inventarios
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Enero 2016
 */

function select_row( id ){
    /*$('body').append( '<div id="muestraDetalleLote" title=".:: Detalle Inventario | Informaci&oacute;n por Lotes ::."></div>' );
    $('#muestraDetalleLote').load('/Inventarios/informacionPorLotes/id='+id+'/').dialog({
        modal:true, draggable:false, closeOnEscape: false, resizable:false,width:800,height:450,
        buttons:{
            'Cerrar':function(){
                $( this ).dialog( 'close' );
                $( this ).dialog( 'destroy' );
                $( '#muestraDetalleLote' ).remove();
            }
        }
    });*/
}

function muestraDetalleLotes(){
    id = $( '#ConsultaInventarios' ).jqGrid ( 'getGridParam' , 'selrow' );
    if( id == undefined ){
        dialogoAviso( 'Error visualizar lote' , 'No ha seleccionado un elemento' );
    }else{
        $('body').append( '<div id="muestraDetalleLote" title=".:: Detalle Inventario | Informaci&oacute;n por Lotes ::."></div>' );
        $('#muestraDetalleLote').load('/Inventarios/informacionPorLotes/id='+id+'/').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:1200,height:450,
            buttons:{
                'Cerrar':function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#muestraDetalleLote' ).remove();
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}

function generaFichaTecnica( id ){
    id   = $( '#ConsultaInventarios' ).jqGrid ( 'getGridParam' , 'selrow' );
    idty = $( '#ConsultaInventarios' ).jqGrid( 'getCell' , id , 'idty' );

    if( id == undefined ){
        dialogoAviso( 'Error visualizar lote' , 'No ha seleccionado un elemento' );
    }else{
        $('body').append( '<div id="muestraFichaTecnicaItem" title=".:: Detalle Inventario | Ficha T&eacute;cnica ::."></div>' );
        $('#muestraFichaTecnicaItem').load('/Inventarios/fichaTecnicaItem/id='+id+'|idty='+idty+'/').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:800,height:520,
            buttons:{
                'Cerrar':function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#muestraFichaTecnicaItem' ).remove();
                },
                'Descargar PDF': function(){
                    location.replace( '/Inventarios/generaPDFFichaTecnicaItem/id='+id+'/' );
                }
            }
        });
    }
}

function eliminaItemInventarios() {
    id      = $( '#ConsultaInventarios' ).jqGrid ( 'getGridParam' , 'selrow' );
    almacen = $( '#ConsultaInventarios' ).jqGrid ( 'getCell' , id , 'almacen' );alert( almacen );
    sku     = $( '#ConsultaInventarios' ).jqGrid ( 'getCell' , id , 'sku' );alert( sku );

    if( id == undefined ){
        dialogoAviso( 'Error eliminar elemento' , 'No ha seleccionado un elemento para eliminar' );
    }else{
        msj = "Se eliminaran las existencias del SKU "+ sku +" en el almacen "+almacen+", esta operaci&oacute;n no se podr&aacute; deshacer, desea continuar?";
        $('body').append( '<div id="eliminaElementoInventarios" name="eliminaElementoInventarios" title=".:: Detalle Inventario | Elimina Elemento ::."><center>'+msj+'</center></div>' );
        $('#eliminaElementoInventarios').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:450,height:120,
            buttons:{
                'Cancelar':function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#eliminaElementoInventarios' ).remove();
                },
                'Si, Eliminar': function(){
                    var options = {buttons: {}};
                    $.post( '/Inventarios/eliminaElementoInventario/id='+id+'|almacen='+almacen+'|sku='+sku+'/' , function( d ){
                        if( d == "OK" ){
                            $( '#eliminaElementoInventarios' ).html('<center>Elemento eliminado</center>');
                        }else{
                            $( '#eliminaElementoInventarios' ).html('<center>Error al eliminar</center>');
                        }
                    });
                    options = {
                        buttons: {
                            'Aceptar':function(){
                                $( this ).dialog( 'close' );
                                $( this ).dialog( 'destroy' );
                                $( '#eliminaElementoInventarios' ).remove();
                                $( '#ConsultaInventarios' ).trigger('reloadGrid');
                            }
                        }
                    };
                    $("#eliminaElementoInventarios").dialog('option', options);
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();
    }
}

function editaItemInventarios() {
    id   = $( '#ConsultaInventarios' ).jqGrid ( 'getGridParam' , 'selrow' );
    idty = $( '#ConsultaInventarios' ).jqGrid( 'getCell' , id , 'idty' );
    
    if( id == undefined ){
        dialogoAviso( 'Error eliminar elemento' , 'No ha seleccionado un elemento para editar' );
    }else{
        $('body').append( '<div id="editaItemInventario" title=".:: Detalle Inventario | Edita Elemento ::."></div>' );
        $('#editaItemInventario').load('/Inventarios/editaItemInventario/id='+id+'|idty='+idty+'/').dialog({
            modal:true, draggable:false, closeOnEscape: false, resizable:false,width:900,height:550,
            buttons:{
                'Guardar Cambios':function(){
                    validacionCamposObligatoriosEdicionItem();
                },
                'Cancelar': function(){
                    $( this ).dialog( 'close' );
                    $( this ).dialog( 'destroy' );
                    $( '#editaItemInventario' ).remove();
                }
            }
        }).parent('.ui-dialog').find('.ui-dialog-titlebar-close').hide();        
    }
}

function validacionCamposObligatoriosEdicionItem() {
    var comboAlmacen = $("#altaInventarios_comboAlmacenes").val();
    var comboCliente = $("#altaInventarios_comboClientes").val();    
    var comboUPeso   = $("#altaInventariosInd_unidadPeso").val();    
    var comboUMedida = $("#altaInventariosInd_uMedida").val();    
    
    if(comboAlmacen == "" || comboCliente == ""){
    	msg = "Por favor seleccione Almacen y Cliente.";
        dialogoAviso( 'Edicion Individual Inventario' , msg );
    }else if(comboUPeso == "" || comboUMedida == ""){
        msg = "Por favor seleccione unidades de peso y medida.";
        dialogoAviso( 'Edicion Individual Inventario' , msg );
    }else{
        guardaEdicionItemInventario();
    }
}

function guardaEdicionItemInventario(){
    $( '#inventarioIndividualEdicion' ).submit();
}

function resultadoProcesoEdicionItem( mensaje ){
    $('#editaItemInventario').dialog( 'close' );
    $('#editaItemInventario').dialog( 'destroy' );
    $('#editaItemInventario').remove();
    dialogoAviso( 'Edicion Individual Inventario' , mensaje );
    $( '#ConsultaInventarios' ).trigger( 'reloadGrid' );
}
