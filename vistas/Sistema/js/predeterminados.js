/* 
 *  * Interaccion de la interfaz grafica de la pantalla de valores predefinidos
 *   * @Autor Mexagon.net / Carlos Reyes
 *    * @Fecha Enero 2016
 *     */

$( '#predeterminados_guardaInfo' ).button().click(function(e){
    e.preventDefault();
    guardaPredeterminados();
});

function guardaPredeterminados(){
    var datos = $( '#predeterminados_form' ).serialize();
    $.post( '/Sistema/guardaPredeterminados/?' + datos  , function( d ){
        if( d == 0){
                dialogoAviso( 'Datos Predefinidos' , 'Los datos se han actualizado correctamente' );
            }else{
                dialogoAviso( 'Error Datos Predefinidos' , 'Se present&oacute; un error al actualizar los datos, intente m&aacute;s tarde' );
        }
    });
    return false;
}

