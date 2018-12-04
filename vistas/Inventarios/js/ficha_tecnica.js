/* 
 * Control de la interfaz grafica de la pantalla de ficha tecnica del producto
 * @Autor Mexagon.net / Carlos Reyes
 * @Fecha Febrero 2016
 */

$('#imagenItenFichaTecnica').button().change(function(e){ return adjuntaImagen(); });

function adjuntaImagen(){
    abreModalSistema();
    $( '#formImgItemFichaTecnica' ).submit();
    return false;
}


function resultadoUpdateImagenItem( mensaje ) {
    cierraModalSistema();
    if( mensaje == "1" ){ msg = "La imagen ha sido actualizada correctamente."; }
    else{ msg = "Ocurrio un error, por favor intente mas tarde."; }
    dialogoAviso( 'Detalle Item' , msg );
    var date = new Date();
    $("#imgItem").attr("src","/Inventarios/generaImagenItem/id="+$('#idImagenItemFichaTecnica').val()+"|date="+date.getTime()+"/");
}

