/* 
 * Control de interfaz grafica para la salida de almacenes
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Mayo 2017
 */

/*
 * Botones
 */
$( '#btnSaludas_buscaExistenciasParaDescontar' ).button().click(function(f){
    f.preventDefault();
    buscaExistenciasParaSalidas();
});

/*
 * Eventos 
 */
$( '#salidasAlmacen_skuBaja' ).keyup(function( e ){
    if( isEnter( e ) ){ buscaExistenciasParaSalidas(); }
});

/*
 * Funciones
 */
function buscaExistenciasParaSalidas() {
    sku = $( '#salidasAlmacen_skuBaja' ).val();
    if( sku == '' ){
        mensaje = 'No ha especificado un SKU para salidas';
        dialogoAviso( 'Error surtir existencias' , mensaje );
    }else{
        $.post( '../../Inventarios/OpcionesSalidaSKU/', {sku:sku} , function( html ){
            $( '#opcionesSalidasContenedor' ).html( html );
        });
    }
}

function salidaSKU( indice ) {
    origen      = $( '#salidasAlmacen_origen_'+indice ).val();
    existencias = $( '#salidasAlmacen_existencias_' ).val();
    cliente     = $( '#salidasAlmacen_cliente_'+indice ).val();
    cantidad    = $( '#salidasAlmacen_cantidadSalir_'+indice ).val();
    sku         = $( '#salidasAlmacen_skuBaja' ).val();

    if( cantidad == '' || cantidad <= 0 ) {
        dialogoAviso( 'Error al agregar existencias' , 'No ha especificado una cantidad v&aacute;lida' );
    } else {
        $.post( '../../Inventarios/generaSalidaExistencias/' , {origen:origen, existencias:existencias, cliente:cliente, cantidad:cantidad, sku:sku} , function( d ) {
            if( d == 1 ){
                dialogoAviso( 'Salida SKU' , 'Se han ejecutado las salidas de inventario' );
            }else{
                dialogoAviso( 'Salida SKU' , 'Error al agregar salida' );
            }
            $( '#opcionesSalidasContenedor' ).html( '' );
        });
    }
}
