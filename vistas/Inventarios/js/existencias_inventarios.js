/* 
 *  * Controlador de interfaz de la pantalla de exitencias individuales por almacen
 *   * @Autor Mexagon.net / Carlos Reyes
 *    * @Fecha Enero 2016
 *     */

$('#existencias_btnAgrega').button().click(function(){
    agregaExistencias();
});

$( '#existencias_busquedaSKU' ).autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "../../Inventarios/skuAutocomplete/",
            dataType: "json",
            data: {
                term : request.term,
                cli : $( '#existenciasComboClientes' ).val()
            },
            success: function(data) {
                response(data);
            }
        });
    },
    minLength: 2,
    select: function( event, ui ) {
        $( '#existencias_busquedaSKUhidden' ).val( ui.item.id );
    }
});

function agregaExistencias() {
    var sku      = $( '#existencias_busquedaSKUhidden' ).val();
    var almacen  = $( '#movInventarios_almacenEntrada' ).val();
    var cantidad = $( '#existencias_cantidad' ).val();
    var error    = 0;
    var mensaje  = '';
    
    if( sku == '' ){
        mensaje += 'No ha selecionado un SKU<br>';
        error ++;
    }
    
    if( almacen == '' ){
        mensaje += 'No ha seleccionado un almac&eacute;n<br>';
        error ++;
    }
    
    if( cantidad=='' || isNaN( cantidad ) ){
        mensaje += 'No ha asingnado una cantidad correcta<br>';
        error ++;
    }
    
    if( error > 0 ){
            dialogoAviso( 'Error al agregar existencias' , mensaje );
        }else{
            $.post( '../../Inventarios/altaExistenciasSKU/' , { sku:sku, almacen:almacen, cantidad:cantidad } , function( resp ){
                dialogoAviso( 'Alta de existencias' , resp );
                $( '#existencias_busquedaSKUhidden' ).val('');
                $( '#movInventarios_almacenEntrada' ).val('');
                $( '#existencias_cantidad' ).val('');
            });
    }
    
}

/*
 * Ajustes 2017
 */
$( '#btnNew_agregaExistencias' ).button().click(function( e ){
    e.preventDefault();
    buscaExistenciasPorSKUYAlmacen();
});

$( '#nvoExistencias_skuSurtir' ).keyup(function( e ){
    if( isEnter( e ) ){ buscaExistenciasPorSKUYAlmacen(); }
});

function buscaExistenciasPorSKUYAlmacen() {
    sku = $( '#nvoExistencias_skuSurtir' ).val();
    if( sku == '' ){
        mensaje = 'No ha especificado un SKU a surtir';
        dialogoAviso( 'Error surtir existencias' , mensaje );
    }else{
        $.post( '../../Inventarios/OpcionesSurtirSKU/', {sku:sku} , function( html ){
            $( '#nvoSurtidoContenedor' ).html( html );
        });
    }
}

function surtirSKU( indice ) {
    origen      = $( '#nvoSurtido_origen_'+indice ).val();
    existencias = $( '#nvoSurtido_existencias_' ).val();
    cliente     = $( '#nvoSurtido_cliente_'+indice ).val();
    cantidad    = $( '#nvoSurtidoExistencias_cantidadAgregar_'+indice ).val();
    sku         = $( '#nvoExistencias_skuSurtir' ).val();

    if( cantidad == '' || cantidad <= 0 ) {
        dialogoAviso( 'Error al agregar existencias' , 'No ha especificado una cantidad v&aacute;lida' );
    } else {
        $.post( '../../Inventarios/generaNuevasExistencias/' , {origen:origen, existencias:existencias, cliente:cliente, cantidad:cantidad, sku:sku} , function( d ) {
            if( d == 1 ){
                dialogoAviso( 'Surtido SKU' , 'Se han agregado las existencias' );
            }else{
                dialogoAviso( 'Surtido SKU' , 'Error al agregar existencias' );
            }
            $( '#nvoSurtidoContenedor' ).html( '' );
        });
    }

}

function capturaDatosValeEntrada() {
    $( 'body' ).append( '<div id="contenedorDatosValeEntrada" name="contenedorDatosValeEntrada" title="Datos Vale Entrada"></div>' );
    $( '#contenedorDatosValeEntrada' ).load( '../../Inventarios/ValeEntradasInventario/' ).dialog({
        modal:true, draggable: false, closeOnEscape: falso, resizable: false, width:'750', height:'250',
        buttons:{
            'Aceptar':function() {
                datos = $( '#formDatosValeEntrada_Inventarios' ).serialize();
                $.post( '../../Inventarios/guardaInformacionValeEntrada/'+datos+'/' , function( respS ){
                    resp = respS;
                });
            },
            'Cancelar': function() {
                $( this ).dialog( 'close' );
                $( this ).dialog( 'destroy' );
                $( '#contenedorDatosValeEntrada' ).remove();
            }
        }
    });
}
